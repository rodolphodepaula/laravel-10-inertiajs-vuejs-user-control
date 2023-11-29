<?php
namespace Tests\Api;

use Tests\TestCase;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Company;
use Illuminate\Foundation\Testing\WithFaker;

class ApiUsersTest extends TestCase
{
    use WithFaker;

    public function test_validar_cadastrar_usuario()
    {
        $user = User::factory()->create([
            'email' => 'test@demo.com',
            'password' => bcrypt('password'),
        ]);

        $this->setAuthUser($user);

        $code = "firstdecision";
        $companyName = "First Decision";

        $company = Company::firstOrCreate(
            ['code' => $code],
            [
                'uuid' => Uuid::uuid4(),
                'code' => $code,
                'name' => $companyName,
                'status' => Company::STATUS_ACTIVE
            ]
        );

        $data = [
            'name' => 'A',
            'email' => 'email-invalido',
            'status' => 'invalid',
            'company_uuid' => '123',
            'password' => '12345',
            'password_confirmation' => '123456',
        ];

        $response = $this->api('POST', 'users', $data)
            ->assertStatus(422)
            ->json('errors');

        $this->assertEquals($response['name'][0], "O campo Nome deve ter pelo menos 3 caracteres.");
        $this->assertEquals($response['email'][0], "O campo E-mail deve ser um endereço de e-mail válido.");
        $this->assertEquals($response['status'][0], "O campo Status deve ser verdadeiro (1) ou falso (0).");
        $this->assertEquals($response['company_uuid'][0], "O campo Empresa deve ser um UUID válido.");
        $this->assertEquals($response['password'][0], "A senha deve ter pelo menos 6 caracteres.");

        $data = [
            'name' => 'Rodolpho de Paula',
            'email' => 'rodolpho.paula@developer.com.br',
            'status' => true,
            'company_uuid' => $company->uuid,
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $this->api('POST', 'users', $data)->assertStatus(201);
        $this->assertCount(3, $this->api('GET', 'users')->assertStatus(200)->json('data'));
        $user = $this->api('GET', 'users', [
            'name' => 'rodolpho'
        ])->assertStatus(200)->json('data.0');

        $this->assertEquals($user['email'], 'rodolpho.paula@developer.com.br');
    }

    public function test_mostrar_usuario_cadastrado()
    {
        $user = User::factory()->create([
            'email' => 'test@demo.com',
            'password' => bcrypt('password'),
        ]);

        $this->setAuthUser($user);

        $response = $this->api('GET', 'users/'.$user->uuid)->assertStatus(200)->json('data');
        $this->assertEquals($response['email'], 'test@demo.com');
    }

    public function test_editar_usuario_cadastrado()
    {
        $user = User::factory()->create([
            'email' => 'test@demo.com',
            'password' => bcrypt('password'),
        ]);

        $this->setAuthUser($user);

        $code = "firstdecision";
        $companyName = "First Decision";

        $company = Company::firstOrCreate(
            ['code' => $code],
            [
                'uuid' => Uuid::uuid4(),
                'code' => $code,
                'name' => $companyName,
                'status' => Company::STATUS_ACTIVE
            ]
        );

        $data = [
            'name' => 'Rodolpho de Paula',
            'email' => 'rodolpho.paula@developer.com.br',
            'status' => false,
            'company_uuid' => $company->uuid,
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $response = $this->api('POST', 'users', $data)->assertStatus(201)->json('data');
        $this->api('PUT', 'users/'.$response['uuid'], [
            'name' => 'Rodolpho Silva de Paula',
            'email' => 'rodolpho.paula@developer.co',
            'status' => true,
            'company_uuid' => $company->uuid,
            'password' => '87654321',
            'password_confirmation' => '87654321',
        ])->assertStatus(200);


        $this->api('GET', 'users/'.$response['uuid'])->assertStatus(200)->json('data');
        $response = $this->api('GET', 'users/'.$response['uuid'])->assertStatus(200)->json('data');

        $this->assertEquals($response['email'], 'rodolpho.paula@developer.co');
    }

    public function test_deletar_usuario_cadastrado()
    {
        $user = User::factory()->create([
            'email' => 'test@demo.com',
            'password' => bcrypt('password'),
        ]);

        $this->setAuthUser($user);

        $code = "firstdecision";
        $companyName = "First Decision";

        $company = Company::firstOrCreate(
            ['code' => $code],
            [
                'uuid' => Uuid::uuid4(),
                'code' => $code,
                'name' => $companyName,
                'status' => Company::STATUS_ACTIVE
            ]
        );

        $data = [
            'name' => 'Rodolpho de Paula',
            'email' => 'rodolpho.paula@developer.com.br',
            'status' => false,
            'company_uuid' => $company->uuid,
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $response = $this->api('POST', 'users', $data)->assertStatus(201)->json('data');
        $this->api('DELETE', 'users/'.$response['uuid'])->assertStatus(200);

        $this->assertNull(User::whereUuid($response['uuid'])->first());
    }
}