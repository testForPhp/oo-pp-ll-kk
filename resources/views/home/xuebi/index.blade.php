<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ Cache::get('system')->website }}-精品福利导航第一品牌</title>
    <meta name="description" content="{{  Cache::get('system')->descr }}"/>
    <meta name="keywords" content="{{  Cache::get('system')->keyword }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" type="text/css" media="screen and (max-width:640px)" href="/css/xuebi/wapcss.css?v0.41234234">
    <link rel="stylesheet" type="text/css" media="screen and (min-width:640px)" id="cssfile" href="/css/xuebi/skin-green.css?v0.87696">
</head>

<body data-spy="scroll" data-target="#nav-plane" data-offset="49" oncontextmenu="window.event.returnValue=false" onselectstart="event.returnValue=ture">
<!--顶部-->
<div class="head">
    <div class="head_main">
        <a href="/" class="logo" title="{{  Cache::get('system')->website }}-{{  Cache::get('system')->descr }}">
            <h1>{{  Cache::get('system')->website }}</h1>
        </a>
        <span class="wap_introduce"><a href="#">雪B福利导航 - 手机版</a></span>
        <!--导航-->
        <div class="head_more">
            <a href="javascript:;" class="zx" rel="external _blank"><span>最新地址：{{  Cache::get('system')->newlink }}</span></a><a href="javascript:;" class="fb" rel="external _blank"><span>永久地址：{{  Cache::get('system')->weblink }}</span></a><a href="/member/home" class="lx" rel="external _blank"><span>广 告</span></a><a href="/member/home" class="sl" rel="external _blank"><span>收 录</span></a>
            </ul>
        </div>
    </div>
</div>

<div id="top"></div>

<div class="banner">
    @foreach($ad as $item)
        <a href="{{ $item->link }}" target="_blank">
            <img src="{{ $item->img }}" width="100%" height="60"/>
        </a>
    @endforeach
</div>

<div id="tuijian" class="nav">
    <li><a href="/">首页</a></li>
    <li><a href="/member/home">自助收录</a></li>
    <li><a href="/member/home">自助广告</a></li>
</div>

<div id="tuijian" class="look">

    <div class="focus">

        <a href="/" rel="noopener" class="cu"><font color='Yellow'>精品推荐栏目</font></a>
        @foreach($sort[0]->whereActionOrderByLink() as $item)
        <a href="{{ $item->link }}" target="_blank" rel="noopener" class="cu">@if(!empty($item->color))
                <span style="color:{!! $item->color !!} !important;">{{ $item->title }}</span>
            @else
                {{ $item->title }}
            @endif
        </a>
        @endforeach
    </div>

    <div class="news">
        <div class="news_box">
            <div class="news_title">
                <h2>本站公告</h2>
            </div>
            <ul class="news_list">
                {!!  Cache::get('system')->notice !!}
            </ul>
        </div>
        <a class="news_url open" href="javascript:;" rel="external _blank">
            <div>
                本站永久网址
            </div>
            <span class="fs17 border hong">{{  Cache::get('system')->weblink }}</span></a>
    </div>

</div>
<div class="clear"></div>
@php
unset($sort[0])
@endphp

@foreach($sort as $key=>$value)
<div id="{{ $value->code }}" class="web">
    <div class="web_class">
        <div class="web_class_title">
            <h2>{{ $value->title }}</h2>
        </div>
    </div>
    <div class="web_class_tip">
    </div>
    <ul class="web_list">
        @foreach($value->whereActionOrderByLink() as $item)
        <li><a href="{{ $item->link }}" target="_blank" rel="external nofollow">
                @if(!empty($item->color))
                    <span style="color:{!! $item->color !!} !important;">{{ $item->title }}</span>
                @else
                    {{ $item->title }}
                @endif
            </a></li>
        @endforeach
        <div class="clear">
        </div>
    </ul>
</div>
@endforeach

<div class="bottom">
    <div class="bm">
        以上网站内容均与本站无关,本站只为海外华人提供导航服务,未满18岁禁止点击本导航内网站！
        <br>
        Copyright @ 2017
        <a href="{{Cache::get('system')->weblink }} "></a>{{ Cache::get('system')->website }} UI.Av福利导航 Inc. All Rights Reserved
    </div>
</div>

<div class="r_nav">
    <a href="#tuijian" class="top" rel="external _blank"></a>
</div>

<div id="nav-plane" style="overflow:hidden">
    <ul>
        <li class="active"><a href="#top" rel="external _blank">TOP</a></li>
        @foreach($sort as $key=>$value)
            <li id="navbar-category-{{ $key + 1 }}"><a href="/#{{ $value->code }}" target="_self" rel="external _blank">{{ $value->title }}</a></li>
        @endforeach
    </ul>

</div>
<div style="display:none">
    {!! Cache::get('system')->count !!}
</div>
</body>
</html>
