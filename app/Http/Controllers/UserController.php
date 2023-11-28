<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;

class UserController extends Controller
{

    public function __construct(private UserService $srvUser){}

    public function index(UserRequest $request)
    {
        $filters = $request->validated();
        $usersQuery  = User::query();
        $usersQuery  = $this->srvUser->getBySearch($usersQuery, $filters);
        $users = $usersQuery->with(['company'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Users/Index',[
            'users' => $users,
            'filters' => $filters
        ]);

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
