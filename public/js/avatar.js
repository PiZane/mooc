var flag = 0;
$('#avatarFile').change(function(){
    var file=this.files[0];
    var reader=new FileReader();
    reader.onload=function(){
        // 通过 reader.result 来访问生成的 DataURL
        var url=reader.result;
        $('#avatar').attr('src', url);
        window.avatar = $('#avatar').cropper({
            aspectRatio : 1 / 1
        });
        $('#avatar').cropper('replace', url);
    };
    reader.readAsDataURL(file);
    flag = 1;
});

function uploadAvatar(url, token) {
    if (!flag) {
        Materialize.toast('您未上传新头像', 3000);
        return false;
    }
    var dataURL = window.avatar.cropper("getCroppedCanvas");
    var imgUrl  = dataURL.toDataURL("image/png", 1.0);
    var form = new FormData();
    form.append('_token', token);
    form.append('avatar', convertBase64UrlToBlob(imgUrl));
    $.ajax({
        url : url,
        type : 'post',
        data : form,
        cache : false,
        processData : false,
        contentType : false,
        success : function (e) {
            Materialize.toast(e, 3000);
            location.reload();
        }
    });
}

function convertBase64UrlToBlob(urlData) {
    //去掉url的头，并转换为byte
    var bytes=window.atob(urlData.split(',')[1]);
    //处理异常,将ascii码小于0的转换为大于0
    var ab = new ArrayBuffer(bytes.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < bytes.length; i++) {
        ia[i] = bytes.charCodeAt(i);
    }
    return new Blob( [ab] , {type : 'image/png'});
}