<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6e1;</i>
                    <cite>管理员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/fileStore/user/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>分类管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/fileStore/sort/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>分类列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6f7;</i>
                    <cite>链接管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/fileStore/link/pending">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>待审核链接</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/fileStore/link/close">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>无法访问</cite>
                        </a>
                    </li >
                    @foreach($sort as $item)
                    <li>
                        <a _href="/fileStore/link/{{ $item->id }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>{{ $item->title }}</cite>
                        </a>
                    </li >
                    @endforeach
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6a9;</i>
                    <cite>激活码管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/fileStore/point/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>激活码列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/fileStore/point/used">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>已使用列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/fileStore/point/log">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>使用记录</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6ae;</i>
                    <cite>系统管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/fileStore/system/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>系统设置</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/fileStore/system/fee">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>价格设置</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/fileStore/system/color">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>颜色设置</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b4;</i>
                    <cite>广告管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/fileStore/ad/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>广告设置</cite>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>