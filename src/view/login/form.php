<form method="POST" action="/login/login">
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
                <input type="text" class="form-control" id="inputUsername" placeholder="Přihlašovací jméno" name="username" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-6 col-form-label">Heslo</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputPassword" placeholder="*************" name="password" required>
            </div>
        </div>
        <div class="mb-3 row text-end">
            <label for="inputPassword" class="col-sm-12 col-form-label"><a href="/register" title="Registrace">Registrace</a></label>
        </div>
        <div class="mb-3 row">
            <input type="submit" class="form-control btn btn-success" id="inputSubmit" value="Přihlásit">
        </div>
    </div>
</form>