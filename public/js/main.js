$(document).ready(function(){
    $('.modal').modal();
    $('select').material_select();
    $('.tooltipped').tooltip({delay: 30});
    $(".button-collapse").sideNav({menuWidth: 200});
    $(".dropdown-button").dropdown({belowOrigin: true});
});

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
