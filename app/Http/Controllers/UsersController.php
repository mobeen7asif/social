<?php

namespace App\Http\Controllers;

use App\Repositories\UsersRepository;
use App\Http\Requests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    private $usersRepo = null;
    public function __construct(UsersRepository $usersRepo)
    {
        $this->usersRepo = $usersRepo;
    }
    public function postSignUp(Requests\User\AddUserRequest $request)
    {
        $user = $this->usersRepo->store($request->storableAttrs());
        Auth::login($user);
        

    }

    public function postSignIn()
    {

    }
}