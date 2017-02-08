$(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
    $(".button-collapse").sideNav();
    $('.modal').modal();
});

$('#avatarFile').change(function(){
    var file=this.files[0];
    var reader=new FileReader();
    reader.onload=function(){
        // 通过 reader.result 来访问生成的 DataURL
        var url=reader.result;
        $('#avatar').attr('src', url);
        $('#avatar').cropper('replace', url);
    };
    reader.readAsDataURL(file);
});

var avatar = $('#avatar').cropper({
    responsive: false,
    aspectRatio: 1 / 1
});

function uploadAvatar(url, token) {
    var img = avatar.cropper("getCropBoxData");
    if (img.width < 120 || img.height <120) {
        Materialize.toast('裁剪区域不得小于120px*120px', 3000);
        return false;
    }
    var dataURL = avatar.cropper("getCroppedCanvas");
    var imgUrl  = dataURL.toDataURL("image/png", 1.0);

    $.post(url,{
            '_token' : token,
            'avatar' : imgUrl.substr(imgUrl.indexOf(',') + 1)
        }
    );
}

function deleteAlert(url, token) {
    if(confirm("确认要删除？")){
        $.post(url,{
                '_token' : token
            }
        );
        var url = window.location.href;
        url = url.substring(0,url.lastIndexOf('/'));
        window.location.href = url;
        window.close();
    }
}
function clickTab(url) {
    window.location.href = url;
}
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
function isNull(data){
    return (data == "" || data == undefined || data == null || data == 'null');
}

function joinCourse(url, token) {
    $.post(url, {
            '_token' : token
        }, function ($e) {
        Materialize.toast($e, 3000);
    });
}

function getComment(url, avatar) {
    if (isNull(url)) {
        return null;
    }
    $("#comments").empty();
    $.get(url,null,function (str) {
        var e = JSON.parse(str);
        for (var x in e.data) {
            appendComment(e.data[x], avatar, '#comments')
        }
        if (e.total < 4) {
            return false;
        }
        $('#comments').append('<div id="page" class="col s12 m10 l9" style="margin-top: 1em"></div>');
        if (e.prev_page_url) {
            $('#page').append('<button class="left btn blue lighten-2" onclick="getComment('+"\'"+e.prev_page_url+"\',\'"+avatar+"\'"+')">上一页</button>');
        } else {
            $('#page').append('<button class="left btn disabled">上一页</button>');
        }
        if (e.next_page_url) {
            $('#page').append('<button class="right btn blue lighten-2" onclick="getComment('+"\'"+e.next_page_url+"\',\'"+avatar+"\'"+')">下一页</button>');
        } else {
            $('#page').append('<button class="right btn disabled">下一页</button>');
        }
    });
}

function getTopComments(str) {
    var e = JSON.parse(str);
    for (var x in e) {
        appendComment(e[x], avatar, '#topComments')
    }
}

function appendComment(c, avatar, bind) {
    var image_url = c.image_url || avatar;
    if (isNull(c.schoolId)){
        var pro = '教师';
        var color = 'blue-text';
    } else {
        var pro = '学号: '+c.schoolId;
        var color = 'teal-text';
    }
    $(bind).append(
        '<div class="col s12 m10 l9">'+
        '<img class="col s1 hide-on-med-and-down tooltipped" style="padding-top: 1em;" data-position="right" data-delay="50" data-tooltip="'+pro+'" src="'+image_url+'">'+
        '<div class="col s11"><p class="title"><span class="'+color+'">'+c.name+' '+'</span> '+c.time+'</p>'+
        '<p class="black-text">'+ c.content+'</p>'+
        '<p><a href="#commentContent" onclick="reply('+c.id+",\'"+c.name+"\'"+')">回复</a></p></div></div>'+
        getReply(c.reply, avatar)
    );
}

function getReply(c, avatar) {
    if (!isNull(c)) {
        var image_url = c.image_url || avatar;
        if (isNull(c.schoolId)){
            var pro = '教师';
            var color = 'blue-text';
        } else {
            var pro = '学号: '+c.schoolId;
            var color = 'teal-text';
        }
        return '<div class="col s10 offset-s2 m9 offset-m1 l8 offset-l1 my-comment-margin my-comment grey lighten-4">'+
            '<img class="col s1 hide-on-med-and-down tooltipped" style="padding-top: 1em;" data-position="right" data-delay="50" data-tooltip="'+pro+'" src="'+image_url+'">'+
            '<div class="col s11"><p class="title"><span class="'+color+'">'+c.name+' '+'</span> '+c.time+'</p>'+
            '<p class="black-text">'+ c.content+'</p>'+
            '<p><a href="#commentContent" onclick="reply('+c.id+",\'"+c.name+"\'"+')">回复</a></p></div></div>'+
            getReply(c.reply, avatar);
    }
    return '';
}

function reply(id, name) {
    $('#replyId').val(id);
    $('#reply').val(name);
    $('#lessonMenu').tabs('select_tab', 'commentsTab');
}

function clearReply(name) {
    $('#replyId').val('');
    $('#reply').val(name);
}
