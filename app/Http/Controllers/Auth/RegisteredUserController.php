<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Company;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Person\PersonService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $code = "demo";
        $companyName = "Empresa Demonstrativa";

        $company = Company::firstOrCreate(
            ['code' => $code],
            [
                'uuid' => Uuid::uuid4(),
                'code' => $code,
                'name' => $companyName,
                'status' => Company::STATUS_ACTIVE
            ]
        );

        $user = User::create([
            'uuid' => Uuid::uuid4(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $company->id,
            'is_admin' => false,
            'status' => true,
        ]);

        $srvPerson = app(PersonService::class);
        $srvPerson->save([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'enrollment' => random_int(1000, 9999),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
