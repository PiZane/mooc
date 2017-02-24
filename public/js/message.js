getMessages(receivedMessagesUrl);
getMessages(sentMessagesUrl);
function getMessages(url) {
    if (isNull(url)) {
        return null;
    }
    if (url.indexOf('getReceivedMessages') > 0) {
        var divId = 'receivedMessagesDiv';
        var ulId  = 'receivedMessagesList';
        var messageType = 1;
    } else {
        divId = 'sentMessagesDiv';
        ulId  = 'sentMessagesList';
        messageType = 0;
    }
    if (url.indexOf('admin') > 0) {
        var proType = 1;
    } else {
        proType = 0;
    }
    $.get(url,null,function (str) {
        var div = $('#'+divId);
        div.fadeOut(300);
        div.empty();
        div.append('<ul id="'+ulId+'" class="collapsible" style="box-shadow: none" data-collapsible="accordion"></ul>');
        var e = JSON.parse(str);
        console.log(e);
        for (var x in e.data) {
            appendMessages(e.data[x], '#'+ulId, proType, messageType);
        }
        div.append('<div id="'+divId+'page" class="col s12" style="margin-top: 1em"></div>');
        pagination(e, '#'+divId+'page', 'getMessages', url.split('?')[0]+'?page=');
        div.fadeIn(300);
        $('.collapsible').collapsible();
    });
}

function appendMessages(data, el, proType, messageType) {
    var pro  = '';
    var text = '';
    var deleteHtml = '';
    var userName = '未知';
    if (proType) {
        pro = ' 同学';
    } else {
        pro = ' 教师';
    }
    if (messageType) {
        text = '来自: ';
        userName = data.senderName;
        deleteHtml = '<div class="right-align"><span class="btn red lighten-3" onclick="deleteMessage(\''+data.id+'\')">删除</span></div>'
    } else {
        text = '发送给: ';
        userName = data.receiverName;
    }
    $(el).append('<li><div class="collapsible-header"><i class="material-icons">email</i>'+text+userName
        +pro+'<span class="right">'
        +data.time
        +'</span></div><div class="collapsible-body" style="padding: 2em;"><span>'
        +data.content+'</span>'+deleteHtml+'</div></li>');
}

function deleteMessage(id) {
    var url = deleteUrl.split('/deleteId')[0] + id;
    if(confirm("确认要删除？")){
        $.post(url,{
                '_token' : token
            }, function (e) {
                getMessages(receivedMessagesUrl);
                Materialize.toast(e, 3000);
            }
        );
    }
}