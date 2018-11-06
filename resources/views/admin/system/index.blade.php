@extends('admin.layouts.comment')
@section('content')
    <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_website" class="layui-form-label">
                    <span class="x-red">*</span>网站名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_website" name="website" required="" lay-verify="website"
                           autocomplete="off" class="layui-input" value="{{ $system->website }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_weblink" class="layui-form-label">
                    <span class="x-red">*</span>永久链接
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_weblink" name="weblink" required="" lay-verify="weblink"
                           autocomplete="off" class="layui-input" value="{{ $system->weblink }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_newlink" class="layui-form-label">
                    <span class="x-red">*</span>最新链接
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_newlink" name="newlink" required="" lay-verify="newlink"
                           autocomplete="off" class="layui-input" value="{{ $system->newlink }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>E-mail
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="email" required="" lay-verify="email"
                           autocomplete="off" class="layui-input" value="{{ $system->email }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_skin" class="layui-form-label">
                    <span class="x-red">*</span>皮肤
                </label>
                <div class="layui-input-inline">
                    <select id="skin" name="skin" class="valid">
                        @foreach($skin as $item)
                        <option value="{{ $item }}" @if($system->skin == $item) selected @endif>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_forever" class="layui-form-label">
                    <span class="x-red">*</span>发布页地址
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_forever" name="forever" required="" lay-verify="forever"
                           autocomplete="off" class="layui-input" value="{{ $system->forever }}">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="L_keyword" class="layui-form-label">
                    网站关键字
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="L_keyword" lay-verify="keyword" name="keyword" class="layui-textarea">{{ $system->keyword }}</textarea>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="L_descr" class="layui-form-label">
                    网站描述
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="L_descr" lay-verify="descr" name="descr" class="layui-textarea">{{ $system->descr }}</textarea>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="L_notice" class="layui-form-label">
                    网站公告
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="L_notice" lay-verify="notice" name="notice" class="layui-textarea">{{ $system->notice }}</textarea>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="L_notice" class="layui-form-label">
                    会员中心公告
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="L_member_notice" lay-verify="member_notice" name="member_notice" class="layui-textarea">{{ $system->member_notice }}</textarea>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="L_count" class="layui-form-label">
                    网站统计
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="L_count" lay-verify="count" name="count" class="layui-textarea">{{ $system->count }}</textarea>
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

            //自定义验证规则
            form.verify({
                website: function(value){
                    if(value.length < 2){
                        return '名称至少得2个字符啊';
                    }
                }

            });

            //监听提交
            form.on('submit(add)', function(data){
                $.post('/fileStore/system',data.field)
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