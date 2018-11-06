@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_title" class="layui-form-label">
                    <span class="x-red">*</span>名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_title" name="title" required="" lay-verify="title"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_code" class="layui-form-label">
                    <span class="x-red">*</span>代码
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_code" name="code" required="" lay-verify="code"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_sort" class="layui-form-label">
                    <span class="x-red">*</span>排序
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_sort" name="sorting" required="" lay-verify="sorting"
                           autocomplete="off" class="layui-input" value="10">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_sort" class="layui-form-label">
                    <span class="x-red">*</span>是否推荐
                </label>
                <div class="layui-input-inline">
                    <input type="checkbox" name="type"  lay-text="推荐|关闭"  checked="" lay-skin="switch">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    增加
                </button>
            </div>
        </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;

            //自定义验证规则
            form.verify({
                title: function(value){
                    if(value == ''){
                        return '名称不能为空';
                    }
                }
                ,code: function(value){
                    if(value == ''){
                        return '代码不能为空';
                    }
                }

            });

            //监听提交
            form.on('submit(add)', function(data){

                $.post('/fileStore/sort/create',data.field)
                    .done(function (e) {
                        layer.alert(e.message, {icon: 6},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                            window.location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        layer.msg(jsonForm(xhr.responseJSON));
                    });
                return false;
            });


        });
    </script>
    </body>

@stop