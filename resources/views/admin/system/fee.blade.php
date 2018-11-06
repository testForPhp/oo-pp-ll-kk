@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_rank" class="layui-form-label">
                    <span class="x-red">*</span>排名价格
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_rank" name="rank" required="" lay-verify="rank"
                           autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->rank }} @endif">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_rank_num" class="layui-form-label">
                    <span class="x-red">*</span>排名数量
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_rank_num" name="rank_num" required="" lay-verify="rank_num"
                           autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->rank_num }} @endif">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_color" class="layui-form-label">
                    <span class="x-red">*</span>加颜色价格
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_color" name="color" required="" lay-verify="color" autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->color }} @endif">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_color_num" class="layui-form-label">
                    <span class="x-red">*</span>加颜色数量
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_color_num" name="color_num" required="" lay-verify="color_num" autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->color_num }} @endif">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_img" class="layui-form-label">
                    <span class="x-red">*</span>图片广告价格
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_img" name="img" required="" lay-verify="img"
                           autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->img }} @endif">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_img_num" class="layui-form-label">
                    <span class="x-red">*</span>图片广告数量
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_img_num" name="img_num" required="" lay-verify="img_num" autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->img_num }} @endif">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_recommend" class="layui-form-label">
                    <span class="x-red">*</span>精品推荐价格
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_recommend" name="recommend" required="" lay-verify="recommend" autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->recommend }} @endif">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_recommend_num" class="layui-form-label">
                    <span class="x-red">*</span>精品推荐数量
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_recommend_num" name="recommend_num" required="" lay-verify="recommend_num" autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->recommend_num }} @endif">
                </div>
            </div><div class="layui-form-item">
                <label for="L_recommend_id" class="layui-form-label">
                    <span class="x-red">*</span>精品推荐栏目ID
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_recommend_id" name="recommend_id" required="" lay-verify="recommend_id" autocomplete="off" class="layui-input" value="@if(isset($fee)){{ $fee->recommend_id }} @endif">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    提交
                </button>
            </div>
        </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;

            //监听提交
            form.on('submit(add)', function(data){
                $.post('/fileStore/system/fee',data.field)
                    .done(function (e) {
                        layer.msg(e.message);
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