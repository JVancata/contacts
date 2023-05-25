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
        require 'form_error.php';
    }
    if ($message) {
        require 'form_message.php';
    }
    ?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactAddModal">
        Přidat kontakt
    </button>


    <?php
    if (!empty($contacts)) {
        require 'contacts_table.php';
    } else {
        echo "<h3>Seznam kontaktů je prázdný.</h3>";
    }
    ?>
</div>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>