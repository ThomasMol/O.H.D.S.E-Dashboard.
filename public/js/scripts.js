$(document).ready(function () {

    //Mobile navigatino menu toggler
    $("#menu").click(function(){
        $(".sidebar").toggleClass("show-sidebar");
    });

    //update naheffing value
    $('form').on("change paste keyup click blur focus submit",function(){
        var budget  = Number($('#budget').val());
        var uitgave = Number($('#uitgave').val());
        $('#naheffing').val((uitgave - budget).toFixed(2));
    });

    //Add and remove rekeningnummer input field
    $("form").on("click","#add_rekeningnummer",function () {
        $("#rekeningnummers").append(`
        <div id="extra_rekeningnummer">
            <label for=\"rekeningnummer\">Extra Rekeningnummer</label>
            <button type="button" class="btn btn-link" id="remove_rekeningnummer">verwijder</button>
            <input type=\"text\" class=\"form-control mb-3\" id=\"rekeningnummer\" name=\"rekeningnummers[]\" required>
        </div>` );
    });
    //remove rekeningnummer input field
    $("form").on("click","#remove_rekeningnummer",function(){
        $(this).closest('div').remove();
    });

    //Add and remove uitgaven/inkomsten list
    var i = -1;
    $("form").on("click","#add_inkomsten",function () {
        $("#inkomsten").before(`
        <tr>
            <input type="hidden" name="inkomsten[`+ i + `][id]" value="">
            <td><input type=\"text\" class="form-control" id="soort" name="inkomsten[`+ i + `][soort]" value="" placeholder="soort" required></td>
            <td>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="budget" name="inkomsten[`+ i +`][budget]" step=".01" value="" min="0" max="99999999" placeholder="budget" required>
                </div>

            </td>
            <td></td>
            <td><button id="remove_rij" class="btn btn-outline-secondary" type="button">X</button></td>
        </tr>` );
        i--;
    });

    var j = -1;
    $("form").on("click","#add_uitgave",function () {
    $("#uitgaven").before(`
    <tr>
        <input type="hidden" name="uitgaven[`+j+`][id]" value="">
        <td><input type="text" class="form-control" id="soort" name="uitgaven[`+j+`][soort]" value="" placeholder="soort" required></td>
        <td>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">&euro;</div>
                </div>
                <input type="number" class="form-control" id="budget" name="uitgaven[`+j+`][budget]" step=".01" value="" min="0" max="99999999" placeholder="budget" required>
            </div>
        </td>
        <td></td>
        <td><button id="remove_rij" class="btn btn-outline-secondary" type="button">X</button></td>
        </tr>` );
    j--;
    });

    //remove rij from inkomsten/uitgaven list
    $("form").on("click","#remove_rij",function(e){
        $(this).closest('tr').remove();
    });

    //confirm modal for deleting
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.delete-form').attr('action', $(e.relatedTarget).data('href'));
    });

    // Select all leden
    $('.select-all').on("change",function(e){
        var lid_type = $(this).data('select-lid-type');
        $('*[data-lid-type='+ lid_type +']').prop("checked",$(this).prop("checked"));
    });

    // Enable bootstrap tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

});
