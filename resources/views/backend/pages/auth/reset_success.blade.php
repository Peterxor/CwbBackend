@extends('backend.layouts.login')
@section('content')

<div class="container register_wrapper">
    <div class="row justify-content-center register_area">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">用戶密碼修改完成</div>

                <div class="card-body">
                    <p>
                        恭喜您成功變更密碼!!
                    </p>
                    <h4>請繼續登入開始使用，謝謝。</h4>
                    <a class="forgot_text float-right" href="{{ route('login') }}">回到登入</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
