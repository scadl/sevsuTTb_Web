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
                                { 'weekN': $(this).html() },
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

                        $(".gp").click(function (e) {
                            e.preventDefault();
                            $(this).addClass("active");
                        });

                        $("#wekDayTTDrop").removeClass("disabled");
                        $(".wd").removeClass("active");

                        $(".wd").click(function (e) {
                            e.preventDefault();
                            ajReqData(
                                {
                                    'gpN': $(".gp.active").html(),
                                    'gpColS': $(".gp.active").attr("index"),
                                    'gpColE': $(".gp.active").parent().next().children().attr("index"),
                                    'weekN': $(".wk.active").html(),
                                    'wkDay': $(this).attr("index")
                                },
                                3
                            );
                            // https://api.jquery.com/children/
                            $(this).addClass("active");
                        });


                        break;
                    case 3:
                        let tContent = "";
                        let tHead = "";
                        for (var row in resP.timetable) {
                            tContent += "<tr>";
                            for (var col in resP.timetable[row]) {
                                if (row == 0) {
                                    if(resP.timetable[row][col]!="" && col < 2){
                                        tHead += resP.timetable[row][col] + ", ";
                                    }
                                } else if (row<8) {
                                    if (col > 1 && col < 7){
                                        tContent += "<td>" + resP.timetable[row][col] + "</td>";
                                    }
                                }
                            }
                            tContent += "</tr>";
                        }
                        $("#tBody").html(tContent);
                        $("#tHead").html("<tr><td colspan='10'>" + $(".gp.active").html() + 
                        ", <span class='text-primary'>" + tHead + "</span></td></tr>");
                        break;
                    default:

                        break;
                }

                $("#moDate").text(resP.moDate);
            }
        });
    }

    function fillDrop(contID, dataArr, bindClass) {
        for (var element in dataArr) {
            if (dataArr[element] !== "") {
                $(contID).html(
                    $(contID).html() +
                    '<li><a class="dropdown-item ' + bindClass + '" index="' + element + '" href="#">' + dataArr[element] + '</a></li>'
                );
            }
        };
    }

    $("#tbClear").click(function (e) { 
        e.preventDefault();
        $(".wk").removeClass("active");
        $(".gp").removeClass("active");
        $(".wd").removeClass("active");
        $("#tBody").html("");
        $("#tHead").html("");
        $("#groupTTDrop").addClass("disabled");
        $("#wekDayTTDrop").addClass("disabled");
        $("#weekTT").html("");
        $("#groupTT").html("");
        $("#wekDayTT").html("");
        ajReqData(null, 1);
    });

    ajReqData(null, 1);

});