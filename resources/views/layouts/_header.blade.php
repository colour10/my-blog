<header class="header">
    <div class="container">
        <div class="logo">
            <a href="/" title="刘宗阳博客"><img src="/static/images/logo.png" alt="刘宗阳博客">刘宗阳博客</a>
        </div>
        <div class="brand">
            欢迎光临
            <br>一起探讨学习进步
        </div>

        <ul class="site-nav site-navbar">

            <li id="menu-item-0"
                class="menu-item menu-item-type-custom menu-item-object-custom current_page_item menu-item-home nav-menu<?php if ($routeInfo['path'] == "/") { ?> current-menu-item<?php } ?>">
                <a title="PHP程序员，刘宗阳的博客" href="/">首页</a></li>

            @include('layouts._nav')

            <li class="navto-search"><a href="javascript:;" class="search-show active"><i class="fa fa-search"></i></a>
            </li>
        </ul>

        <div class="topbar">
            <ul class="site-nav topmenu">
                <li id="menu-item-112" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-112"><a
                        href="{{ route('guestbooks.index') }}">留言板</a></li>
                <li class="menusns">
                    <a href="javascript:;">关注我们 <i class="fa fa-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li><a class="sns-wechat" href="javascript:;" title="关注微信"
                               data-src="/static/images/qrcode/qrcode_for_gh_80345cb017b4_430.jpg">关注微信</a></li>
                    </ul>
                </li>
            </ul>

            <span id="logined" @if (Session::has('user')) style="display:inline;" @else style="display:none;" @endif>
                        <a href="javascript:;">欢迎您，<span
                                id="user_name">{{ Session::has('user') ? Session::get('user')['username'] : '' }}</span></a>&nbsp; &nbsp; <a
                    class="logout">退出登陆</a>
                    </span>

            <span id="notlogin" @if (Session::has('user')) style="display:none;" @else style="display:inline;" @endif>
                        <a href="javascript:;" class="signin-loader">Hi, 请登录</a> &nbsp; &nbsp; <a href="javascript:;"
                                                                                                  class="signup-loader">我要注册</a> &nbsp; &nbsp;
                <!-- <a href="/password/reset">找回密码</a> -->
                    </span>

        </div>
        <i class="fa fa-bars m-icon-nav"></i>
    </div>
</header>

<div class="site-search">
    <div class="container">
        <form method="get" class="site-search-form" action="{{ route('home.index') }}"><input class="search-input"
                                                                                              name="keyword" type="text"
                                                                                              placeholder="输入关键字"
                                                                                              value="">
            <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>
