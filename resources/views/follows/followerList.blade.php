@extends('layouts.login')

@section('content')

<!--    フォロワーリスト   -->
<div class="follower-list">
  <h2>Follower list</h2>

  <div class="form-icon">
  @foreach ($followed_list as $followed_list)
    <a href="other/profile/{{$followed_list->id}}"><img src="{{ asset('images/'.$followed_list->images) }}"></a>
  @endforeach
  </div>

</div>

<!--   フォロワーユーザーの投稿  -->

@foreach ($list as $list)
 <div class="table">

   <tr>
     <!--<td class="user-id">{{ $list->user_id }}</td>-->

     <div class="form-icon">
       <td class="images"><img src="{{ asset('images/'.$list->images) }}"></td>
     </div>
     <div class="form-table">
       <div class="block">
         <td class="username">{{ $username }}</td> 
         <div class="form-posts">
           <td class="posts">{{ $list->posts }}</td>
         </div>
       </div>

       <div class="created_at">
         <td class="created-at">{{ $list->created_at }}</td>
       </div>
     </div>
   </tr>

 </div>
@endforeach

@endsection