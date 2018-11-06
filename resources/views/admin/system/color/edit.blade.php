@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_code" class="layui-form-label">
                    <span class="x-red">*</span>代码
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_code" name="code" required="" lay-verify="code" autocomplete="off" class="layui-input" value="{{ $color->code }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_color" class="layui-form-label">
                    <span class="x-red">*</span>颜色
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_color" name="color" required="" lay-verify="color" autocomplete="off" class="layui-input" value="{{ $color->color }}">
                    <input type="hidden" name="id" value="{{ $color->id }}">
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
                code: function(value){
                    if(value == ''){
                        return '名称不能为空';
                    }
                }
                ,color: function(value){
                    if(value == ''){
                        return '颜色不能为空';
                    }
                }

            });

            //监听提交
            form.on('submit(add)', function(data){

                $.post('/fileStore/system/color/edit',data.field)
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