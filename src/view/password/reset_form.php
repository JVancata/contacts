<form method="POST" action="/password/reset">
    <div class="login-form-container">
        <?php
        if ($error) {
            require __DIR__ . '/../form/form_error.php';
        }
        if ($message) {
            require __DIR__ . '/../form/form_message.php';
        }
        ?>
        <div class="mb-3 row">
            <label for="inputEmail" class="col-sm-6 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" id="inputEmail" placeholder="váš@email.cz" name="email" value="<?php echo $_SESSION["last_form"]["email"] ?? ""; ?>" required>
            </div>
        </div>
        <div class="mb-3 row text-end">
            <label class="col-sm-12"><a href="/login" title="Přihlášení">Přihlášení</a></label>
        </div>
        <div class="mb-3 row">
            <input type="submit" class="form-control btn btn-success" id="inputSubmit" value="Obnovit heslo">
        </div>
    </div>
</form>

<?php
