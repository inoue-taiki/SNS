<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     
   
    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    
    //ページ遷移してもデータを引き継ぐための記述  
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'mail' => $data['mailadress'],
            'password' => bcrypt($data['password']),
        ]);

    }
     

    //addedの処理
    public function added(){
        
        return view('auth.added');
    }
    
    
    public function register(Request $request)
    {
        
        if($request->isMethod('post')){//入力したものがPOSTリクエストなら
            $data = $request->input();//ユーザーが入力したもの
    
        //  入力値フォーム　バリデーション設定
        $validateRules = [
            'username' => 'required|min:4|max:12|present',
            'mailadress' => 'required|min:4|max:12|present|email',
            'password' => 'required|alpha_num|min:4|max:12',
            'password_confirm' => 'required|alpha_num|min:4|max:12|password',
         ];
     
        $validateMessages = [
           "username.required" => "必須項目です。",
           "username.min" => "4文字以上12文字以内で入力してください。",
           "username.max" => "4文字以上12文字以内で入力してください。",
           "mailadress.required" => "必須項目です。",
           "mailadress.min" => "4文字以上12文字以内で入力してください。",
           "mailadress.max" => "4文字以上12文字以内で入力してください。",
           "mailadress.present" => "このメールアドレスは登録済みです。",
           "mailadress.email" => "メールアドレスの形式で入力してください。",
           "password.required" => "必須項目です。",
           "password.alpha_num" => "英数字で入力してください。",
           "password.min"=>"4文字以上12文字以内で入力してください。",
           "password.max"=>"4文字以上12文字以内で入力してください。",
           "password.password" => "パスワードが一致しません。",
        ];

     //バリデーションをインスタンス化
     $val = Validator::make($request->all(),$validateRules,$validateMessages);
     

     //バリデーションNGの場合
     if($val->fails()){
         return redirect('/register')->withErrors($val)->withInput();
     }
     else{
         //バリデーションに引っかからなかった場合
         $this->create($data);
            return redirect('added')->with("data",$data['username']);//added.phpにユーザーネームのデータを送る
     }
    }
      return view('auth.register');

}
}