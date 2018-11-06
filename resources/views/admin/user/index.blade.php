@extends('admin.layouts.comment')
@section('content')
    <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">用户</a>
        <a>
          <cite>用户列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('添加用户','/fileStore/user/create',600,400)"><i class="layui-icon"></i>添加</button>
        </xblock>
        <table class="layui-table">
            <thead>
            <tr>
                <th>
                    <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
                </th>
                <th>ID</th>
                <th>用户名</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user as $item)
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $item->id }}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->username }}</td>
                <td class="td-manage">
                    <a title="编辑"  onclick="x_admin_show('编辑','/fileStore/user/{{$item->id}}/edit',600,400)" href="javascript:;">
                        <i class="layui-icon">&#xe642;</i>
                    </a>
                    <a title="删除" onclick="member_del(this,{{ $item->id }})" href="javascript:;">
                        <i class="layui-icon">&#xe640;</i>
                    </a>
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <script>
        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });

        /*用户-删除*/
        function member_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                if(id == ''){
                    layer.msg('请选择用户!',{icon:1,time:1000});
                    return false;
                }
                $.ajax({
                    method:"delete",
                    url:"/fileStore/user/" + id + "/delete",
                    dataType:"json"
                }).done(function (e) {
                    $(obj).parents("tr").remove();
                    layer.msg(e.message,{icon:1,time:1000});
                }).fail(function (xhr) {
                    layer.msg(jsonForm(xhr.responseJSON),{icon:1,time:1000});
                });

            });
        }

    </script>
    </body>
@stop