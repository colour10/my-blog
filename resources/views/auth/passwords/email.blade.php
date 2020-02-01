@include('layouts._meta')

<body
    class="page-template page-template-pages page-template-resetpassword page-template-pagesresetpassword-php page page-id-85 m-excerpt-cat p_indent comment-open site-layout-2 text-justify-on">

@include('layouts._header')

<section class="container">
    <div class="content-wrap">
        <div class="content resetpass">
            <h1 class="hide">重置密码</h1>
            <ul class="resetpasssteps">
                <li class="active">获取密码重置邮件<span class="glyphicon glyphicon-chevron-right"></span></li>
                <li>设置新密码<span class="glyphicon glyphicon-chevron-right"></span></li>
                <li>成功修改密码</li>
            </ul>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="post" name="sendEmailForm">
                @csrf
                <h3>请填写邮箱：</h3>
                <p><input value="" {{ old('email') }} type="text" id="email" name="email"
                          class="form-control input-lg" autofocus></p>
                <p><input type="submit" name="send" value="获取密码重置邮件" class="btn btn-block btn-primary btn-lg"></p>

                @if ($errors->has('email'))
                    <span class="form-text">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

            </form>

        </div>
    </div>
</section>

@include('layouts._footer')

</body>

</html>
