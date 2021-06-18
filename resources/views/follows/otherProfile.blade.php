@extends('layouts.login')

@section('content')

<div class="follow_list">
 
    <tr>
      <div class="follow_info">
        <div class="form-icon">
           <td><img src="{{ asset('images/'.$images) }}"></td>
        </div>
        
        <div class="block">
          <div class="name">
            <td><p>Name</p>{{$bio->username}}</td>
          </div>
          <div class="bio">
            <td><p>Bio</p>{{$bio->bio}}</td>
          </div>
        </div>
      </div>

        <div class="follow-button">
           @if(in_array($bio->id,$follower_user))
           <!--  フォロー済みの人だけ表示したい --> 
           <div class="unfollow">
             <td><button><a class="unfollow" href="/follows/{{$bio->id}}/unfollow">フォローを外す</a></button><!--  followカラムにある$idを削除する -->
           </div>
           @else
           <!--  フォロー済みでない且つ自分自身じゃない -->
  
           <div class="follow">
             <td><button><a class="follow" href="/users/{{$bio->id}}/follow">フォローする</a></button>
           </div>
  
           @endif
        </div>

      
    </tr>
  
</div>

<div class="table">
   @foreach($other_list as $other_list)
   <tr>
     <div class="form-icon">
        <td class="images"><img src="{{ asset('images/'.$bio->images) }}"></td>
     </div>

     <td class="username">{{ $bio->username }}</td>   
     <td class="created_at">{{ $bio->created_at}}</td>  
     <td class="posts">{{$other_list->posts}}</td>
   </tr>
  @endforeach

</div>

@endsection