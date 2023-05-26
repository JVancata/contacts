<form method="POST" action="/password/new">
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
            <label for="inputEmail" class="col-sm-6 col-form-label">Nové heslo</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputEmail" placeholder="********" name="newPassword" required>
                <input type="hidden" name="resetToken" value="<?php echo htmlspecialchars($_GET["parameter"]); ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <input type="submit" class="form-control btn btn-success" id="inputSubmit" value="Změnit heslo">
        </div>
    </div>
</form>

<?php
