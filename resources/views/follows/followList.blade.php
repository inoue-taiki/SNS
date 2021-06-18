@extends('layouts.login')

@section('content')


<div class="follow_list">
  <h2>Follow List</h2>

  <div class="forrow-icon">
    @foreach ($follow_list as $follow_list)
    <a href="other/profile/{{$follow_list->id}}"><img src="{{ asset('images/'.$images) }}"></a>
    @endforeach
  </div>

</div>


<!--   フォローユーザーの投稿  -->

@foreach ($list as $list)
 <div class="table">

   <tr>
     <!--<td class="user-id">{{ $list->user_id }}</td> -->

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