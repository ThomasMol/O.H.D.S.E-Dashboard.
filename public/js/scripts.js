$(document).ready(function () {

    $("#menu").click(function(){
        $(".sidebar").toggleClass("show-sidebar");
    });

    //Add and remove rekeningnummer input field
    var i = 2;
    $("form").on("click","#add_rekeningnummer",function () {
        $("#rekeningnummers").append('<div id="extra_rekeningnummer" data-id="'+i+'"><label for=\"rekeningnummer\">Extra Rekeningnummer</label><button data-button="'+i+'" type="button" class="btn btn-link" id="remove_rekeningnummer">verwijder</button>\n<input type=\"text\" class=\"form-control mb-3\" id=\"rekeningnummer\" name=\"rekeningnummers[]\"></div>' );
        i++;
    });

    $("form").on("click","#remove_rekeningnummer",function(){
        $("#extra_rekeningnummer[data-id='"+$(this).data("button")+"']").remove();
    });


});
