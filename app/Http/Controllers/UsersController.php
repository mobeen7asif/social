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
        return redirect()->route('dashboard');

    }

    public function postSignIn(Requests\User\LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    public function getAccount()
    {
        return view('account' , ['user' => Auth::user()]);
    }

    public function postSaveAccount(Requests\User\SaveAccountRequest $request)
    {


        $file = $request->file('image');
        $public_path = '/images/users/' . Auth::user()->id;
        $destinationPath = public_path($public_path);
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);

        $this->usersRepo->updateWhere(['id' => Auth::user()->id],['first_name' => $request->input('first_name') ,'image' => $public_path . '/' . $filename]);
        return redirect()->back();

    }
    public function getLogOut()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}