<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request){
        if($request->isMethod('post')){
            
            $data=$request->only('mail','password');//'mail'と'password'のみ取得
            
            // ログインが成功したら、トップページへ
            if(Auth::attempt(['mail' => $data["mail"], 'password' => $data["password"]])){
                return redirect('/top');
            }     
        }

        return view("auth.login");

    }
    
    // ログアウトを押したときのページ遷移
    protected function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
