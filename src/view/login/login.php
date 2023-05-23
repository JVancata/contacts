<?php
$seo = new SEO();
$seo->title = "Přihlášení";

require_once __DIR__ . "/../layout/layout_top.php";

?>

<div class="container">
    <h2 class="text-center">Přihlášení</h2>
    <?php
    require 'form.php';
    ?>
</div>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>