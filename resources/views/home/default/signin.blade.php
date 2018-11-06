@extends('home.default.layout')
@section('content')
    <div class="items">
        <div class="item item-0">
            @include('home.default.menu')
            <h2>申请收录</h2><div class="page_content">
                <p>	<span style="color:#4C33E5;"><b>所有申请站点需保证有免费资源通道，不收录纯收费站点</b></span></p>
                <p>	<span style="color:#0cd7e2;"><b>提交前，请在贵站首页前三位置处添加本站链接，来路越多在本站排名越靠前</b></span></p>
                <p>	<span style="color:#0cd7e2;"><b>提交后，请在贵站上点击一次本站链接就会自动收录!</b></span></p>
                <p>	本站将定期抽查所有网站，如发现链接失效﹑更换本站位置﹑下掉本站链接的情况将立即删除</p>
                <p>	贵站如有弹窗请勿提交，提交也不会被收录</p>
                <hr />
                <p>	名称：<span style="color:#12e812;">
                        <b>{{ Cache::get('system')->website }}</b></span>
                </p>
                <p>	地址：<span style="color:#12e812;"><b>{{ Cache::get('system')->newlink }}</b></span>
                    <span style="color:red;"><b> (注：本站友链专用域名，设置本站友链时，请填此域名，填别的域名概不收录，谢谢合作)</b>
                    </span>
                </p>
                <div class="input">
                    <div>网站名称：<input type="text" name="name" id="name" placeholder="最多8个文字！" maxlength="8" class="signinput" style="margin-bottom: 10px;"></div>
                    <div>网站地址：<input type="text" name="url" id="url" placeholder="网址必须带http://或https://" class="signinput" style="margin-bottom: 10px;"></div>
                    <div>
                        网站分类:
                        <div id="parent">
                            <select name="sort" id="sort">
                                @foreach($sort as $value)
                                    <option value="{{ $value->code }}">{{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <button style="width: 150px;line-height: 33px;background-color: #61b3e6;border: none;color: #fff;margin-top: 20px;margin-left: 70px;cursor:pointer;" id="signbtn">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
<script>
    $(function () {
        $("#signbtn").click(function () {
            let name = $("#name").val();
            let url = $("#url").val();
            let sort = $("#sort").val();

            if(name == '' || name.length > 8){
                alertWind('网站名不能为空或大于8位');
                return false;
            };
            if(url == '' || url.length > 50){
                alertWind('网站链接不能为空或大于50位');
                return false;
            };
            if(sort == ''){
                alertWind('请选择分类');
                return false;
            };

            $.ajax({
                method:'post',
                url:"/api/signin",
                dataType:'json',
                data:{url:url,name:name,sort:sort},
                beforeSend:function (jqXHR) {
                    $(".modal").fadeIn(100);
                }
            }).done(function (e) {
                $(".modal").fadeOut(100);
                alertWind(e.message);
            }).fail(function (xhr) {
                $(".modal").fadeOut(100);
                alertWind(jsonForm(xhr.responseJSON));
            });

        });

    });
</script>
@stop