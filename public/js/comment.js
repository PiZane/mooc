getComment(url, avatar);
getTopComments(str);
function getComment(url) {
    if (isNull(url)) {
        return null;
    }
    $.get(url,null,function (str) {
        $("#comments").fadeOut(300);
        $("#comments").empty();
        var e = JSON.parse(str);
        for (var x in e.data) {
            appendComment(e.data[x], avatar, '#comments')
        }
        if (e.total < 4) {
            return false;
        }
        $('#comments').append('<div id="page" class="col s12 m10 l9" style="margin-top: 1em"></div>');
        pagination(e, '#page', 'getComment', url.split('?')[0]+'?page=');
        $('.tooltipped').tooltip({delay: 30});
        $("#comments").fadeIn(300);
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

function submitComment() {
    $.ajax({
        cache: false,
        type: "post",
        url: $('#commentForm').attr('action'),
        data: $('#commentForm').serialize(),// 你的formid
        async: false,
        error: function(request) {
            Materialize.toast("评论失败, 请刷新页面后重试", 3000);
        },
        success: function(data) {
            Materialize.toast(data, 3000);
            getComment(url, avatar);
        }
    });
}