<div class="modal" tabindex="-1" id="noteEditModal">
    <div class="modal-dialog">
        <form method="POST" action="/note/edit" class="modal-content" id="noteEditForm">
            <div class="modal-header">
                <h5 class="modal-title">Upravit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <div class="form-floating">
                        <textarea class="form-control" name="note" placeholder="Upravená poznámka" id="noteEditTextarea"></textarea>
                        <label for="noteEditTextarea">Upravná poznámka</label>
                    </div>
                    <input type="hidden" name="contactId" value="<?php echo $contact["id"]; ?>">
                    <input type="hidden" name="noteId" id="noteEditNoteIdInput" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                <button type="submit" class="btn btn-success" value="Přidat kontakt">Upravit poznámku</button>
            </div>
        </form>
    </div>
</div>