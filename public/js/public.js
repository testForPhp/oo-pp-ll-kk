var token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}
$(document).ajaxStart(function () {
    $(".loadmodal").fadeIn(100);
});
$(document).ajaxStop(function () {
    $(".loadmodal").fadeOut(100);
});

function swalHtml(data,info = 'info') {
    swal({
        title: '',
        type: info,
        html: data,
        showCloseButton: true,
        showCancelButton: false,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> 知道了！',
        cancelButtonText: ''
    });
};
function textInfoMsg(text,type = 'success') {
    swal(
        '',
        text,
        type
    );
};

function rechargeCallbackMsg(text,callback  = 'reload',type = 'warning') {
    swal({
        title: '',
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '前往充值',
    }).then(function(dismiss){
        if(dismiss.dismiss != 'cancel'){
            window.location.href = callback;
        }
    })
}

function textCallbackMsg(text,callback  = 'reload',type = 'warning') {
    swal({
        title: '',
        text: text,
        type: type,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定！',
    }).then(function(){
        if(callback == 'reload'){
           window.location.reload();
        }else{
            window.location.href = callback;
        }
    })
}
function checkLinkForm(data)
{
    let errors = '';
    if(data.title == '' || data.title.length > 8){
        errors += '<p>网站名称不能为空且不能大于8位字符</p>';
    }
    if(data.sort == ''){
        errors += '<p>请选择分类</p>';
    }
    if(checkUrl(data.link) == false){
        errors += '<p>请填写正确的链接</p>';
    }

    if(errors){
        return errors;
    }
    return false;
};
function checkUrl(url){
    var reg='^(http|https)\\://([a-zA-Z0-9\\.\\-]+(\\:[a-zA-Z0-9\\.&%\\$\\-]+)*@)?((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\\-]+\\.)*[a-zA-Z0-9\\-]+\\.[a-zA-Z]{2,4})(\\:[0-9]+)?(/[^/][a-zA-Z0-9\\.\\,\\?\\\'\\\\/\\+&%\\$#\\=~_\\-@]*)*$';
    var objExp=new RegExp(reg);
    if(objExp.test(url)){
        return true
    }else{
        return false
    }
}
function jsonErrorForm(msg) {
    let errors = '';
    if(msg.errors){
        $.each(msg.errors,function (index,item) {
            errors += "<p>" + item[0] + "</p>"
        })
    }else{
        errors = msg.message;
    };
    return errors;
};