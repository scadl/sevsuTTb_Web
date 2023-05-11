$(document).ready(function () {

    function ajReqData(sendData, respType) {

        $.ajax({
            type: "get",
            url: "./process.php",
            data: sendData,
            success: function (response) {

                let resP = JSON.parse(response);
                console.log(resP);

                switch (respType) {
                    case 1:
                        fillDrop("#weekTT", resP.pages, "wk");
                        $(".wk").removeClass("active");
                        $(".wk").click(function (e) { 
                            e.preventDefault();
                            ajReqData(
                                {'weekN':$(this).html()}, 
                                2
                            );
                            $(this).addClass("active");
                        });
                        break;

                        case 2:

                            fillDrop("#groupTT", resP.groups, "gp");
                            fillDrop("#wekDayTT", resP.weekDays, "wd");

                            $("#groupTTDrop").removeClass("disabled");
                            $(".gp").removeClass("active");

                            $("#wekDayTTDrop").removeClass("disabled");
                            $(".wd").removeClass("active");

                            $(".wd").click(function (e) { 
                                e.preventDefault();
                                ajReqData(
                                    {
                                        'gpN': $(".gp.active").html(),
                                        'gpCol': $(".gp.active").attr("index"),
                                        'weekN': $(".wk.active").html(),
                                        'wkDay': $(this).attr("index")
                                    }, 
                                    3
                                );
                                $(this).addClass("active");
                                //alert($(".wk.active").html())
                            });
                        break
                    default:

                        break;
                }



            }
        });
    }

    function fillDrop(contID, dataArr, bindClass){
        dataArr.forEach((element, ind) => {
            if (element != "") {
                $(contID).html(
                    $(contID).html() + 
                    '<li><a class="dropdown-item '+bindClass+'" index="'+ind+'" href="#">' + element + '</a></li>'
                    );
            }
        });
    }

    ajReqData(null, 1);

});