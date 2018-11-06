$(".btn-ad-edit-show").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择广告','error');
        return false;
    }
    $.get('/member/ad/' + id).done(function (e) {
        $("#staticImg").val(e.data.thumb);
        $("#inputLink").val(e.data.url);
        $(".put-ad-sub").attr('data-id',e.data.id);
        $("#exampleModal").modal('show');
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });
});
$(".put-ad-renew").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择广告','error');
        return false;
    }
    $.ajax({
        method:'put',
        url:'/member/ad/renew',
        data:{id:id},
        dataType:'json'
    }).done(function (e) {
        if(e.code == 2){
            rechargeCallbackMsg(e.message,'/member/recharge','info');
        }else{
            textCallbackMsg(e.message,'reload','success');
        }
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });
});
$(".btn-show-ad").click(function () {
    $("#imgForm")[0].reset();
    $("#exampleModal").modal('show');
});
$(".put-ad-sub").click(function () {
    let img = $("#staticImg").val();
    let link = $("#inputLink").val();
    let id = $(this).data('id');

    if(img == '' || link == ''){
        textInfoMsg('图片、链接不能为空');
        return false;
    }

    $.post('/member/ad',{img:img,link:link,id:id}).done(function (e) {
        if(e.code == 2){
            rechargeCallbackMsg(e.message,'/member/recharge','info');
        }else{
            textCallbackMsg(e.message,'reload','success');
        }
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });


});
$(".put-ad-delete").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择广告','error');
        return false;
    }

    swal({
        title: '确定删除吗？',
        text: '你将无法恢复它！',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定删除！',
        cancelButtonText: '取消删除！',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function(dismiss) {
        if(dismiss.dismiss == 'cancel'){
            swal(
                '已取消！',
                '',
                'error'
            );
            return
        }
        $.ajax({
            method: 'delete',
            url:'/member/ad/' + id,
            dataType: 'json',
        }).done(function (e) {
            textCallbackMsg(e.message,'reload','success');
        }).fail(function (xhr) {
            swalHtml(jsonErrorForm(xhr.responseJSON),'error');
        });
    });

});
$(".add-link-show").click(function () {
    $("#recommend-hide").hide();
    $("#exampleFormSort").show();
    $("#addlink")[0].reset();
    $(".put-form").attr('data-id','');
    $("#exampleModal").modal('show');
});
$(".put-form").click(function () {
    let sort = $("#exampleFormSort").val();
    let title = $("#exampleFormTitle").val();
    let link = $("#exampleFormLink").val();
    let link_id = $(this).data('id');

    let data = {sort:sort,title:title,link:link};

    isForm = checkLinkForm(data);
    if(isForm != false){
        swalHtml(isForm);
        return false;
    }
    if(link_id == ''){
        $.post('/member/link',data).done(function (e) {
            textCallbackMsg(e.message,'reload','success');
        }).fail(function (xhr) {
            swalHtml(jsonErrorForm(xhr.responseJSON),'error');
        });
    }else{
        data.id = link_id;
        $.ajax({
            method:"put",
            data:data,
            dataType:"json",
            url:"/member/link"
        }).done(function (e) {
            textCallbackMsg(e.message,'reload','success');
        }).fail(function (xhr) {
            swalHtml(jsonErrorForm(xhr.responseJSON),'error');
        });
    }
});
$(".get-link-edit").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择链接','error');
        return false;
    }
    $.get('/member/link/' + id).done(function (e) {
        $("#exampleFormTitle").val(e.data.title);
        $("#exampleFormLink").val(e.data.link);
        $(".put-form").attr('data-id',e.data.id);
        //$("#exampleFormSort").attr('value',e.data.sort);
        if(e.data.recommend == true){
            $('#exampleFormSort').hide().attr('value',0);
            $("#recommend-hide").show().text(e.data.sort);
        }else{
            $("#recommend-hide").hide();
            $("#exampleFormSort").find("option:contains('"+e.data.sort+"')").attr("selected",true);
            $('#exampleFormSort').show();
        }

        $("#exampleModal").modal('show');
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });
});
$(".delete-link").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择链接','error');
        return false;
    }
    swal({
        title: '确定删除吗？',
        text: '你将无法恢复它！',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定删除！',
        cancelButtonText: '取消删除！',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function(dismiss) {
        if(dismiss.dismiss == 'cancel'){
            swal(
                '已取消！',
                '',
                'error'
            );
            return
        }
        $.ajax({
            method: 'delete',
            url:'/member/link/' + id,
            dataType: 'json'
        }).done(function (e) {
            textCallbackMsg(e.message,'reload','success');
        }).fail(function (xhr) {
            swalHtml(jsonErrorForm(xhr.responseJSON),'error');
        });
    });

});
$(".put-rank-sigin").click(function () {
    let id= $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择网站','error');
        return false;
    }
    $.ajax({
        method:'put',
        url:'/member/link/rank',
        data:{id:id},
        dataType:'json'
    }).done(function (e) {
        if(e.code == 2){
            rechargeCallbackMsg(e.message,'/member/recharge','info');
        }else{
            textCallbackMsg(e.message,'reload','success');
        }
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });
});
$(".put-recommend").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择网站','error');
        return false;
    }
    $.ajax({
        method:'put',
        url:'/member/link/recommend',
        data:{id:id},
        dataType:'json'
    }).done(function (e) {
        if(e.code == 2){
            rechargeCallbackMsg(e.message,'/member/recharge','info');
        }else{
            textCallbackMsg(e.message,'reload','success');
        }
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });
});
$(".put-link-color-show").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择网站','error');
        return false;
    }
    $.get('/member/link/' + id).done(function (e) {
        $(".put-link-color").attr('data-id',e.data.id);
        $("#exampleFormColor").val(e.data.color);
        $("#colorModel").modal('show');
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });

});
$(".put-link-color").click(function () {
    let id = $(this).data('id');
    let code = $("#exampleFormColor").val();

    if(id == ''){
        textInfoMsg('请选择网站','error');
        return false;
    }
    if(code == ''){
        textInfoMsg('请选择颜色','error');
        return false;
    }

    $.ajax({
        method:'put',
        url:'/member/link/color',
        data:{id:id,code:code},
        dataType:'json'
    }).done(function (e) {
        if(e.code == 2){
            rechargeCallbackMsg(e.message,'/member/recharge','info');
        }else{
            textCallbackMsg(e.message,'reload','success');
        }
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });
});
$(".put-link-color-renew").click(function () {
    let id = $(this).data('id');
    if(id == ''){
        textInfoMsg('请选择网站','error');
        return false;
    }
    $.ajax({
        method:'put',
        url:'/member/link/color/renew',
        data:{id:id},
        dataType:'json'
    }).done(function (e) {
        if(e.code == 2){
            rechargeCallbackMsg(e.message,'/member/recharge','info');
        }else{
            textCallbackMsg(e.message,'reload','success');
        }
    }).fail(function (xhr) {
        swalHtml(jsonErrorForm(xhr.responseJSON),'error');
    });
});