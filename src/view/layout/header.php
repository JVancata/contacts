<header>
    <div class="row">
        <div class="col">
            <h1 class="d-inline">CMS</h1>
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