<?php

namespace App\Http\Controllers\v1\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAllUsersWithoutManager();

        return view('manager.index', compact([
            'users'
        ]));
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {
        $user = $this->userRepository->getUserById($id);
        $managers = $this->userRepository->getManagers();

        return view('manager.edit', compact([
            'user',
            'managers',
        ]));
    }

    public function update()
    {

    }
}
