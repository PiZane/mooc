function changeSetting(url, token) {
    var name = [];
    $(".name").each(function(){
        name.push($(this).val());
    });
    var link = [];
    $(".link").each(function(){
        link.push($(this).val());
    });
    var len = $('#links').children('input').length / 2;
    var links = {};
    for (var i=0; i<len; i++) {
        var x = name[i];
        var y = link[i];
        if (isNull(x) || isNull(y)) {
            continue;
        }
        links[x]=y;
    }
    var setting = {
        'name'        : $('#name').val(),
        'title'       : $('#title').val(),
        'keywords'    : $('#keywords').val(),
        'description' : $('#description').val(),
        'footer'      : $('#footer').val(),
        'avatar'      : $('#avatar').val(),
        'links'       : links
    };
    var res = JSON.stringify(setting);
    $.post(url,{
        '_token'  : token,
        'setting' : res
    }, function ($e) {
        if ($e == '200') {
            Materialize.toast('站点配置已修改', 3000);
        } else {
            Materialize.toast('站点配置修改失败', 3000, 'red');
        }
    });
}

function addLink() {
    $('#links').append('<input class="name col s3" type="text" placeholder="链接名称">');
    $('#links').append('<input class="link col s8 offset-s1" type="text" placeholder="链接地址">');
}