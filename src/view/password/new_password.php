<?php
$seo = new SEO();
$seo->title = "Obnovení hesla";

require_once __DIR__ . "/../layout/layout_top.php";

?>

<div class="container">
    <h2 class="text-center">Obnovení hesla</h2>
    <?php
    require 'new_password_form.php';
    ?>
</div>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>