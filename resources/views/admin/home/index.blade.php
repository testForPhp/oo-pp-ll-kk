@extends('admin.layouts.comment')
@section('content')
    <body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="./index.html">X-admin v2.0</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">

        </ul>
        <ul class="layui-nav right" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;">{{ Auth::guard('admin')->user()->username }}</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="/fileStore/logout">退出</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item to-index"><a href="/">前台首页</a></li>
        </ul>

    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->
    @include('admin.layouts.nav')
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
            <ul class="layui-tab-title">
                <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe src='/fileStore/welcome' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved</div>
    </div>
    <!-- 底部结束 -->
    </body>
@stop