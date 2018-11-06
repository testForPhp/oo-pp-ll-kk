<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <title>{{ Cache::get('system')->website }}-收录最全面的福利导航</title>
    <meta name="keywords" content="{{  Cache::get('system')->keyword }}">
    <meta name="description" content="{{  Cache::get('system')->descr }}">
    <link rel="stylesheet" id="da-main-css" href="/css/style.css?v0.125623" type="text/css" media="all">
</head>
<body class="page page-id-5013 page-template page-template-pagesnav-php">
<div class="pageheader">
    <div class="container">
        <h1><a href="/" title="{{  Cache::get('system')->website }}-{{  Cache::get('system')->descr }}">{{  Cache::get('system')->website }}</a></h1>
        <div class="note">
            {!!  Cache::get('system')->notice !!}
        </div>
    </div>
</div>
<section class="container" id="navs">
    <nav>
        <li id="nvabar-item-index"><a href="/#top" target="_self">首页</a></li>
        @foreach($sort as $key=>$value)
            <li id="navbar-category-{{ $key + 1 }}"><a href="/#{{ $value->code }}" target="_self">{{ $value->title }}</a></li>
        @endforeach
    </nav>

    <div class="items">
        @yield('content')
    </div>
</section>
<div id="footer">
    <div class="container">
        <p>&copy; Copyright {{Cache::get('system')->weblink }} All rights reserved. Power By <a target="_blank" href="/" title="{{ Cache::get('system')->website }}">{{ Cache::get('system')->website }}</a>
        </p>
        <p>{{ Cache::get('system')->website }}（{{ Cache::get('system')->weblink }}）秉承创建完全绿色无广告福利导航的宗旨，努力打造福利导航第一品牌！</p>
        <div style="display: none">
            {!! Cache::get('system')->count !!}
        </div>
    </div>
</div>
</body>
</html>