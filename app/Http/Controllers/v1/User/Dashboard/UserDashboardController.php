<?php

namespace App\Http\Controllers\v1\User\Dashboard;

use App\Http\Controllers\Controller;
//use App\Repositories\Subject\SubjectRepository;
use Illuminate\Support\Facades\Auth;

final class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

//        $subjects = $this->subjectRepository->getByUserId($user->id);

        return view('user.v1.dashboard.dashboard', compact(['user']));
    }
}
