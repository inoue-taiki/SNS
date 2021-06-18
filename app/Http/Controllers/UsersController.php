<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UsersController extends Controller
{
   

    //プロフィール画面
    public function profile(Request $request){
        $id = Auth::user()->id;//ログインしてる人のID

        $profile = \DB::table('users')->where('id',$id)->first();

        $username = Auth::user()->username; //ユーザー名を引き継ぐ  
        $mail = Auth::user()->mail;//認証ユーザーのメールアドレス
        $password = Hash::make(\DB::table('users')->select('password')->where('password',Auth::user())->get());//認証ユーザーのパスワード

        $bio = Auth::user()->bio;//認証ユーザーのbio
        $images = Auth::user()->images;//認証ユーザーのimages
        
        
        

        //フォロー一覧
        
        $follower = \DB::table('follows')->where('follower',$id)->get();
        
        $follower_user = []; //フォローしている人のID

        //フォローしている人のIDを配列化
        foreach ($follower as $follower_id){//$followingを順に取り出して$follower_idへ代入
            $follower_user[] = $follower_id->follow;
        }

        //フォロワー一覧
        $following = \DB::table('follows')->where('follow',$id)->get();
        
        $following_user = []; //フォローされている人のID

        //フォローされてる人のIDを配列化
        foreach ($following as $following_id){//$followingを順に取り出して$following_idへ代入
            $following_user[] = $following_id->follow;
        }

        $list = \DB::table('posts')
              ->where('posts.user_id',$id)
              ->select('posts.*','users.images','users.username')
              ->join('users','posts.user_id','=','users.id')
              ->orderby('posts.created_at','desc')
              ->get();  



        return view('users.profile',compact('list','profile','username','mail','password','bio','images','follower_user','following_user'));
    }

    //更新
    public function update(Request $request){
        $id = Auth::user()->id;//ログインしてる人のID
        $profile = \DB::table('users')->where('id',$id)->first();
         
        //入力されたものそれぞれを定義
         $edit_name = $request->input('username'); 
         $edit_mail = $request->input('mail'); 
         $edit_password = $request->input('newpassword');
         $edit_bio = $request->input('bio'); 
         $edit_images = $request->file('images'); 
         
         $update = $request->input();

         
         if(isset($edit_password) && isset($edit_images)){
            $test = $request->file('images')->getClientOriginalName();//画像の名前指定

            $request->file('images')->storeAs('images',$test,'public_uploads');
            \DB::table('users')->where('id',$id)->update([ 
                'username' => $edit_name,
                'mail' => $edit_mail,
                'password' => $edit_password,
                'bio' => $edit_bio,
                'images' => $test,
            ]);
         }
         elseif(isset($edit_password) && !isset($edit_images)){
             \DB::table('users')->where('id',$id)->update([ 
                     'username' => $edit_name,
                     'mail' => $edit_mail,
                     'password' => $edit_password,
                     'bio' => $edit_bio,
                 ]);
         }
         elseif(!isset($edit_password) && isset($edit_images)){
            $test = $request->file('images')->getClientOriginalName();//画像の名前指定

            $request->file('images')->storeAs('images',$test,'public_uploads');
            \DB::table('users')->where('id',$id)->update([ 
                'username' => $edit_name,
                'mail' => $edit_mail,
                'bio' => $edit_bio,
                'images' => $test
            ]);
         }
         else{
            \DB::table('users')->where('id',$id)->update([ 
                'username' => $edit_name,
                'mail' => $edit_mail,
                'bio' => $edit_bio,
            ]);
         }

     
         return redirect('users.profile');
    }

    


    /*-------------------        検索         -------------------*/
    public function search(Request $request){

        $keyword = $request -> input('keyword');//キーワードを定義

        $username = Auth::user()->username;  //ユーザー名を引き継ぐ
        
        $images = Auth::user()->images;//認証ユーザーのimages

        

        //フォロー一覧
        $id = Auth::user()->id;//ログインしてる人のID

        $follower = \DB::table('follows')->where('follower',$id)->get();
        
        $follower_user = []; //フォローしている人のID


        //フォローしている人のIDを配列化
        foreach ($follower as $follower_id){//$followingを順に取り出して$follower_idへ代入
            $follower_user[] = $follower_id->follow;
        }
        
        //フォロワー一覧
        $id = Auth::user()->id;//ログインしてる人のID

        $following = \DB::table('follows')->where('follow',$id)->get();
        
        $following_user = []; //フォローされてる人のID

        //フォローされてる人のIDを配列化
        foreach ($following as $following_id){//$followingを順に取り出して$following_idへ代入
            $following_user[] = $following_id->follow;
        }
       
        //あいまい検索
        if(isset($keyword)){
            $query = \DB::table('users')->where('id','<>',Auth::id())->where('username','like','%'.$keyword.'%')->orwhere('mail','like','%'.$keyword.'%')->get();
            
            return view('users.search',compact('username','images','keyword','query','follower_user','following_user'));

        }
        else{
            $query = \DB::table('users')->where('id','<>',Auth::id())->get();
            
            return view('users.search',compact('query','username','images','follower_user','following_user'));
        }

            
        
        
    }
    
    //フォローする
    public function follow($id){//ログインしているユーザー

        $follow = \DB::table('follows')->insert([
          'follower' => Auth::id(), 
          'follow' => $id,
          //フォローカラムに認証されてるユーザーのIDと自分のIDをfollowsカラムに追加する
        ]);
    
        
        return redirect('/users/search');
    }


    //フォロワーからフォローを外す
    public function unfollow($id){

        \DB::table('follows')
        ->where('follow',$id)//フォローしてる人
        ->delete();

        return redirect('/users/search');
    }

    
    
    

}
