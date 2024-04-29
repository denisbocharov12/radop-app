<?php

namespace App\Http\Controllers\v1\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserRepository;

class UsersController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getUsers();

        return view('users.index', compact([
            'users'
        ]));
    }

    public function show(User $user)
    {
//        $roles = $this->rolesRepository->getAll();

        return view('users.show', compact([
            'user',
//            'roles',
        ]));
    }

    public function addManagerToUser()
    {

    }
}
