<?php
/**
 * Trait para criar abstracoes facilitando o uso dos resources.
 *
 * Permite criar metodos com o prefixo include, os mesmos podem ser chamados
 * no construtor do Resources, com isso tornamos dinamico a decisao se a estrutura
 * do resources e simples ou podera possuir mais campos
 */

namespace App\Http\Resources;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

trait AllResources
{
    /**
     * Persiste a lista de includes instanciados.
     *
     * @var array
     */
    protected $includes = [];

    private $rootIncludes;

    /**
     * Undocumented function.
     *
     * @param [type] $item
     * @param array $includes
     */
    public function __construct($item, $includes = [])
    {
        parent::__construct($item);

        if (! is_array($includes)) {
            $includes = [];
        }

        $this->rootIncludes = $includes;

        if (empty($includes) && ! empty($this->defaultIncludes) && is_array($this->defaultIncludes)) {
            $includes = array_merge($includes, $this->defaultIncludes);
        }

        $requestInclude = request()->input('include');
        if (! empty($requestInclude)) {
            $includes = array_merge($includes, explode(';', $requestInclude));
        }

        // executamos os includes, junto com os que definimos como padrao
        $this->instanceInclude($includes);
        $this->checkShowIncludes();
    }

    public function getIncludes()
    {
        return $this->rootIncludes;
    }

    public function checkShowIncludes(): void
    {
        $isSchema = request()->has('include_schema');
        if (empty($isSchema)) {
            return;
        }

        $methodsIncludes = collect(get_class_methods($this))->filter(function ($item) {
            return str_contains($item, 'include');
        })->map(function ($item) {
            $item = preg_split('/(?=[A-Z])/', $item);
            array_shift($item);

            return strtolower(implode('_', $item));
        });

        if (empty($methodsIncludes) || empty($methodsIncludes->first())) {
            return;
        }

        $this->item('include_schema', $methodsIncludes);
    }

    /**
     * Responsavel por incluir o resources em uma lista,
     * para injetarmos ao data do resource.
     *
     * @param string $key
     * @param [type] $resource
     *
     * @return void
     */
    public function item(string $key, $resource)
    {
        $this->includes[$key] = $resource;
    }

    /**
     * Realiza o resolve do laravel, injetando os includes criados.
     *
     * @param [type] $request
     *
     * @return void
     */
    public function resolve($request = null)
    {
        $data = $this->toArray(
            $request = $request ?: Container::getInstance()->make('request')
        );

        if (! empty($this->includes)) {
            foreach ($this->includes as $key => $resource) {
                $data[$key] = $resource;
            }
        }

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        } elseif ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        return $this->filter((array) $data);
    }

    /**
     * Instancia os metodos de incluides.
     *
     * @param [type] $includes
     *
     * @return void
     */
    private function instanceInclude($includes = null)
    {
        if (empty($includes) || ! is_array($includes)) {
            return;
        }

        foreach ($includes as $method) {
            // converte underline em CamelCase
            $name = 'include'.str_replace('_', '', ucwords($method, '_'));
            if (! method_exists($this, $name)) {
                continue;
            }

            // executa dinamicamente o metodo de include
            $this->$name($this->resource);
        }
    }
}
