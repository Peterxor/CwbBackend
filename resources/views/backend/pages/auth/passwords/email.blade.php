@extends('backend.layouts.login')
@php
    if(session('status')){
        $block_style = 'width:700px;margin-top:calc(20% - 100px);';
    }else{
        $block_style = 'margin-top:calc(20% - 100px);';
    }
@endphp
@section('content')
<div class="container" style="{{$block_style}}">
    <div class="row justify-content-center" style="">
        <div class="col-md-8">
            <div class="card">
                @if (session('status'))
                    <div class="card-body">
                        <h2 class="text-center">重設密碼信已寄出!</h2>
                        <div class="pt-4">
                            <p>
                                重設密碼信已寄至 <span class="">{{ old('email') }}</span> 信箱，
                            </p>
                            <p>
                                沒有收到信!
                                <a class="forgot_text" href="{{ route('password.request') }}">
                                    重新寄送重設密碼信
                                </a>
                            </p>
                        </div>
                        <div class="">
                            <a class="forgot_text float-right" href="{{ route('login') }}">返回登入頁面</a>
                        </div>
                    </div>

                @else
                    <div class="card-header">
                        重設密碼
                        <a class="forgot_text float-right" href="{{ route('login') }}">回到登入</a>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('password.email') }}" id="reset-form">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-md-right">Email信箱</label>

                                <div class="col-md-7">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @else
                                        <span class="forgot_text" role="alert">
                                            <strong>請填寫您的電子郵件地址，您將會收到一封重設密碼的信</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary ld-over" id="reset-password-btn">
                                        發送重設密碼請求
                                        <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('pages_scripts')
    {!! Html::script('js/password/email.js') !!}
@endsection
