function getLastTitle(url){
    var curr_url = url;
    var curr_title = curr_url.substring(curr_url.lastIndexOf("/") + 1); // in this case "...wecan/index.php/competitor" curr_title will contain "competitor"
    return curr_title;
}

$(document).ready(function () {
    $('#slideleft').click(function () {
        var menu = $("div.sidenav");
        var main = $("div#main");
        menu.css("width", parseInt(menu.css('width')) == 0 ? "250px" : "0px");
        main.css("margin-left", parseInt(main.css('margin-left')) == 0 ? "250px" : "0px");
    });

    $('ul#nav li a').click(function () {
        var li = $(this).parent();
        var nextelement = $(li).next();
        if (nextelement.prop("tagName") == "UL") {
            //nextelement.css("display", nextelement.css('display') == 'none' ? "inline-block" : "none");
            if (nextelement.css('display')=="none") {
                nextelement.fadeIn(800);
            }
            else
                nextelement.fadeOut(500);
        }
    });

    //** BLOCK - checking which is the current url in order to set the correct selected title in the menu

    var curr_title = getLastTitle(window.location.href);
    if (curr_title == "")
        curr_title = "index.php";
    var _break = 0;

    //window.location.href.substring(window.location.href.lastIndexOf("/")+1);
    var all_uls = $("ul"); // all the available ULs
    for (var j = 0; j < all_uls.length; j++) {
        var lis = $(all_uls[j]).children("li"); // all the available LIs
        for(var i=0; i<lis.length;i++)
        {
            //$($(all_uls[0]).children("li")[0]).find("a")
            var currA = $($(lis[i])).find("a")
            if (getLastTitle(currA.attr("href")) == curr_title) {
                $(lis[i]).attr("class", "selected");
                if (j > 0) { //sub-menu ul
                    $(all_uls[j]).attr("class", "subM_opened");
                }
                _break = 1;
            }
        }
        if (_break != 0)
            break;
    }

    //**

    $(function () {
        $("#date").datepicker({ dateFormat: "dd/mm/yy" }).val();
    });

});

//** Ajax call for the "Attempt Entry" page

function show_ae_status_msg(msg, color) {
    $("div.ae_status").html("<p class='entry'><b>" + msg + "</b></p>");
    $("div.ae_status").css("top", "0");
    $("div.ae_status").css('background-color', color);
    setTimeout(function () {
        $("div.ae_status").css('background-color', 'white');
        $("div.ae_status").html(" ");
    }, 4000);
}

// set titles to pages
function ajax_call() {
	$("#check_auth").prop("disabled", true);
    //$("#check_auth").attr('disabled','disabled') //disable the bottom that submits the form
    $("div.ae_status").css("top", "50px");  // set div.ae_status css top property to 50px - this will cause a position absolute div to shrink down
    var payload = [$("input[name='idcard']").val(), $("select[name='venue']").val(), $("input[name='date']").val()] // setting up an array that holds the values sent by the form through the post method
    $.post("/wecan/index.php/main/entry_query1", { idcard: payload[0], venue: payload[1], date: payload[2] }) // submit the form through ajax
    .done(function (data) { //if everything's successful do what follows
        $.get("/wecan/assets/php_scripts/attempt_entry.php", { idcard: payload[0], venue: payload[1], date: payload[2] })
        .done(function (data) {
            //alert(data);
            var color = "green";
            if (data.indexOf("denied") !== -1)
                color = "red";
            else if(data.length>20){ //any php error message will be larger than the length of "access denied!"
                data = "Php error!";
                color = "red";
            }
            show_ae_status_msg(data, color);
        });
    })
    .fail(function () {
        show_ae_status_msg("Database unreachable!", "red");
    })
    .always(function () {
        //$("#check_auth").prop("disabled", false); // enable the bottom that submits the form
		//$("#check_auth").removeAttr('disabled','disabled')
        setTimeout(function () {
            $("#check_auth").prop("disabled", false);
        }, 4000);
		
    });
}
