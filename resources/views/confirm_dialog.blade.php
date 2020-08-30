<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-dialog"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Je wilt iets verwijderen!</h4>
            </div>

            <div class="modal-body">
                <p></p>
                <p>Weet je het zeker? Deze oprdacht kun je niet ongedaan maken!</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <form class="delete-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Nee liever niet</button>
                    <button type="submit" class="btn btn-danger btn-confirm">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
</div>
