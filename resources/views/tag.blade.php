@include('layouts._meta')

<body class="archive category category-tech category-1 nav_fixed m-excerpt-cat site-layout-2 text-justify-on">

@include('layouts._header')

<section class="container">
    <div class="content-wrap">
        <div class="content">
            <div class="pagetitle">
                <h1>标签：{{ $name }}</h1>
            </div>
            @foreach ($infos as $info)
                @if (empty($info->cover))
                    <article class="excerpt excerpt-2 excerpt-text">
                        @else
                            <article class="excerpt excerpt-3">
                                <a class="focus"
                                   href="{{ route('infos.show', ['uri' => $info->channel->uri, 'id' => $info->id]) }}"><img
                                        data-src="{{ $info->cover }}" alt="{{ $info->title }}"
                                        src="/static/images/thumbnail.png" class="thumb"></a>
                                @endif
                                <header>
                                    <h2>
                                        <a href="{{ route('infos.show', ['uri' => $info->channel->uri, 'id' => $info->id]) }}"
                                           title="{{ $info->title }}">{{ $info->title }}</a></h2>
                                </header>
                                <p class="meta">
                                    <time><i class="fa fa-clock-o"></i>{{ date('Y-m-d', strtotime($info->crontab_at)) }}
                                    </time>
                                    <span class="author"><i class="fa fa-user"></i>刘宗阳</span><span class="pv"><i
                                            class="fa fa-eye"></i>阅读({{ $info->click }})</span>
                                    <a class="pc"
                                       href="{{ route('infos.show', ['uri' => $info->channel->uri, 'id' => $info->id]) }}#respond"><i
                                            class="fa fa-comments-o"></i>评论({{ $info->comments_count }})</a>
                                    <a href="javascript:;" etap="like" class="post-like" data-pid="70"><i
                                            class="fa fa-thumbs-o-up"></i>赞(<span>0</span>)</a>
                                </p>
                                <p class="note">{{ $info->description }}</p>
                            </article>
                            @endforeach

                            <div class="pagination">
                                {!! $infos->links() !!}
                            </div>

        </div>
    </div>

    @include('layouts._sidebar')

</section>

@include('layouts._footer')

</body>

</html>
