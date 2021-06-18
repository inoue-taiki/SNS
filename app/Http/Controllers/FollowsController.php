<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;


class FollowsController extends Controller
{
    
    //フォローしてる人リスト
    public function followList(){
        
        $id = Auth::user()->id;//認証されたID
        $username = Auth::user()->username;//認証されたユーザー名
        $images = Auth::user()->images;//認証ユーザーのimages

        
        //フォローしている人の投稿
        $post = \DB::table('posts')
                ->leftjoin('users','posts.user_id','=','users.id')
                //↑userテーブルと結合させ、postsテーブルのidとuserテーブルのidがマッチする条件を
                ->leftjoin('follows','follows.follower','=','posts.id')
                //↑followsとpostsを結合させ、followテーブルのidとpostsテーブルのidがマッチする条件を
                ->where('follower',$id)->get();  
                //follow_idがフォローしてるユーザーになるように 

        //ユーザーがフォローしている人
        $follower = \DB::table('follows')
                  ->leftjoin('users','follows.follower','=','users.id')
                  //↑followsとusersを結合させ、followテーブルのidとuserテーブルのidがマッチする条件を
                  ->where('follower',$id)->get();
                  //follow_idがフォローしてるユーザーになるように  

        $follower_user = []; //フォローしている人のID
        //フォローしている人のIDを配列化
          foreach ($follower as $follower_id){//$followingを順に取り出して$follower_idへ代入
                   $follower_user[] = $follower_id->follow;} 

        $following = \DB::table('follows')->where('follow',$id)->get();
        $following_user = []; //フォローされている人のID

        //フォローされてる人のIDを配列化
           foreach ($following as $following_id){//$followingを順に取り出して$following_idへ代入
                    $following_user[] = $following_id->follow;} 

        
        $list = \DB::table('posts')
              ->where('follows.follower',$id)
              ->select('posts.*','users.images','users.username')
              ->join('users','posts.user_id','=','users.id')
              ->leftjoin('follows','follows.follow','users.id')
              ->orderby('posts.created_at','desc')
              ->get();  
        
        $follow_list = \DB::table('users')
                     ->where('follows.follower',$id)
                     ->select('users.*')
                     ->leftjoin('follows','follows.follow','users.id')
                     ->get();


        return view('follows.followList',compact('images','post','username','follower','follower_user','following_user','list','follow_list'));

    }



    //フォロワーリスト
    public function followerList(){

        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $images = Auth::user()->images;//認証ユーザーのimages

        
        //フォローされている人の投稿
        $post = \DB::table('posts')
                ->leftjoin('users','posts.user_id','=','users.id')
                ->leftjoin('follows','follows.follow','=','posts.id')
                ->where('follow',$id)->get();  
                

        $followed = \DB::table('follows')
                  ->leftjoin('users','follows.follow','=','users.id')
                  ->where('follow',$id)->get();
                  

        $followed_user = []; 
          foreach ($followed as $followed_id){
                   $followed_user[] = $followed_id->follow;} 

        $followedother = \DB::table('follows')->where('follow',$id)->get();
        $followedother_user = []; 

           foreach ($followedother as $followed_id){
                    $followedother_user[] = $followed_id->follow;} 

        $list = \DB::table('posts')
              ->where('follows.follower',$id)
              ->select('posts.*','users.images','users.username')
              ->join('users','posts.user_id','=','users.id')
              ->leftjoin('follows','follows.follower','users.id')
              ->orderby('posts.created_at','desc')
              ->get();  
        
        $followed_list = \DB::table('users')
                     ->where('follows.follow',$id)
                     ->select('users.*')
                     ->leftjoin('follows','follows.follow','users.id')
                     ->get();


         //ユーザーがフォローしている人
         $follower = \DB::table('follows')
           ->leftjoin('users','follows.follower','=','users.id')
           ->where('follower',$id)->get();
        

         $follower_user = []; 
         foreach ($follower as $follower_id){
            $follower_user[] = $follower_id->follow;} 

         $following = \DB::table('follows')->where('follow',$id)->get();
         $following_user = []; 

        foreach ($following as $following_id){
             $following_user[] = $following_id->follow;} 



        return view('follows.followerList',compact('images','post','username','follower','follower_user','following_user','list','followed','followed_user','followedother','followedother_user','followed_list'));
    }



    //相手のプロフィール
    public function other_profile($other_id){

        $id = Auth::user()->id;//ログインしてる人のID
        $username = Auth::user()->username;//認証されたユーザー名
        $bio = \DB::table('users')->select('id','username','images','bio','created_at')->where('id',$other_id)->first();
        $images = Auth::user()->images;//認証ユーザーのimages
       

        //ユーザーがフォローしている人
        $follower = \DB::table('follows')
                  ->leftjoin('users','follows.follower','=','users.id')
                  //↑followsとusersを結合させ、followテーブルのidとuserテーブルのidがマッチする条件を
                  ->where('follower',$id)->get();
                  //follow_idがフォローしてるユーザーになるように  

        $follower_user = []; //フォローしている人のID
        //フォローしている人のIDを配列化
          foreach ($follower as $follower_id){//$followingを順に取り出して$follower_idへ代入
                   $follower_user[] = $follower_id->follow;} 

        $following = \DB::table('follows')->where('follow',$id)->get();
        $following_user = []; //フォローされている人のID

        //フォローされてる人のIDを配列化
           foreach ($following as $following_id){//$followingを順に取り出して$following_idへ代入
                    $following_user[] = $following_id->follow;} 

        //投稿部分
        $other_list = \DB::table('posts')
              ->where('users.id',$other_id)
              ->select('posts.*','users.images','users.username')
              ->join('users','posts.user_id','=','users.id')
              ->get();

              
        $list = \DB::table('users')->where('id',$id)->first();

        
        
        
       return view('follows.otherProfile',compact('images','id','username','bio','follower','follower_user','following','following_user','list','other_list'));

    }
}
