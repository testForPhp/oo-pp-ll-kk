@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_num" class="layui-form-label">
                    <span class="x-red">*</span>数量
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_num" name="num" required="" lay-verify="num"
                           autocomplete="off" class="layui-input" value="20">
                    <input type="hidden" name="sort_id" value="{{ $code->id }}">
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
                ,num: function(value){
                    if(value == ''){
                        return '数量不能为空';
                    }
                }

            });

            //监听提交
            form.on('submit(add)', function(data){

                $.post('/fileStore/point/code/create',data.field)
                    .done(function (e) {
                        layer.alert(e.message, {icon: 6},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                            let codes = '';
                            $.each(e.data,function (index,val) {
                                codes += '<p>' + val + '</p>';
                            })
                            parent.layer.open({
                                type: 1
                                ,title: false //不显示标题栏
                                ,closeBtn: false
                                ,area: '300px;'
                                ,shade: 0.8
                                ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                                ,resize: false
                                ,btn: ['关闭']
                                ,btnAlign: 'c'
                                ,moveType: 1 //拖拽模式，0或者1
                                ,content: '<div style="padding: 50px; padding-top:20px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">'+codes+'</div>'
                            });
                            //window.location.reload();
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