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
                <li>设置新密码<span class="glyphicon glyphicon-chevron-right"></span></li>
                <li class="active">成功修改密码</li>
            </ul>

            <div class="card-body">
                <p>恭喜您，密码修改成功，现在您可以用新密码进行登陆啦~</p>
            </div>

        </div>
    </div>
</section>

@include('layouts._footer')

</body>
