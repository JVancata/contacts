<div class="modal" tabindex="-1" id="contactEditModal">
    <div class="modal-dialog">
        <form method="POST" action="/contact/edit" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upravit kontakt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <div class="my-3 row">
                        <label for="inputFirstName" class="col-sm-6 col-form-label">Křestní jméno</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputFirstName" placeholder="Křestní jméno" name="first_name" value="<?php echo $contact["first_name"] ?? ""; ?>">
                        </div>
                    </div>
                    <div class="my-3 row">
                        <label for="inputLastName" class="col-sm-6 col-form-label">Příjmení</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputLastName" placeholder="Příjmení" name="last_name" value="<?php echo $contact["last_name"] ?? ""; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputNickname" class="col-sm-6 col-form-label">Přezdívka</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputNickname" placeholder="Přezdívka" name="nickname" value="<?php echo $contact["nickname"] ?? ""; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputNickname" class="col-sm-6 col-form-label">Datum narození</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="inputBirthdate" placeholder="Datum narození" name="birth_date" value="<?php echo $contact["birth_date"] ?? ""; ?>">
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $contact["id"] ?>" name="contactId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                <button type="submit" class="btn btn-success" value="Přidat kontakt">Upravit kontakt</button>
            </div>
        </form>
    </div>
</div>