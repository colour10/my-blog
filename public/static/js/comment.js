tbfine(function () {

    return {
        init: function () {
            $('.commentlist .url').attr('target', '_blank')

            $('.comment-user-change').on('click', function () {
                $(this).hide()
                $('#comment-author-info').slideDown(300)
            })

            /*
             * comment
             * ====================================================
             */
            var edit_mode = '0',
                txt1 = '<div class="comt-tip comt-loading">评论提交成功，正在跳转，请稍候...</div>',
                txt2 = '<div class="comt-tip comt-error">#</div>',
                txt3 = '">',
                cancel_edit = '取消编辑',
                edit,
                num = 1,
                comm_array = [];
            comm_array.push('');

            $comments = $('#comments-title');
            $cancel = $('#cancel-comment-reply-link');
            cancel_text = $cancel.text();
            $submit = $('#commentform #submit');
            $submit.attr('disabled', false);
            $('.comt-tips').append(txt1 + txt2);
            $('.comt-loading').hide();
            $('.comt-error').hide();
            $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

            // 打印结果
            // console.log($('meta[name="csrf-token"]').attr('content'));
            // console.log($(this).serialize());
            // return;

            $('#commentform').submit(function () {
                // 缓慢展开
                $('.comt-loading').slideDown(2000);
                $submit.attr('disabled', true).fadeTo('slow', 0.5);
                if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');
                $.ajax({
                    url: '/comments',
                    data: $(this).serialize(),
                    type: $(this).attr('method'),
                    error: function (request) {
                        // 打印错误信息
                        console.log(request);
                        // 判断逻辑
                        if (request.status === 422) {
                            var jsonObj = JSON.parse(request.responseText);
                            var errors = jsonObj.errors;
                            for (var item in errors) {
                                for (var i = 0, len = errors[item].length; i < len; i++) {
                                    $('.comt-loading').slideUp(300);
                                    $('.comt-error').slideDown(300).html(errors[item][i]);
                                    setTimeout(function () {
                                        $submit.attr('disabled', false).fadeTo('slow', 1);
                                        $('.comt-error').slideUp(300)
                                    }, 3000);
                                    return;
                                }
                            }
                        } else {
                            // 提示
                            $('.comt-loading').slideUp(300);
                            $('.comt-error').slideDown(300).html('网络错误，请重试...');
                            setTimeout(function () {
                                $submit.attr('disabled', false).fadeTo('slow', 1);
                                $('.comt-error').slideUp(300)
                            }, 3000);
                            return;
                        }
                    },
                    success: function (response) {
                        $('.comt-loading').slideUp(3000);
                        comm_array.push($('#comment').val());
                        $('textarea').each(function () {
                            this.value = ''
                        });

                        // 如果状态码不是0，则报错
                        if (response.code !== 0) {
                            $('.comt-loading').slideUp(300);
                            $('.comt-error').slideDown(300).html(response.msg);
                            setTimeout(function () {
                                $submit.attr('disabled', false).fadeTo('slow', 1);
                                $('.comt-error').slideUp(300)
                            }, 3000);
                            return;
                        }

                        // 6秒后刷新当前页面
                        setTimeout('window.location.reload()', 6000);

                        var t = addComment,
                            cancel = t.I('cancel-comment-reply-link'),
                            temp = t.I('wp-temp-form-div'),
                            respond = t.I(t.respondId),
                            post = t.I('comment_post_ID').value,
                            parent = t.I('comment_parent').value;
                        if (!edit && $comments.length) {
                            n = parseInt($comments.text().match(/\d+/));
                            $comments.text($comments.text().replace(n, n + 1))
                        }
                        new_htm = '" id="new_comm_' + num + '"></';
                        new_htm = (parent == '0') ? ('\n<ol style="clear:both;" class="commentlist commentnew' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');
                        ok_htm = '\n<span id="success_' + num + txt3;
                        ok_htm += '</span><span></span>\n';

                        if (parent == '0') {
                            if ($('#postcomments .commentlist').length) {
                                $('#postcomments .commentlist').before(new_htm);
                            } else {
                                $('#respond').after(new_htm);
                            }
                        } else {
                            $('#respond').after(new_htm);
                        }

                        $('.comment-user-change').show();
                        $('#comment-author-info').slideUp();

                        if (!$('.comment-user-avatar-name').length) {
                            $('.comt-title img').after('<p class="comment-user-avatar-name"></p>');
                        }
                        $('.comment-user-avatar-name').text($('#commentform #author').val());

                        // 测试
                        console.log($('#new_comm_' + num));

                        $('#new_comm_' + num).hide().append(response);
                        $('#new_comm_' + num + ' li').append(ok_htm);
                        $('#new_comm_' + num).fadeIn(1000);
                        /*$body.animate({
                                scrollTop: $('#new_comm_' + num).offset().top - 200
                            },
                            500);*/
                        $('#new_comm_' + num).find('.comt-avatar .avatar').attr('src', $('.commentnew .avatar:last').attr('src'));
                        countdown();
                        num++;
                        edit = '';
                        $('*').remove('#edit_id');
                        cancel.style.display = 'none';
                        cancel.onclick = null;
                        t.I('comment_parent').value = '0';
                        if (temp && respond) {
                            temp.parentNode.insertBefore(respond, temp);
                            temp.parentNode.removeChild(temp);
                        }
                    }
                });
                return false;
            });
            addComment = {
                moveForm: function (commId, parentId, respondId, postId, num) {
                    var t = this,
                        div, comm = t.I(commId),
                        respond = t.I(respondId),
                        cancel = t.I('cancel-comment-reply-link'),
                        parent = t.I('comment_parent'),
                        post = t.I('comment_post_ID');
                    if (edit) exit_prev_edit();
                    num ? (t.I('comment').value = comm_array[num], edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $('#success_' + num), $new_sucs.hide(), $new_comm = $('#new_comm_' + num), $new_comm.hide(), $cancel.text(cancel_edit)) : $cancel.text(cancel_text);
                    t.respondId = respondId;
                    postId = postId || false;
                    if (!t.I('wp-temp-form-div')) {
                        div = document.createElement('div');
                        div.id = 'wp-temp-form-div';
                        div.style.display = 'none';
                        respond.parentNode.insertBefore(div, respond)
                    }
                    !comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
                    $body.animate({
                            scrollTop: $('#respond').offset().top - 180
                        },
                        400);
                    // pcsheight()
                    if (post && postId) post.value = postId;
                    parent.value = parentId;
                    cancel.style.display = '';
                    cancel.onclick = function () {
                        if (edit) exit_prev_edit();
                        var t = addComment,
                            temp = t.I('wp-temp-form-div'),
                            respond = t.I(t.respondId);
                        t.I('comment_parent').value = '0';
                        if (temp && respond) {
                            temp.parentNode.insertBefore(respond, temp);
                            temp.parentNode.removeChild(temp)
                        }
                        this.style.display = 'none';
                        this.onclick = null;
                        return false
                    };
                    try {
                        t.I('comment').focus()
                    } catch (e) {
                    }
                    return false
                },
                I: function (e) {
                    return document.getElementById(e)
                }
            };

            function exit_prev_edit() {
                $new_comm.show();
                $new_sucs.show();
                $('textarea').each(function () {
                    this.value = ''
                });
                edit = ''
            }

            var wait = 15,
                submit_val = $submit.val();

            function countdown() {
                if (wait > 0) {
                    $submit.val(wait);
                    wait--;
                    setTimeout(countdown, 1000)
                } else {
                    $submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
                    wait = 15
                }
            }
        }
    }

})
