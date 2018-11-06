<!DOCTYPE html>
<html lang="zh-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>{{ Cache::get('system')->website }}-收录最全面的福利导航</title>
    <meta name="Keywords" content="{{  Cache::get('system')->keyword }}">
    <meta name="description" content="{{  Cache::get('system')->descr }}">
    <link rel="stylesheet" rev="stylesheet" href="/css/ifse.css?v7864547567" type="text/css">
    <style type="text/css">
        body{background:#F3F2F1}
        .ascbg,#top-box .serch-box .btns button.ascbg,.fixside>ul>li>a:hover,.pager a:hover,.pager>span{background:#036564;}
        .pager a:hover,.pager>span{border-color:#036564;}
        #top-box,#footer,.list-box .item li.cu a,.fixside li a{background:#033649}
        .list-box .item li.cu div{border-color:#033649;}
        .list-box .item li,.relist-box li{width:16.66666667%;}
        .logo a{
            font-size: 60px;
            color:#fff;
        }
        /* 隐藏主导航 */
        /* .main-nav{display:none;} */
        /* 隐藏手机端通栏广告 */
        /* @media only screen and (max-width:480px){.wvshow{display:none;}} */
    </style>
</head>
<body>
<div id="top-box">
    <div class="header wrap clearfix">
        <div class="logo"><a href="/" title="{{ Cache::get('system')->website }} - {{  Cache::get('system')->descr }}">{{ Cache::get('system')->website }}</a></div>
        <div class="main-nav">
            <ul>
                <li id="nvabar-item-index"><a href="/">首页</a></li>
                @foreach($sort as $key=>$value)
                    <li id="navbar-category-{{ $key + 1 }}"><a href="/#{{ $value->code }}" target="_self">{{ $value->title }}</a></li>
                @endforeach
                <li id="navbar-page-58"><a href="/member/home">提交收录</a></li>
            </ul>
        </div>
        <span class="sn_navico">fa-check-circle-o|fa-envelope|fa-gittip|fa-star|fa-cog</span>
    </div>
</div>
<div class="wvshow wrap">
    @foreach($ad as $item)
    <a href="{{ $item->link }}" target="_blank">
        <img src="{{ $item->img }}" height="60" width="100%" />
    </a>
    @endforeach
    <div style="color:#F00; border:#666 2px dotted; padding:10px; margin-top:10px; cursor:pointer;"><marquee behavior="alternate" onmouseover="this.stop()" onmouseout="this.start()">{!!  Cache::get('system')->notice !!}</marquee></div>
</div>
<span class="sn_cmstii">fa-share-alt|fa-share-alt-square|fa-product-hunt|fa-bars|fa-bars|fa-bars|fa-bars|fa-bars</span>
<div class="index-content wrap">
    @foreach($sort as $key=>$value)
    <div class="list-box list-index" id="{{ $value->code }}">
        <div class="hat">
            <h3 class="ti ascbg"><i class="fa fa-bars"></i><a href="/#{{ $value->code }}" title="{{ $value->title }}">{{ $value->title }}</a></h3>
            <ul>
            </ul>
            <a href="javascript:;" class="arr"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="item">
            <ul class="clearfix">
                @foreach($value->whereActionOrderByLink() as $item)
                <li><a href="{{ $item->link }}" target="_blank">
                        @if(!empty($item->color))
                            <span style="color:{!! $item->color !!} !important;">{{ $item->title }}</span>
                        @else
                            {{ $item->title }}
                        @endif
                    </a></li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach
</div>

<div id="footer">
    <div class="foot-wrap wrap">
        <p><a href="/">{{ Cache::get('system')->website }}</a> &copy;<script>document.write(new Date().getFullYear());</script> Copyright {{ Cache::get('system')->website }} Reserved.
            Powered by <a href="{{Cache::get('system')->weblink }}" target="_blank">{{ Cache::get('system')->website }}</a>
        </p>
    </div>
    <div style="display: none">
        {!! Cache::get('system')->count !!}
    </div>
</div>
</body>
</html>