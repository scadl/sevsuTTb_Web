$(document).ready(function () {
    $.ajax({
        type: "get",
        url: "./process.php",
        data: {},
        success: function (response) {
            let resP = JSON.parse(response);
            resP.forEach(element => {
                if(element != ""){
                    $("#weekTT").html( $("#weekTT").html()+'<li><a class="dropdown-item" href="#">'+element+'</a></li>' );
                }
            });
            console.log(resP);
        }
    });
});