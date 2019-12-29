<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-dialog"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Zou je dat nou wel doen?</h4>
            </div>

            <div class="modal-body">
                <p>You are about to delete one track, this procedure is irreversible.</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <form class="delete-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Nee liever niet</button>
                    <button type="submit" class="btn btn-outline-danger btn-confirm">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
</div>
