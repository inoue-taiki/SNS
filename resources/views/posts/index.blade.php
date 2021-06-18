@extends('layouts.login')

@section('content')

<!--    投稿フォーム    -->
<div class="post-form">

  <div class="form-icon">
    <img src="images/dawn.png">
    {{ Form::open(['url' => '/post/create']) }}<!-- ←投稿用のURL作成  -->
  </div>

  <div class="form-group">
  {{ Form::text('newPost', null, ['placeholder' => '何をつぶやこうか...?']) }}
  </div>

  <div class="post-direct">
    <img src="images/post.png">
    {{ Form::close() }}
  </div>

</div>

<!--   投稿されたページ   -->

@foreach ($list as $list)
<div class="table">
   <tr>
   
     <!--<td class="user-id">{{ $list->user_id }}</td>--> 

   
     <div class="form-icon">
       <td class="images"><img src="{{ asset('images/'.$images) }}"></td>
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

     @if($loginuser === $list->user_id)<!--  ログインユーザーと投稿者が一致しているか  -->
     <div class="action-button">
       <div class="edit">
         <td><a class="js-modal-open" href=""><img src="images/edit.png"></a></td>
       </div>
     
       <div class="trash">
         <td><a class="danger" href="/post/{{$list->id}}/delete" onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか？')"><img src="images/trash.png" class="trash1"></a></td>
       </div>
        
     </div>
     




    <!--    モーダルウインドウ   -->
     <div class="modal js-modal">
        <div class="modal__bg js-modal-close"></div>
        <div class="modal__content">
             
              {{ Form::open(['url' => '/post/update']) }}
               <input type='text' name='title' value='{{$list->posts}}'><!-- 入力されている値 -->
               <input type='hidden' name='update' value='{{$list->id}}'><!--  どのつぶやきを更新するのか-->
              {{ Form::close() }}
            

            <div class="edit">
              <p>編集画面が表示されると、選択された投稿内容が初期から入っているように<br>最大200文字までとする</p>
              <div class="modal-img">
               <img src="images/edit.png">
              </div>
            </div>
            
             <a class="js-modal-close" href=""></a>
            
        </div>
    </div>
    @endif
     
    

</div>


<script type="text/javascript">
$(function(){
    $('.js-modal-open').on('click',function(){
        $('.js-modal').fadeIn();
        return false;
    });
    $('.js-modal-close').on('click',function(){
        $('.js-modal').fadeOut();
        return false;
    });
});
</script>

@endforeach





@endsection