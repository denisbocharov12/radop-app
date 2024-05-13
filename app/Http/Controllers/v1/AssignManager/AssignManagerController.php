<?php

namespace App\Http\Controllers\v1\AssignManager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class AssignManagerController extends Controller
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

    public function edit($id)
    {
        $user = $this->userRepository->getUserById($id);
        $managers = $this->userRepository->getManagers();

        return view('manager.edit', compact([
            'user',
            'managers',
        ]));
    }

    public function update(User $user, Request $request)
    {
        $user_id = $request->user;
        $manager_id = $request->manager_id;

        User::role('user')->where('id',$user_id)->first()->update([
            'manager_id'=>$manager_id
        ]);

        return redirect()->route('manager.index');
    }
}
