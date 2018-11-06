@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_point" class="layui-form-label">
                    <span class="x-red">*</span>点数
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_point" name="point" required="" lay-verify="point"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_link" class="layui-form-label">
                    <span class="x-red">*</span>链接
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_link" name="link" required="" lay-verify="link"
                           autocomplete="off" class="layui-input" value="">
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
                <label for="L_summary" class="layui-form-label">
                    <span class="x-red">*</span>备注
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_summary" name="summary" required="" lay-verify="summary"
                           autocomplete="off" class="layui-input" value="">
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
                point: function(value){
                    if(value == ''){
                        return '点数不能为空';
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

                $.post('/fileStore/point/create',data.field)
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