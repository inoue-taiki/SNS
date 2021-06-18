@extends('layouts.login')

@section('content')

<div class="search-box">
  
  <!--  検索部分  -->
  @if(isset($keyword))
   {{Form::open(['url' => '/users/search'])}}
    <div class="text">
      <input type="text" name="keyword" placeholder="ユーザー名">
    </div>
    <input type="submit" value="検索">
   {{ Form::close() }}

    <p>検索キーワード：{{$keyword}}</p>
  
  @else
  {{Form::open(['url' => '/users/search'])}}
    <div class="text">
      <input type="text" name="keyword" placeholder="ユーザー名">
    </div>
    <input type="submit" value="検索">
   {{ Form::close() }}

   @endif

</div>

<!--  検索結果一覧  -->

@if(!$query -> isEmpty()) <!--  検索結果があるか  -->

@foreach($query as $query)
<div class="search-table">
  <tr>
    <td class="image"><img src="{{ asset('images/'.$images) }}" alt=""></td> 
    <td class="username">{{ $query->username }}</td> 

      

  
    @if(in_array($query->id,$follower_user))
       <!--  フォロー済みの人だけ表示したい --> 
       <div class="unfollow">
         <td><button><a class="unfollow" href="/follows/{{$query->id}}/unfollow">フォローを外す</a></button><!--  followカラムにある$idを削除する -->
       </div>
    
    @else
      <!--  フォロー済みでない且つ自分自身じゃない -->
       <div class="follow">
         <td><button><a class="follow" href="/users/{{$query->id}}/follow">フォローする</a></button>
       </div>

    @endif
      

       
          
  </tr>
</div>


@endforeach


@endif

@endsection