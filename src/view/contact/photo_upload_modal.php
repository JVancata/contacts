<div class="modal" tabindex="-1" id="photoUploadModal">
    <div class="modal-dialog">
        <form method="POST" action="/photo/upload" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Nahrát fotku ke kontaktu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Fotka</label>
                        <input class="form-control" type="file" id="formFile" name="photoFile">
                    </div>

                    <input type="hidden" value="<?php echo $contact["id"] ?>" name="contactId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                <button type="submit" class="btn btn-success" value="Přidat kontakt">Nahrát fotku</button>
            </div>
        </form>
    </div>
</div>