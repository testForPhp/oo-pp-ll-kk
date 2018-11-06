@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">购买激活码</div>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">选择</th>
                                <th scope="col">金额</th>
                                <th scope="col">备注</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($point as $item)
                            <tr>
                                <th scope="row">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="linkcode" id="inlineRadio1" value="{{ $item->link }}">
                                        <label class="form-check-label" for="inlineRadio1">{{ $item->point }}点</label>
                                    </div>
                                </th>
                                <td>{{ $item->point }}元</td>
                                <td>{{ $item->summary }}</td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="http://www.moneybysleep.me/pay/jump.html?url={{ $point[0]->link }}" target="_blank" class="btn btn-primary btn-block">购买</a>
                    </div>
                </div>
                <dic class="card mt-3">
                    <div class="card-header">
                        激活激活码
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="code" placeholder="请输入激活码" aria-label="请输入激活码" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary put-code-active" type="button">激活</button>
                            </div>
                        </div>
                    </div>
                </dic>
                <div class="card mt-3">
                    <div class="card-header">
                        充值流程
                    </div>
                    <div class="card-body">
                        <p>1、在"购买激活码"选择需要储值的金额，点击"购买"按钮前往支付，支付成功后会得到一个激活码！</p>
                        <p>2、将第一步得到的激活填写至"激活激活码",点击"激活"按钮就完成充值了！</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    let jumpUrl = 'http://www.moneybysleep.me/pay/jump.html?url=';
    $("input[name='linkcode']").change(function () {
        let url = $(this).val();
        if(url == ''){
            textInfoMsg('請選擇！','error');
            return false;
        }
        $(".btn-block").attr('href',jumpUrl + url);
    });
    $(".put-code-active").click(function () {
        let code = $('#code').val();
        if(code == ''){
            textInfoMsg('激活码不能为空','error');
            return false;
        }
        $.post('/member/recharge',{code:code}).done(function (e) {
            textCallbackMsg(e.message,'/member/home','success');
        }).fail(function (xhr) {
            swalHtml(jsonErrorForm(xhr.responseJSON),'error');
        });
    });
</script>
@stop