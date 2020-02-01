<footer class="footer">
    <div class="container">

        @if ($routeInfo['path'] === '/')
        <div class="flinks">
            <strong>友情链接</strong>
            <ul class='xoxo blogroll'>
                @if (isset($links))
                @foreach ($links as $link)
                <li><a href="{{ $link->url }}" target="_blank">{{ $link->name }}</a></li>
                @endforeach
                @endif
            </ul>
        </div>
        @endif

        <!--
        <div class="fcode">
            <img src="/static/images/qrcode/qrcode.png" alt="刘宗阳博客QQ群" class="img-responsive center-block">
            <p>扫一扫申请加入“刘宗阳博客”QQ群</p>
        </div>
        -->

        <p>
            Copyright(c) 2018 刘宗阳博客版权所有 All Rights Reserved
        </p>
        <div style="display:none">
            <!-- 统计代码 -->
            <script type="text/javascript" src="//js.users.51.la/19712907.js"></script>
        </div>
    </div>
</footer>

<div class="rollbar rollbar-rb">
    <ul>
        <li>
            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=84299915&site=qq&menu=yes"><i class="fa fa-qq"></i><span>QQ咨询</span></a>
            <h6>QQ咨询<i></i></h6>
        </li>
        <li><a href="javascript:void(0);"><i class="fa fa-phone"></i><span>电话咨询</span></a>
            <h6>电话咨询<i></i></h6>
        </li>
        <li class="rollbar-qrcode"><a href="javascript:void(0);"><i class="fa fa-qrcode"></i><span>微信咨询</span></a>
            <h6>关注微信<img src="/static/images/qrcode/qrcode.png"><i></i></h6>
        </li>
        <li><a target="_blank" href="javascript:void(0);"><i class="fa fa-globe"></i><span>在线咨询</span></a>
            <h6>在线咨询<i></i></h6>
        </li>
        <li class="rollbar-totop"><a href="javascript:(scrollTo());"><i class="fa fa-angle-up"></i><span>回顶</span></a>
            <h6>回顶部<i></i></h6>
        </li>
    </ul>
</div>
<script>
    window.jsui = {
        www: '{{ env("APP_URL") }}',
        uri: '{{ env("APP_URL") }}/static',
        ver: '5.1',
        roll: ["1", "2"],
        ajaxpager: '0',
        url_rp: '{{ env("APP_URL") }}/password/reset',
    };
</script>

<script type='text/javascript' src="/static/js/bootstrap.min.js"></script>
<script type='text/javascript' src="/static/js/loader.js"></script>
<script type='text/javascript' src="/static/js/wp-embed.min.js"></script>
<script type="text/javascript">
    // 退出登陆
    $('.logout').click(function() {
        $.get('{{ route("home.logout") }}', function(response) {
            // 打印结果
            console.log(response);
            // 切换到未登录
            $('#logined').hide();
            $('#notlogin').show();
            // 隐藏评论框
            if ($('#respond')) {
                $('#respond').hide();
            }
            // 显示评论登陆窗口
            if ($('#comment_login')) {
                $('#comment_login').show();
            }
        });
    });
</script>