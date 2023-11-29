<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

/*
 * Helpers Request.
 */
if (!function_exists('paginate')) {
    function paginate($class, $limit = false)
    {
        // Verifica se a requisição está vindo da API
        $isApiRequest = request()->is('api/*');

        if (empty($limit)) {
            $limit = request()->input('limit');
            if (empty($limit)) {
                $limit = 5;
            }

            if ($limit == 'unlimited') {
                $limit = 5000;
            }
        }

        if ($isApiRequest) {
            if ($limit > 250) {
                $limit = 250;
            }

            $pagination = $class->cursorPaginate($limit);
            $pagination->setPath(request()->fullUrl());
            $pagination->appends(request()->input());

            return $pagination;
        }

        $pagination = $class->paginate($limit);
        $pagination->appends(request()->input());

        return $pagination;
    }
}


// @deprecated
if (! function_exists('filter_search')) {
    function filter_search($inputSearch = '')
    {
        $search = [];
        foreach (filter_search_withOperator($inputSearch) as $param => $value) {
            $search[$param] = $value['value'];
        }

        return $search;
    }
}

// @deprecated
if (! function_exists('filter_search_string')) {
    function filter_search_string($params)
    {
        $result = [];
        foreach ($params as $param => $value) {
            $result[] = "$param:$value";
        }

        return join(';', $result);
    }
}

// @deprecated version
if (! function_exists('filter_search_withOperator')) {
    function filter_search_withOperator($inputSearch = '')
    {
        $params = [];
        if (empty($inputSearch)) {
            return [];
        }

        if (is_array($inputSearch)) {
            return $inputSearch;
        }

        foreach (explode(';', $inputSearch) as $search) {
            $item = explode(':', $search);
            $key = array_shift($item);
            $filter = array_shift($item);
            $filter = (in_array($filter, ['range', 'eq', 'gt', 'gte', 'has', 'it', 'lte', 'in'])) ? $filter : 'eq';
            $item = explode(':', $search);
            $value = array_pop($item);

            if (empty($key)) {
                continue;
            }

            if ($value == 'true') {
                $value = true;
            } elseif ($value == 'false') {
                $value = false;
            }

            $params[$key] = [
                'filter' => $filter,
                'value' => $value ?? '',
            ];
        }

        return $params;
    }
}

if (! function_exists('is_order_by')) {
    function is_order_by()
    {
        return ! empty(request()->input('orderBy'));
    }
}

if (! function_exists('in_include')) {
    function in_include($include)
    {
        $requestInclude = request()->input('include');
        $includes = explode(';', $requestInclude);

        return in_array($include, $includes);
    }
}

if (! function_exists('in_search')) {
    function in_search($filter)
    {
        $search = filter_search(request()->input('search'));

        return $search[$filter] ?? null;
    }
}

if (! function_exists('requests_api')) {
    function requests_api()
    {
        $request = request();
        if (Str::contains($request->header('content-type'), 'application/json')) {
            return true;
        }

        return $request->wantsJson() || $request->ajax() || $request->input('format') == 'json';
    }
}

if (! function_exists('language')) {
    function language(string $type = '')
    {
        $srvLocale = app(App\Services\LocaleService::class);
        if ($type == 'browser') {
            return $srvLocale->getLanguageBrowser();
        }

        return $srvLocale->getLanguage();
    }
}

if (! function_exists('version')) {
    function version()
    {
        $version = (base_path().'/version.php');
        if (! file_exists($version)) {
            return '-';
        }

        return require_once $version;
    }
}

if (! function_exists('time_my_tz')) {
    function time_my_tz(string $time, ?Carbon $date = null)
    {
        if (empty($date)) {
            $date = today();
        }

        [$hour, $minute] = explode(':', $time);

        return $date->clone()->dateTzUTC()
            ->setTime($hour, $minute)
            ->dateMyTz();
    }
}

if (! function_exists('time_my_tz_to_utc')) {
    function time_my_tz_to_utc(string $time, ?Carbon $date = null)
    {
        if (empty($date)) {
            $date = today();
        }

        [$hour, $minute] = explode(':', $time);

        return $date->clone()->dateMyTz()
            ->setTime($hour, $minute)
            ->dateTzUTC();
    }
}

if (! function_exists('time_utc')) {
    function time_utc(string $time, ?Carbon $date = null)
    {
        if (empty($date)) {
            $date = today();
        }

        [$hour, $minute] = explode(':', $time);

        return $date->clone()->setTime($hour, $minute, 0)->dateTzUTC();
    }
}

if (! function_exists('detect_date_format')) {
    function detect_date_format(string $date)
    {
        try {
            $carbonDate = Carbon::createFromFormat('d/m/Y', $date);
        } catch (Exception $e) {
            $carbonDate = null;
        }

        if (! empty($carbonDate)) {
            return $carbonDate;
        }

        try {
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
        } catch (Exception $e) {
            $carbonDate = null;
        }

        return $carbonDate;
    }
}

if (! function_exists('date_format_minutes')) {
    function date_format_minutes(string $minutes, string $serviceTime = '')
    {
        if (empty($serviceTime)) {
            $serviceTime = 1440;
        }

        $negative = $minutes < 0;
        if ($negative) {
            $minutes *= -1;
        }

        $days = intdiv($minutes, $serviceTime);
        $hours = intdiv($minutes % $serviceTime, 60);
        $remainingMinutes = $minutes % 60;

        return sprintf('%s%sd %sh %smin', $negative ? '-' : '', $days, $hours, $remainingMinutes);
    }
}

if (! function_exists('resources')) {
    function resources($class, $model, $includes = [])
    {
        return collect((new $class($model, $includes))->resolve(request()));
    }
}

if (! function_exists('is_api_client')) {
    function is_api_client()
    {
        $route = request()->route();

        return in_array('api.client', $route ? $route->middleware() : []);
    }
}

if (! function_exists('is_app_local')) {
    function is_app_local()
    {
        return env('APP_ENV') == 'local';
    }
}

if (! function_exists('is_app_production')) {
    function is_app_production()
    {
        return env('APP_ENV') == 'production';
    }
}

if (! function_exists('is_app_testing')) {
    function is_app_testing()
    {
        return env('APP_ENV') == 'testing';
    }
}

if (! function_exists('api_url')) {
    function api_url()
    {
        return ! is_app_production() && ! empty(env('LOCAL_TUNNEL_API_URL'))
            ? env('LOCAL_TUNNEL_API_URL')
            : env('API_URL');
    }
}

if (! function_exists('api_auth_url')) {
    function api_auth_url()
    {
        return ! is_app_production() && ! empty(env('LOCAL_TUNNEL_API_URL'))
            ? env('LOCAL_TUNNEL_API_URL')
            : env('API_AUTH_URL');
    }
}

if (! function_exists('is_service_worker')) {
    function is_service_worker()
    {
        return strcasecmp(env('APP_SERVICE_TYPE', 'monolith'), 'worker') == 0;
    }
}

if (! function_exists('is_service_api')) {
    function is_service_api()
    {
        return strcasecmp(env('APP_SERVICE_TYPE', 'monolith'), 'api') == 0;
    }
}

if (! function_exists('is_service_admin')) {
    function is_service_admin()
    {
        return strcasecmp(env('APP_SERVICE_TYPE', 'monolith'), 'painel') == 0
            || strcasecmp(env('APP_SERVICE_TYPE', 'monolith'), 'admin') == 0;
    }
}

if (! function_exists('is_request_app')) {
    function is_request_app()
    {
        return request()->hasHeader('x-app-version')
        || request()->hasHeader('x-app-account');
    }
}

if (! function_exists('is_request_system')) {
    function is_request_system()
    {
        return strtolower(request()->header('User-Agent')) == 'symfony'
        || ! str_contains(strtolower(request()->header('User-Agent')), 'mozilla');
    }
}
