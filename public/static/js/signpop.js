tbfine(function () {

    return {
        init: function () {
            var signHtml = '\
			<div class="sign">\
			    <div class="sign-mask"></div>\
			    <div class="container">\
			        <a href="javascript:;" class="close-link signclose-loader"><i class="fa fa-close"></i></a>\
			        <div class="sign-tips"></div>\
			        <form id="sign-in">  \
			            <h3><small class="signup-loader">切换注册</small>登录</h3>\
			            <h6>\
			                <label for="inputEmail">用户名或邮箱</label>\
			                <input type="text" name="nameemail" class="form-control" id="inputEmail" placeholder="用户名或邮箱">\
			            </h6>\
			            <h6>\
			                <label for="inputPassword">密码</label>\
			                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="登录密码">\
                        </h6>\
                        <input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">\
			            <div class="sign-submit">\
			                <input type="button" class="btn btn-primary signsubmit-loader" name="submit" value="登录">  \
			                <input type="hidden" name="action" value="signin">\
			                <label><input type="checkbox" name="is_remember" value="1" checked="checked">记住我</label>\
			            </div>' + (jsui.url_rp ? '<div class="sign-info"><a href="' + jsui.url_rp + '">找回密码？</a></div>' : '') +
                '</form>\
			        <form id="sign-up"> \
			            <h3><small class="signin-loader">切换登录</small>注册</h3>\
			            <h6>\
			                <label for="inputName">用户名</label>\
			                <input type="text" name="username" class="form-control" id="inputName" placeholder="设置用户名">\
			            </h6>\
			            <h6>\
			                <label for="inputEmail2">邮箱</label>\
			                <input type="email" name="email" class="form-control" id="inputEmail2" placeholder="邮箱">\
                        </h6>\
			            <h6>\
			                <label for="inputPassword10">密码</label>\
			                <input type="password" name="password" class="form-control" id="inputPassword10" placeholder="密码">\
                        </h6>\
                        <input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">\
			            <div class="sign-submit">\
			                <input type="button" class="btn btn-primary btn-block signsubmit-loader" name="submit" value="快速注册">  \
			                <input type="hidden" name="action" value="signup">  \
			            </div>\
			        </form>\
			    </div>\
			</div>\
		';

            jsui.bd.append(signHtml);

            if ($('#issignshow').length) {
                jsui.bd.addClass('sign-show');
                // $('.close-link').hide()
                setTimeout(function () {
                    $('#sign-in').show().find('input:first').focus()
                }, 300);
                $('#sign-up').hide();
            }


            $('.signin-loader').on('click', function () {
                jsui.bd.addClass('sign-show');
                setTimeout(function () {
                    $('#sign-in').show().find('input:first').focus()
                }, 300);
                $('#sign-up').hide()
            });

            $('.signup-loader').on('click', function () {
                jsui.bd.addClass('sign-show');
                setTimeout(function () {
                    $('#sign-up').show().find('input:first').focus()
                }, 300);
                $('#sign-in').hide();
            });

            $('.signclose-loader').on('click', function () {
                jsui.bd.removeClass('sign-show');
            });

            $('.sign-mask').on('click', function () {
                jsui.bd.removeClass('sign-show');
            });

            $('.sign form').keydown(function (e) {
                var e = e || event,
                    keycode = e.which || e.keyCode;
                if (keycode == 13) {
                    $(this).find('.signsubmit-loader').trigger("click");
                }
            });

            $('.signsubmit-loader').on('click', function () {
                if (jsui.is_signin) return;

                var form = $(this).parent().parent();
                var inputs = form.serializeObject();
                var isreg = (inputs.action == 'signup') ? true : false;

                if (!inputs.action) {
                    return;
                }

                // 如果是注册模块
                if (isreg) {
                    if (!/^[a-z\d_]{3,20}$/.test(inputs.username)) {
                        logtips('用户名是以字母数字下划线组合的3-20位字符');
                        return;
                    }

                    if (!is_mail(inputs.email)) {
                        logtips('邮箱格式错误');
                        return;
                    }

                    if (!(inputs.password)) {
                        logtips('请输入密码');
                        return;
                    }

                    if (inputs.password.length < 6) {
                        logtips('密码太短，至少6位');
                        return;
                    }

                    // 注册dom
                    // <h6>\
                    //     <label for="inputEmail2">密码</label>\
                    //     <input type="password" name="password" class="form-control" id="inputPassword2" placeholder="密码">\
                    // </h6>\
                    // <h6>\
                    //     <label for="inputEmail2">确认密码</label>\
                    //     <input type="password" name="password_confirmation" class="form-control" id="inputPassword3" placeholder="确认密码">\
                    // </h6>\

                    // if (!(inputs.password)) {
                    //     logtips('请输入密码')
                    //     return
                    // }

                    // if (!(inputs.password_confirmation)) {
                    //     logtips('请输入确认密码')
                    //     return
                    // }

                    // if (inputs.password.length < 6) {
                    //     logtips('密码太短，至少6位')
                    //     return
                    // }

                    // if (inputs.password != inputs.password_confirmation) {
                    //     logtips('密码和确认密码不一致！')
                    //     return
                    // }

                } else {
                    if (inputs.password.length < 6) {
                        logtips('密码太短，至少6位');
                        return
                    }
                }

                $.ajax({
                    type: "POST",
                    url: '/users',
                    data: inputs,
                    dataType: 'json',
                    success: function (response) {
                        if (response.code === 0) {
                            // 已经登陆成功
                            // 然后把用户登陆信息写入localStorage
                            var user = JSON.stringify(response.data);
                            window.localStorage.setItem('user', user);
                            // 成功提示信息
                            logtips(response.msg);
                            // 然后隐藏登陆框
                            // 3000毫秒后开始执行
                            setTimeout("jsui.bd.removeClass('sign-show')", 3000);

                            $('#logined').show();
                            $('#user_name').text(response.data.username);
                            $('#notlogin').hide();
                            // 展示评论框
                            if ($('#respond').length > 0) {
                                $('#respond').show();
                            }
                            // 隐藏评论登陆窗口
                            if ($('#comment_login').length > 0) {
                                $('#comment_login').hide();
                            }
                            // 写入当前登陆用户id
                            $('input[name=user_id]').val(response.data.id);
                            // 写入留言板
                            if ($('#user_id').length > 0) {
                                $('#user_id').val(response.data.id);
                            }
                            return;
                        } else if (response.code === 1002) {
                            // 成功提示信息
                            logtips(response.msg);
                            // 然后隐藏登陆框
                            // 3000毫秒后开始执行
                            setTimeout("jsui.bd.removeClass('sign-show')", 3000);
                        } else {
                            logtips(response.msg);
                            return;
                        }
                    },
                    error: function (response) {
                        // 判断逻辑
                        if (response.status == 422) {
                            var jsonObj = JSON.parse(response.responseText);
                            var errors = jsonObj.errors;
                            console.log(errors);
                            for (var item in errors) {
                                for (var i = 0, len = errors[item].length; i < len; i++) {
                                    logtips(errors[item][i]);
                                    return;
                                }
                            }
                        } else {
                            // 提示
                            logtips('网络错误，请重试...');
                            return;
                        }
                    },
                });
            });

            var _loginTipstimer;

            function logtips(str) {
                if (!str) return false
                _loginTipstimer && clearTimeout(_loginTipstimer);
                $('.sign-tips').html(str).animate({
                    height: 29
                }, 220);
                _loginTipstimer = setTimeout(function () {
                    $('.sign-tips').animate({
                        height: 0
                    }, 220);
                }, 5000);
            }

        }
    }

});
