<?php
$seo = new SEO();
$seo->title = "Dashboard";

require_once __DIR__ . "/../layout/layout_top.php";

?>

<div class="container">
    <h2 class="text-center">Dashboard</h2>
    <p><span class="fw-bold">User:</span> <?php echo $_SESSION["unserializedUser"]->username; ?></p>

    <?php
    require 'contact_add_form_modal.php';
    if ($error) {
        require __DIR__ . '/../form/form_error.php';
    }
    if ($message) {
        require __DIR__ . '/../form/form_message.php';
    }
    ?>



    <?php
    if (!empty($contacts)) {
        echo '<div class="text-end"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactAddModal">
            Přidat kontakt
        </button></div>';
        require 'contacts_table.php';
    } else {
        echo "<h3 class='text-center'>Seznam kontaktů je prázdný.</h3>";
        echo '<div class="text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactAddModal">
            Přidat kontakt
        </button></div>';
    }
    ?>
</div>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>