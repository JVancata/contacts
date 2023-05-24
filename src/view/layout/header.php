<header>
    <div class="row">
        <div class="col">
            <h1 class="d-inline"><a class="link-to-dashboard" href="/dashboard" title="Zpět na hlavní stránku">CMS</a></h1>
        </div>
        <div class="col text-end">
            <?php
            if (!empty($_SESSION["user"])) {
                echo '<a href="/logout" class="text-white" title="Odhlásit">Odhlásit</a>';
            }
            ?>
        </div>
    </div>
</header>