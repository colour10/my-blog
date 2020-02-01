@include('layouts._meta')

<body class="archive category category-tech category-1 nav_fixed m-excerpt-cat site-layout-2 text-justify-on">

@include('layouts._header')

<section class="container">
    <div class="content-wrap">
        <div class="content">
            <div class="catleader">
                <h1>在线留言</h1>
                <div class="catleader-desc">如果您对网站有什么意见或建议，欢迎给博主留言哦，博主会在第一时间回复您。</div>
            </div>


            <style>
                .text-box input[type="text"],
                .textarea textarea {
                    border: 2px solid #E5E5E5;
                    width: 100%;
                    padding: 0.85em;
                    border-radius: 0.3em;
                    margin-bottom: 1.5em;
                    color: #858585;
                    transition: border-color 0.3s;
                    -o-transition: border-color 0.3s;
                    -ms-transition: border-color 0.3s;
                    -moz-transition: border-color 0.3s;
                    -webkit-transition: border-color 0.3s;
                    transition: 0.5s all;
                    -webkit-transition: 0.5s all;
                    -moz-transition: 0.5s all;
                    -o-transition: 0.5s all;
                    outline: none;
                }

                .text-box input[type="text"].w50 {
                    width: 50%;
                }

                .textarea textarea {
                    height: 186px;
                    resize: none;
                }

                .textarea {
                    text-align: right;
                }

                .textarea input[type="submit"] {
                    background: #FF5E52;
                    border: 1px solid #FF5E52;
                    color: #fff;
                    transition: 0.5s all;
                    -webkit-transition: 0.5s all;
                    -moz-transition: 0.5s all;
                    -o-transition: 0.5s all;
                    font-size: 1.1em;
                    padding: 0.7em 2.5em;
                    font-weight: 600;
                    margin: 0 auto;
                    -webkit-appearance: none;
                    border-radius: 5px;
                }

                .textarea input[type="submit"]:hover {
                    color: #0199e6;
                    border: 1px solid #FF5E52;
                    background: transparent;
                }

                .text-box input[type="text"]:hover,
                .textarea textarea:hover,
                .text-box input[type="text"]:focus,
                .textarea textarea:focus {
                    border-color: #008ed6;
                }
            </style>

            <div id="contact" class="contact">
                <div class="container">
                    <!-- <div class="contact-text text-center">
                        <h3>contact</h3>
                        <p>如果您对网站有什么意见或建议，欢迎给博主留言哦，博主会在第一时间回复您。</p>
                    </div> -->
                    <div class="contact-form">
                        <form class="ui-from" name="MsgForm" id="MsgForm" method="post">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <div class="col-md-12 text-box">
                                <input type="text" placeholder="请填写留言标题" name="title" id="title" required=""/>
                            </div>
                            <div class="col-md-12 textarea">
                                <textarea placeholder="请填写留言内容" required="" name="content" id="content">留言内容</textarea>
                                <input type="submit" value="提　交" id="message_submit"/>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <script src="/static/layer/layer.js"></script>
            <script src="/static/js/ajax.js"></script>
            <script type='text/javascript'>
                // 判断是否登陆
                if (is_login()) {
                    // 取出缓存
                    let dataObj = JSON.parse(window.localStorage.getItem('user'));
                    let user_id = $('#user_id');
                    // 写入留言板
                    if (user_id.length > 0) {
                        // 写入user_id
                        user_id.val(dataObj.id);
                    }
                }

                // 提交留言板
                $('#message_submit').click(function () {
                    //信息框
                    // 判断是否登陆
                    if (!is_login()) {
                        // 错误提示
                        layer.msg('亲，登录后才能发表留言哦~', {icon: 2});
                        // 禁止跳转
                        return false;
                    }

                    // 开始提交
                    let fd = getFormData("MsgForm");
                    // 提交
                    ajax('post', "{{ route('guestbooks.store') }}", fd, "{{ route('guestbooks.index') }}");
                    // 返回，禁止跳转
                    return false;
                });

                // 判断用户是否登陆
                function is_login() {
                    // 初始化
                    var result = false;
                    // ajax同步传输
                    $.ajaxSetup({async: false});
                    // 判断是否登陆
                    $.get('{{ route("home.isLogin") }}', function (response) {
                        // 打印结果
                        if (response.code === 0) {
                            result = true;
                        } else {
                            // 清空原来的storage
                            window.localStorage.removeItem('user');
                            result = false;
                        }
                    });
                    // 返回
                    return result;
                }
            </script>


        </div>
    </div>

    @include('layouts._sidebar')

</section>

@include('layouts._footer')

</body>

</html>

