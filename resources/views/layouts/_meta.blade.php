<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    @if (strpos($routeInfo['path'],'password') === false)
        @if ($routeInfo['path'] === '/')
            <title>{{ $title }}</title>
        @else
            <title>{{ $title.$webname }}</title>
        @endif
        <meta name="keywords" content="{{ $keywords }}">
        <meta name="description" content="{{ $description }}">
    @else
        <title>密码找回</title>
    @endif


    <link rel='stylesheet' id='_bootstrap-css' href="/static/css/bootstrap.min.css" type='text/css' media='all'/>
    <link rel='stylesheet' id='_fontawesome-css' href="/static/css/font-awesome.min.css" type='text/css' media='all'/>
    <link rel='stylesheet' id='_main-css' href="/static/css/main.css" type='text/css' media='all'/>
    <script type='text/javascript' src="/static/js/jquery.min.js"></script>
    <script type='text/javascript' src="/static/layer/layer.js"></script>
    <!--[if lt IE 9]>
    <script src="/static/js/html5.min.js"></script>
    <![endif]-->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @if (Auth::check())
        <meta name="uid" content="{{ Auth::user()->id }}"/>
    @else
        <meta name="uid" content=""/>
    @endif
</head>
