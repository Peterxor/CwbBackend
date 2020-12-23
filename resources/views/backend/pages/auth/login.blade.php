@extends('backend.layouts.login')

@section('content')
    <div class="kt-login__signin">
      <div class="kt-login__head">
        <h3 class="kt-login__title">Sign In To Admin</h3>
      </div>
      <form class="kt-form" method="POST" action="{{route('login')}}" id="login-form">
        @csrf
        <div class="input-group">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} m-input" name="email" value="{{ old('email') }}" required autofocus placeholder="信箱" autocomplete="off">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="input-group">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} m-input" name="password" required placeholder="密碼">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="kt-login__actions">
            <button type="submit" class="btn btn-elevate kt-login__btn-primary" style="background-color: #083F8C; color: #ffffff">
                {{ __('登入') }}
            </button>
        </div>
      </form>
    </div>
@endsection
