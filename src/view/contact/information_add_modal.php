<div class="modal" tabindex="-1" id="informationAddModal">
    <div class="modal-dialog">
        <form method="POST" action="/information/add" class="modal-content" id="groupForm">
            <div class="modal-header">
                <h5 class="modal-title">Přidat informaci</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <select class="form-select" aria-label="Default select example" required name="informationTypeId" id="informationAddSelect">
                        <?php
                        foreach ($informationTypes as $informationType) {
                            echo '<option value="' . $informationType["id"] . '">' . $informationType["name"] . '</option>';
                        }
                        ?>
                    </select>
                    <label for="groupNameInput" class="col-sm-6 col-form-label">Hodnota</label>
                    <input id="groupNameInput" type="text" name="value" class="form-control" placeholder="Hodnota" required>
                    <input type="hidden" name="contactId" value="<?php echo $contact["id"]; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                <button type="submit" class="btn btn-success" value="Přidat kontakt">Přidat informaci</button>
            </div>
        </form>
    </div>
</div>