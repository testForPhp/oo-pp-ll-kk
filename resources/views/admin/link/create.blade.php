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
                <label for="L_link" class="layui-form-label">
                    <span class="x-red">*</span>链接
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_link" name="link" required="" lay-verify="link"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_user" class="layui-form-label">
                    用户ID
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_user" name="user" required=""
                           autocomplete="off" class="layui-input" value="0">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_color" class="layui-form-label">
                    颜色
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_color" name="color" required="" lay-verify="color"
                           autocomplete="off" class="layui-input" value="">
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
                <label for="L_sort" class="layui-form-label">
                    <span class="x-red">*</span>状态
                </label>
                <div class="layui-input-inline">
                    <input type="checkbox" name="status"  lay-text="开启|关闭"  checked="" lay-skin="switch">
                    <input type="hidden" name="sort_id" value="{{ $sort->id }}">
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
                ,link: function(value){
                    if(value == ''){
                        return '链接不能为空';
                    }
                }

            });

            //监听提交
            form.on('submit(add)', function(data){

                $.post('/fileStore/link/create',data.field)
                    .done(function (e) {
                        layer.alert(e.message, {icon: 6},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
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