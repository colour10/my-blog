@include('layouts._meta')

<body
    class="post-template-default single single-post postid-49 single-format-standard nav_fixed m-excerpt-cat p_indent comment-open site-layout-2 text-justify-on">

@include('layouts._header')

<div class="breadcrumbs">
    <div class="container">当前位置：{!! $breakcrumb !!}</div>
</div>

<section class="container">
    <div class="content-wrap">
        <div class="content">
            <header class="article-header">
                <h1 class="article-title">{{ $info['title'] }}</h1>
                <div class="article-meta">
                    <span class="item">{{ date('Y-m-d', strtotime($info['created_at'])) }}</span>
                    <span class="item">分类：<a
                            href="{{ route('channels.show', ['uri' => $info['channel']['uri']]) }}">{{ $info['channel']['name'] }}</a></span>
                    <span class="item post-views">阅读({{ $info['click'] }})</span> <span class="item">评论(0)</span>
                    <span class="item"></span>
                </div>
            </header>

            <article class="article-content">
                {!! $info['content'] !!}
            </article>

            <div class="post-copyright">未经允许不得转载：{{ $info['title'] }}</div>
            <div class="article-tags">标签：
                @if (isset($tags))
                    @foreach ($tags as $tag)
                        <a href="{{ route('tags.show', ['tag' => $tag['id']]) }}"
                           rel="tag">{{ $tag['name'] }}</a>
                    @endforeach
                @endif
            </div>

            <nav class="article-nav">
                @if (isset($prev))
                    <span class="article-nav-prev">上一篇<br><a
                            href="{{ route('infos.show', ['uri' => $prev['channel']['uri'], 'id' => $prev['id']]) }}"
                            rel="prev">{{ $prev['title'] }}</a></span>
                @endif

                @if (isset($next))
                    <span class="article-nav-next">下一篇<br><a
                            href="{{ route('infos.show', ['uri' => $next['channel']['uri'], 'id' => $next['id']]) }}"
                            rel="next">{{ $next['title'] }}</a></span>
                @endif
            </nav>

            @if (isset($tagInfos) && count($tagInfos) > 0)
                <div class="relates">
                    <div class="title">
                        <h3>相关推荐</h3>
                    </div>
                    <ul>
                        @foreach ($tagInfos as $info)
                            <li>
                                <a href="{{ route('infos.show', ['uri' => $info['uri'], 'id' => $info['id']]) }}">{{ $info['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="title" id="comments">
                <h3>评论 <b>0</b></h3>
            </div>

            @if (!\Session::get('user'))
                <div class="no_webshot" id="comment_login">
                    <div class="comment-signarea">
                        <h3 class="text-muted">评论前必须登录！</h3>
                        <p>
                            <a href="javascript:;" class="btn btn-primary signin-loader">立即登录</a> &nbsp;
                            <a href="javascript:;" class="btn btn-default signup-loader">注册</a>
                        </p>
                    </div>
                </div>
            @endif

            <div id="respond" class="no_webshot" @if (\Session::get('user')) style="display:block;"
                 @else style="display:none;" @endif>
                <form method="post" id="commentform">
                    <div class="comt">
                        <div class="comt-title">
                            <img alt='' data-src='/static/images/ff4afbed206e455aa4b2561dc5f6344b.gif'
                                 class='avatar avatar-50 photo avatar-default' height='50' width='50'/>
                            <p><a id="cancel-comment-reply-link" href="javascript:;">取消</a></p>
                        </div>
                        <div class="comt-box">
                            <textarea placeholder="你的评论可以一针见血" class="input-block-level comt-area" name="comment"
                                      id="comment" cols="100%" rows="3" tabindex="1"
                                      onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
                            <div class="comt-ctrl">
                                <div class="comt-tips">
                                    @csrf
                                    <input type='hidden' name='comment_post_ID' value='{{ $info_id }}'
                                           id='comment_post_ID'/>
                                    <input type='hidden' name='comment_parent' id='comment_parent' value='0'/>
                                    <input type="hidden" name="user_id" value="{{ \Session::get('user')['id'] }}">
                                    <label for="comment_mail_notify" class="checkbox inline hide" style="padding-top:0"><input
                                            type="checkbox" name="comment_mail_notify" id="comment_mail_notify"
                                            value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>
                                </div>
                                <button type="submit" name="submit" id="submit" tabindex="5">提交评论</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div id="postcomments">
                <ol class="commentlist">
                @if (isset($comments))
                    @foreach ($comments as $comment)
                        <!-- 评论 Start -->
                            <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1"
                                id="comment-{{ $comment['id'] }}" data-level="{{ $comment['level'] }}">
                                @if ($comment['pid'] == 0)
                                    <span class="comt-f"></span>
                                @endif
                                <div class="comt-avatar"><img alt='' data-src='{{ $comment['user']["avatar"] }}'
                                                              class='avatar avatar-50 photo' height='50' width='50'/>
                                </div>
                                <div class="comt-main" id="div-comment-{{ $comment['id'] }}">
                                    @if ($comment['pid'])
                                        <p>回复：{{ $comment['pid_username'] }}　{{ $comment['content'] }}</p>
                                    @else
                                        <p>{{ $comment['content'] }}</p>
                                    @endif
                                    <div class="comt-meta">
                                        <span class="comt-author">{{ $comment['user']['username'] }}</span>

                                        {{ $comment['created_at_forhuman'] }}

                                        <a rel='nofollow' class='comment-reply-link' href="javascript:;"
                                           onclick='return addComment.moveForm( "div-comment-{{ $comment['id'] }}", "{{ $comment['id'] }}", "respond", "{{ $comment['info_id'] }}" )'
                                           aria-label='回复给{{ $comment['pid_username'] }}'>回复</a>
                                    </div>
                                </div>
                            </li>
                            <!-- 评论 End -->
                        @endforeach
                    @endif
                </ol>
                <div class="pagenav">
                </div>
            </div>
        </div>
    </div>

    @include('layouts._sidebar')

</section>

@include('layouts._footer')

</body>

<script type="text/javascript">
    // 初始化
    $(function () {
        $('.comment').each(function () {
            var level = $(this).attr('data-level');
            $(this).css('margin-left', 46 * level);
        });

        // 判断用户是否登陆
        $.get('{{ route("home.isLogin") }}', function (response) {
            // 打印结果
            console.log(response);
            let comt_title = $('.comt-title');
            // 如果登陆
            if (response.code === 0) {
                // 替换默认头像
                if (comt_title.length > 0) {
                    comt_title.children('img').eq(0).attr('src', response.data.avatar);
                    comt_title.children('img').eq(0).attr('data-src', response.data.avatar);
                }
            }
        });
    });
</script>

</html>

