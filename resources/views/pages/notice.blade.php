<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <title>{{ $title }}</title>
    <link rel='stylesheet' id='_bootstrap-css' href='/static/css/bootstrap.min.css' type='text/css' media='all' />
    <link rel='stylesheet' id='_fontawesome-css' href='/static/css/font-awesome.min.css' type='text/css' media='all' />
    <link rel='stylesheet' id='_main-css' href='/static/css/main.css' type='text/css' media='all' />
    <script type='text/javascript' src='/static/js/jquery.min.js'></script>
    <style>
        .widget_media_image {
            border: none
        }

        @media (max-width: 1024px) {
            .sidebar {
                display: block;
                float: none;
                width: auto;
                margin: 15px;
                clear: both;
            }

            .widget.affix {
                position: relative;
                width: auto;
                top: 0 !important;
            }
        }

        .navred a {
            color: #FF5E52 !important;
            font-weight: bold;
        }
    </style>
    <!--HEADER_CODE_END-->
    <!--[if lt IE 9]>
    <script src="/static/js/html5.min.js"></script><![endif]-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="error404 m-excerpt-cat m-excerpt-time site-layout-2 text-justify-on">

    @include('layouts._header')

    <section class="container">
        <div class="f404">
            <img src="/static/images/404.png">
            <h2>{{ $content }}</h2>
            <p>
                <a class="btn btn-primary" href="http://www.liuzongyang.com">返回 刘宗阳博客 首页</a>
            </p>
        </div>
    </section>

    @include('layouts._footer')

    <script type='text/javascript' src='/static/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='/static/js/loader.js'></script>
    <script type='text/javascript' src='/static/js/wp-embed.min.js'></script>

</body>

</html>