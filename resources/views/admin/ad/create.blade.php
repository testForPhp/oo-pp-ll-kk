@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_img" class="layui-form-label">
                    <span class="x-red">*</span>图片
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_img" name="img" required="" lay-verify="img"
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
                <label for="L_user_id" class="layui-form-label">
                    <span class="x-red">*</span>用户
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_user_id" name="user_id" required="" lay-verify="user_id"
                           autocomplete="off" class="layui-input" value="0">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_sort" class="layui-form-label">
                    <span class="x-red">*</span>排序
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_sort" name="sort" required="" lay-verify="sort"
                           autocomplete="off" class="layui-input" value="10">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_status" class="layui-form-label">
                    <span class="x-red">*</span>是否显示
                </label>
                <div class="layui-input-inline">
                    <input type="checkbox" name="status"  lay-text="显示|关闭"  checked="" lay-skin="switch">
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
                img: function(value){
                    if(value == ''){
                        return '图片不能为空';
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

                $.post('/fileStore/ad/create',data.field)
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