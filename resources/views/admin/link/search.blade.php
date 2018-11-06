@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">链接</a>
        <a>
          <cite>搜索</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so" method="get" action="/fileStore/link/search">
                <input type="text" name="title"  placeholder="请输入名称" autocomplete="off" class="layui-input">
                <input type="text" name="link"  placeholder="请输入链接" autocomplete="off" class="layui-input">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <table class="layui-table layui-form">
            <thead>
            <tr>
                <th width="20">
                    <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
                </th>
                <th width="70">ID</th>
                <th>名称</th>
                <th>链接</th>
                <th>分类</th>
                <th>用户</th>
                <th>推荐</th>
                <th>状态</th>
                <th>时间</th>
                <th width="220">操作</th>
            </thead>
            <tbody>
            @foreach($links as $item)
                <tr>
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id=''><i class="layui-icon">&#xe605;</i></div>
                    </td>
                    <td>{{ $item->id }}</td>
                    <td>
                        {{ $item->title }}
                    </td>
                    <td>{{ $item->link }}</td>
                    <td>{{ $item->sort->title }}</td>
                    <td>@isset($item->user->name){{ $item->user->name }}@endif</td>
                    <td>@if($item->type == 1)是 @else 否 @endif</td>
                    <td>@if($item->status == 0)显示 @else 不显示 @endif</td>
                    <td>@if(isset($item->created_at)){{ $item->created_at->format('Y-m-d H:i:s') }} @endif</td>
                    <td class="td-manage">
                        <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','/fileStore/link/{{ $item->id }}/edit')" ><i class="layui-icon">&#xe642;</i>编辑</button>
                        <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{ $item->id }}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <style type="text/css">

    </style>
    <script>
        layui.use(['form'], function(){
            form = layui.form;

        });

        /*用户-删除*/
        function member_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                if(id == ''){
                    layer.msg('请选择链接!',{icon:1,time:1000});
                    return false;
                }

                $.ajax({
                    method:"delete",
                    url:"/fileStore/link/" + id + '/delete',
                    dataType:"json"
                })
                    .done(function (e) {
                        $(obj).parents("tr").remove();
                        layer.msg(e.message,{icon:1,time:1000});
                    })
                    .fail(function (xhr) {
                        layer.msg(jsonForm(xhr.responseJSON),{icon:1,time:1000});
                    });

            });
        }

    </script>
    </body>
@stop