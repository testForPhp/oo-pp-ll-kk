@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">激活码</a>
        <a>
          <cite>激活码列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('添加激活码','/fileStore/point/create',600,400)">
                <i class="layui-icon"></i>增加
            </button>
        </xblock>
        <table class="layui-table layui-form">
            <thead>
            <tr>
                <th width="20">
                    <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
                </th>
                <th width="70">ID</th>
                <th>点数</th>
                <th>链接</th>
                <th>排序</th>
                <th>备注</th>
                <th>激活码</th>
                <th width="220">操作</th>
            </thead>
            <tbody>
            @foreach($code as $item)
                <tr>
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $item->id }}'><i class="layui-icon">&#xe605;</i></div>
                    </td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->point }}</td>
                    <td>{{ $item->link }}</td>
                    <td>{{ $item->sort }}</td>
                    <td>{{ $item->summary }}</td>
                    <td><a href="/fileStore/point/{{ $item->id }}/code">点击查看</a></td>
                    <td class="td-manage">
                        <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('添加激活码','/fileStore/point/{{ $item->id }}/create/code',400,200)" ><i class="layui-icon">&#xe642;</i>添加激活码</button>
                        <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','/fileStore/point/{{ $item->id }}/edit',600,400)" ><i class="layui-icon">&#xe642;</i>编辑</button>
                        <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{ $item->id }}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="page">
            <div>
                {{ $code->links() }}
            </div>
        </div>
    </div>
    <style type="text/css">

    </style>
    <script>
        layui.use(['form'], function(){
            form = layui.form;

        });

        /*用户-删除*/
        function member_del(obj,id){
            layer.confirm('删除分类以及下属激活码，确认要删除吗？',function(index){
                if(id == ''){
                    layer.msg('请选择分类!',{icon:1,time:1000});
                    return false;
                }

                $.ajax({
                    method:"delete",
                    url:"/fileStore/point/" + id + '/delete',
                    dataType:"json"
                })
                    .done(function (e) {
                        $(obj).parents("tr").remove();
                        layer.msg(e.message,{icon:1,time:1000});
                        window.location.reload();
                    })
                    .fail(function (xhr) {
                        layer.msg(jsonForm(xhr.responseJSON),{icon:1,time:1000});
                    });

            });
        }

    </script>
    </body>
@stop