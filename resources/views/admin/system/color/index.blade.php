@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">系统设置</a>
        <a>
          <cite>颜色列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('添加颜色','/fileStore/system/color/create',600,400)">
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
                <th>代码</th>
                <th>颜色</th>
                <th width="220">操作</th>
            </thead>
            <tbody>
            @foreach($color as $item)
                <tr>
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $item->id }}'><i class="layui-icon">&#xe605;</i></div>
                    </td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->code }}</td>
                    <td>
                        <button class="layui-btn" style="background-color: {{ $item->color }}" ><i class="layui-icon"></i></button>
                    </td>
                    <td class="td-manage">
                        <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','/fileStore/system/color/{{ $item->id }}/edit',400,300)" ><i class="layui-icon">&#xe642;</i>编辑</button>
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
                    layer.msg('请选择颜色!',{icon:1,time:1000});
                    return false;
                }

                $.ajax({
                    method:"delete",
                    url:"/fileStore/system/color/" + id + '/delete',
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