@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <blockquote class="layui-elem-quote">欢迎管理员：
            <span class="x-red">{{ Auth::guard('admin')->user()->username }}</span>！当前时间:{{ date('Y-m-d H:i:s') }}</blockquote>
        <fieldset class="layui-elem-field">
            <legend>数据统计</legend>
            <div class="layui-field-box">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body">
                            <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                                <div carousel-item="">
                                    <ul class="layui-row layui-col-space10 layui-this">
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>链接数</h3>
                                                <p>
                                                    <cite>{{ $data['link'] }}</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>待审核数</h3>
                                                <p>
                                                    <cite>{{ $data['pedding'] }}</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>广告总数</h3>
                                                <p>
                                                    <cite>{{ $data['ad'] }}</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>激活码已用</h3>
                                                <p>
                                                    <cite>{{ $data['code'] }}</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>分类数</h3>
                                                <p>
                                                    <cite>{{ $data['sort'] }}</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>会员</h3>
                                                <p>
                                                    <cite>{{ $data['user'] }}</cite></p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="layui-elem-field">
            <legend>详细信息</legend>
            <div class="layui-field-box">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <th>精品推荐</th>
                        <td>{{ $more['recommend'] }}</td></tr>
                    <tr>
                        <th>分类排名</th>
                        <td>{{ $more['rank'] }}</td></tr>
                    <tr>
                        <th>颜色推荐</th>
                        <td>{{ $more['color'] }}</td></tr>
                    <tr>
                        <th>图片广告</th>
                        <td>{{ $more['img'] }}</td></tr>
                    </tbody>
                </table>
            </div>
        </fieldset>

    </div>
    </body>
@stop