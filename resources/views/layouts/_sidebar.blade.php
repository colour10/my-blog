<div class="sidebar">
    <div class="widget sidebar_ui_textasb">
        <a class="style02" href="javascript:void(0);">
            <strong>博主简介</strong>
            <h2>关于刘宗阳博客</h2>
            <p>
                刘宗阳PHP个人技术博客主要记录了Linux学习和Linux服务器入门教程，PHP开发和PHP主流框架实战技巧，Web前端开发和Web框架学习，MySQL基础和MySQL运维实用技巧，MongoDB、Redis、Memcache等NoSQL数据库教程以及个人的人生经历和观点。</p>
            <br>
            <p>博客前台采用大前端模版，后台采用Laravel6 + Mysql5.7，还应用了Redis缓存技术以及大量的任务队列进行处理。</p>
        </a>
    </div>

    <!-- 推荐文字广告位 Start -->
    <div class="widget sidebar_ui_textasb widget_ui_tools">
        <strong>吐血推荐</strong>
        <a class="style01" href="https://my.hxkvm.com/flag/4951" target="_blank">
            <h2>海星云主机</h2>
            <p>采用成熟的KVM虚拟化技术，配合自主研发简体中文易操作控制面板，并带有一键备份，一键恢复等功能，也是刘宗阳博客目前在用的主机，强烈推荐~</p>
        </a>
    </div>
    <!-- 推荐文字广告位 End -->

    <div class="widget widget_ui_posts">
        <h3>热门文章</h3>
        <ul class="nopic">
            @if (isset($hotInfos))
                @foreach ($hotInfos as $info)
                    <li>
                        <a href="{{ route('infos.show', ['uri' => $info['channel']['uri'], 'id' => $info['id'] ]) }}">
                            <span class="text">{{ $info['title'] }}</span>
                            <span class="muted">{{ date('Y-m-d', strtotime($info['crontab_at'])) }}</span>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>

    <div class="widget widget_ui_comments">
        <h3>最新评论</h3>
        <ul>
            @if (isset($recentComments))
                @foreach ($recentComments as $recentComment)
                    <li>
                        <a href="{{ route('infos.show', ['uri' => $recentComment['channel']['uri'], 'id' => $recentComment['info_id']]) }}#comment-{{ $recentComment['id'] }}"
                           title="{{ $recentComment['info']['title'] }}"><img alt=''
                                                                              data-src='{{ $recentComment['avatar'] }}'
                                                                              class='avatar avatar-50 photo' height='50'
                                                                              width='50'/><strong>{{ $recentComment['user']['username'] }}</strong> {{ $recentComment['created_at_forhuman'] }}
                            说：<br>{{ $recentComment['content'] }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="widget widget_ui_tags">
        <h3>热门标签</h3>
        <div class="items">
            <!-- 标签循环，如果标签文章数为0，则不显示该标签 Start -->
            @if (isset($allTags))
                @foreach ($allTags as $tag)
                    @if ($tag['infos_count'])
                        <a href="{{ route('tags.show', ['tag' => $tag['id']]) }}">{{ $tag['name'] }}
                            ({{ $tag['infos_count'] }}
                            )</a>
                @endif
            @endforeach
        @endif
        <!-- 标签循环，如果标签文章数为0，则不显示该标签 End -->
        </div>
    </div>

    <!-- 有意思的小工具 Start -->
    <div class="widget sidebar_ui_textasb widget_ui_tools">

        <strong>常用小工具</strong>

        <a class="style01" href="/urlopener/">
            <h2>网址批量打开工具</h2>
            <p>【网址批量打开工具】主要用于解决一键在线批量打开URL、网址、网站，无需在您的电脑上安装任何软件，支持多平台和常见桌面浏览器，方便快捷~</p>
        </a>

    </div>
    <!-- 有意思的小工具 End -->

</div>

