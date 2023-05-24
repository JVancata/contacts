<form method="POST" action="/register/register">
    <div class="login-form-container">
        <?php
        if ($error) {
            require 'form_error.php';
        }
        if ($message) {
            require 'form_message.php';
        }
        ?>
        <div class="my-3 row">
            <label for="inputUsername" class="col-sm-6 col-form-label">Přihlašovací jméno</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputUsername" placeholder="Přihlašovací jméno" name="username" value="<?php echo $_SESSION["last_form"]["username"] ?? ""; ?>" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputEmail" class="col-sm-6 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" id="inputEmail" placeholder="váš@email.cz" name="email" value="<?php echo $_SESSION["last_form"]["email"] ?? ""; ?>" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-6 col-form-label">Heslo</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputPassword" placeholder="*************" name="password" minlength="5" required>
            </div>
        </div>
        <div class="mb-3 row text-end">
            <label for="inputPassword" class="col-sm-12 col-form-label"><a href="/login" title="Přihlášení">Přihlášení</a></label>
        </div>
        <div class="mb-3 row">
            <input type="submit" class="form-control btn btn-success" id="inputSubmit" value="Registrovat">
        </div>
    </div>
</form>

<?php


