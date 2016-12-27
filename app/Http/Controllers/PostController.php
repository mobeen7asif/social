<?php

namespace App\Http\Controllers;

use App\Repositories\UsersRepository;
use App\Http\Requests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    private $usersRepo = null;
    public function __construct(UsersRepository $usersRepo)
    {
        $this->usersRepo = $usersRepo;
    }

    public function getDashboard()
    {
        return view('dashboard');
    }

    public function postCreatePost(Requests\User\LoginRequest $request)
    {

    }

}