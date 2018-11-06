let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}
$( document ).ajaxStart(function() {
    $( ".loadmodal" ).fadeIn(100);
});
$( document ).ajaxStop(function() {
    $( ".loadmodal" ).fadeOut(100);
});

function swalHtml(data,info = 'info') {
    swal({
        title: '',
        type: info,
        html:data,
        showCloseButton: true,
        showCancelButton: false,
        confirmButtonText:
            '<i class="fa fa-thumbs-up"></i> 知道了！',
        cancelButtonText:
            ''
    })
}