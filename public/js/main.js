$(document).ready(function() {
    $('.modal').modal();
    $('select').material_select();
    $('.collapsible').collapsible();
    $('.tooltipped').tooltip({delay: 30});
    $(".button-collapse").sideNav({menuWidth: 200});
    $(".dropdown-button").dropdown({belowOrigin: true});
});

$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $("#toTop").fadeIn();
        } else {
            $("#toTop").fadeOut();
        }
    });
    $("body").append('<div id=\"toTop\" class="red lighten-2 white-text" style=\"text-align:center;padding:10px 13px 7px 13px;position:fixed;bottom:30px;right:30px;cursor:pointer;display:none;font-family:verdana;font-size:22px;\">^</div>');
    $("#toTop").click(function () {
        $("body,html").animate({scrollTop: 0}, 800);
    });
})

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

function pagination(e, el, functionName, url) {
    if (e.last_page > 1) {
        if (e.current_page == 1) {
            var prevPage = '<li class="disabled"><a href="#"><i class="material-icons">chevron_left</i></a></li>';
        } else {
            var prevPage = '<li><a class="waves-effect" rel="prev" onclick="'+functionName+'(\''+ e.prev_page_url +'\')"><i class="material-icons">chevron_left</i></a></li>';
        }
        if (e.current_page == e.last_page) {
            var nextPage = '<li class="disabled"><a href="#"><i class="material-icons">chevron_right</i></a></li>';
        } else {
            var nextPage = '<li><a class="waves-effect" rel="next" onclick="'+functionName+'(\''+ e.next_page_url +'\')"><i class="material-icons">chevron_right</i></a></li>';
        }
        var i = 1;
        var max = 5;
        if ((e.current_page - 2) > 0) {
            i = e.current_page - 2;
            if ((e.current_page + 2) > e.last_page) {
                var max = e.last_page;
                if (max - 4 < 1) {
                    i = 1
                } else {
                    i = max - 4;
                }
            } else {
                max = e.current_page + 2;
            }
        } else {
            if (e.last_page < 5) {
                max = e.last_page;
            } else {
                max = 5;
            }
        }
        var li = '';
        for(; i<=max; i++) {
            if (e.current_page == i) {
                li = li + '<li class="active waves-effect"><a href="#">'+ i +'</a></li>';
            } else {
                li = li + '<li class="waves-effect" onclick="'+functionName+'(\''+ url + i + '\')"><a >'+i+'</a></li>';
            }
        }
        $(el).append('<ul class="pagination center">'+prevPage+li+nextPage+'</ul>');
    }
}
