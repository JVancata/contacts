<div class="modal" tabindex="-1" id="groupAssignModal">
    <div class="modal-dialog">
        <form method="POST" action="/group/assign" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Přidat skupinu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <?php
                    if ($error) {
                        require 'form_error.php';
                    }
                    if ($message) {
                        require 'form_message.php';
                    }
                    ?>
                    <select class="form-select" aria-label="Default select example" required name="groupId">
                        <option selected>Vyber skupinu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <input type="hidden" name="contactId" value="<?php echo $contact["id"]; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                <button type="submit" class="btn btn-success" value="Přidat kontakt">Přidat skupinu</button>
            </div>
        </form>
    </div>
</div>