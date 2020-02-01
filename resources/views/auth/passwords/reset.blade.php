@include('layouts._meta')

<body
    class="page-template page-template-pages page-template-resetpassword page-template-pagesresetpassword-php page page-id-85 m-excerpt-cat p_indent comment-open site-layout-2 text-justify-on">

@include('layouts._header')

<section class="container">
    <div class="content-wrap">
        <div class="content resetpass">
            <h1 class="hide">重置密码</h1>
            <ul class="resetpasssteps">
                <li>获取密码重置邮件<span class="glyphicon glyphicon-chevron-right"></span></li>
                <li class="active">设置新密码<span class="glyphicon glyphicon-chevron-right"></span></li>
                <li>成功修改密码</li>
            </ul>

            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email 地址</label>

                        <div class="col-md-6">
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ $email ?? old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">密码</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">确认密码</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary center-block">
                                重置密码
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@include('layouts._footer')

</body>
