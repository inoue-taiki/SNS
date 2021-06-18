<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;



class PostsController extends Controller
{
   
    //  投稿用部分
    public function create(Request $request){
        
        $post = $request->input('newPost');
           \DB::table('posts')->insert([ //DBに入力データを追加する
                'posts' => $post,
                'user_id' => Auth::id(), //認証されたユーザー名
            ]);
    
        return redirect('/top');

    }

     //  投稿一覧部分
     public function index(){
        $id = Auth::user()->id;//ログインしてる人のID
        $list = \DB::table('posts')
              ->where('posts.user_id',$id)
              ->orwhere('follows.follower',$id)
              ->select('posts.*','users.images','users.username')
              ->join('users','posts.user_id','=','users.id')
              ->leftjoin('follows','follows.follow','users.id')
              ->orderby('posts.created_at','desc')
              ->get();  //DB（postテーブル）の中からデータを取得

        $username = Auth::user()->username;  //認証されたユーザー名を定義

        $images = Auth::user()->images;//認証ユーザーのimages
        
        
        
        
        $loginuser = Auth::id();//ログインユーザー()

        //フォロー一覧
        

        $follower = \DB::table('follows')->where('follower',$id)->get();
        
        $follower_user = []; //フォローしている人のID

        //フォローしている人のIDを配列化
        foreach ($follower as $follower_id){//$followerを順に取り出して$follower_idへ代入
            $follower_user[] = $follower_id->follow;
        }

        //フォロワー一覧
        $id = Auth::user()->id;//ログインしてる人のID

        $following = \DB::table('follows')->where('follow',$id)->get();
        
        $following_user = []; //フォローされている人のID

        //フォローされてる人のIDを配列化
        foreach ($following as $following_id){//$followingを順に取り出して$following_idへ代入
            $following_user[] = $following_id->follow;
        }
        


        return view('posts.index',['images'=>$images,'list'=>$list,'username'=>$username,'loginuser'=>$loginuser,'follower_user'=>$follower_user,'following_user'=>$following_user]);
        
    }


    //  編集・更新部分
    public function update(Request $request)
    {
        $edit = $request->input('title'); //入力されているname属性（title）を$editとして定義
        $update = $request->input('update');//新しく入力されたname属性を$updateとして定義

        \DB::table('posts')->where('id',$update)->update([ //DBのpostsカラムを更新する
            'posts' => $edit,
            ]);
            
          
        return redirect('/top');
    }

    //  削除部分
    public function delete($id)
    {
        \DB::table('posts')
            ->where('id', $id)
            ->delete();
 
        return redirect('/top');
    }
    
    
   
    
}
