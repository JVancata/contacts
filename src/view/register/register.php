<?php
$seo = new SEO();
$seo->title = "Registrace";

require_once __DIR__ . "/../layout/layout_top.php";

?>

<div class="container">
    <h1 class="text-center">Registrace</h1>
    <?php
    require 'form.php';
    ?>
</div>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>