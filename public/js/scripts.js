$(document).ready(function () {

    $("#menu").click(function(){
        $(".sidebar").toggleClass("show-sidebar");
    });

    //Add and remove rekeningnummer input field
    $("form").on("click","#add_rekeningnummer",function () {
        $("#rekeningnummers").append(`
        <div id="extra_rekeningnummer">
            <label for=\"rekeningnummer\">Extra Rekeningnummer</label>
            <button type="button" class="btn btn-link" id="remove_rekeningnummer">verwijder</button>
            <input type=\"text\" class=\"form-control mb-3\" id=\"rekeningnummer\" name=\"rekeningnummers[]\">
        </div>` );
    });

    $("form").on("click","#remove_rekeningnummer",function(){
        $(this).closest('div').remove();
    });

    //Add and remove uitgaven/inkomsten list
    var i = 0;
    $("form").on("click","#add_inkomsten",function () {
        $("#inkomsten").after(`<tr>
            <input type="hidden" name="inkomsten[`+i+`][id]" value="">
            <td><input type=\"text\" class="form-control" id="soort" name="inkomsten[`+i+`][soort]" value="" placeholder="soort"></td>
            <td>
            <div class="input-group mb-3">
            <div class="input-group-prepend">
            <div class="input-group-text">&euro;</div>
        </div>
        <input type="number" class="form-control" id="budget" name="inkomsten[`+i+`][bedrag]" step=".01" value="" min="0" max="99999999" placeholder="bedrag">
            <button id="remove_rij" class="btn btn-link" type="button">X</button>

            </div>
            </td>
            </tr>` );
        i++;
    });

    var j = 0;
    $("form").on("click","#add_uitgave",function () {
    $("#uitgaven").before(`<tr>
            <input type="hidden" name="uitgaven[`+j+`][id]" value="">
            <td><input type="text" class="form-control" id="soort" name="uitgaven[`+j+`][soort]" value="" placeholder="soort"></td>
            <td>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="budget" name="uitgaven[`+j+`][budget]" step=".01" value="" min="0" max="99999999" placeholder="budget">
                </div>
            </td>
            <td></td>
            <td><button id="remove_rij" class="btn btn-link" type="button">X</button></td>
        </tr>` );
    j++;
    });

    $("form").on("click","#remove_rij",function(e){
        $(this).closest('tr').remove();
    });

});
