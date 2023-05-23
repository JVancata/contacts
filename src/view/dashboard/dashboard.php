<?php
$seo = new SEO();
$seo->title = "Dashboard";

require_once __DIR__ . "/../layout/layout_top.php";

?>

<div class="container">
    <h1 class="text-center">Dashboard</h1>
    <p><span class="fw-bold">User:</span> <?php echo $_SESSION["unserializedUser"]->username; ?></p>
</div>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>