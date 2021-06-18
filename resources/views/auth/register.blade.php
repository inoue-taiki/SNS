@extends('layouts.logout')

@section('content')

{!! Form::open() !!}

<div class="register-form">
  <h2>新規ユーザー登録</h2>
  
  <div class="register-username">
    {{ Form::label('UserName') }}
    {{ Form::text('username',null,['class' => 'input']) }}
    @if($errors->has('username'))<p class="error">{{$errors->first('username')}}</p>@endif
  </div>
  
  <div class="register-mail">
    {{ Form::label('MailAdress') }}
    {{ Form::text('mailadress',null,['class' => 'input']) }}
    @if($errors->has('mailadress'))<p class="error">{{ $errors->first('mailadress') }}</p> @endif
  </div>

  <div class="register-password">
    {{ Form::label('Password') }}
    {{ Form::text('password',null,['class' => 'input']) }}
    @if($errors->has('password'))<p class="error">{{ $errors->first('password') }}</p> @endif
  </div>
  

  <div class="register-confirm">
    {{ Form::label('Password Confirm') }}
    {{ Form::text('password-confirm',null,['class' => 'input']) }}
    @if($errors->has('password-confirm'))<p class="error">{{$errors->first('password-confirm')}}</p> @endif
  </div>
  
  <div class="register-button">
    {{ Form::submit('Resister') }}
  </div>
  
  <div class="back-login">
   <p><a href="/login">ログイン画面へ戻る</a></p>
  </div>


</div>

{!! Form::close() !!}


@endsection
