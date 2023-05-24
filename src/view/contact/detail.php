<?php
$seo = new SEO();
$seo->title = "Dashboard";

require_once __DIR__ . "/../layout/layout_top.php";

?>

<div class="container">
    <?php
    require 'group_assign_modal.php';
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-5 text-center text-md-start pb-md-0 pb-3">
                    <img width="200" alt="Profilová fotografie" src="<?php echo $contact["profile_photo"] ?? "https://as.vse.cz/wp-content/uploads/marek_petr-150x150.jpg" ?>">
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12 col-6">
                            <?php
                            if (!empty($contact["last_name"])) {
                                echo '<h3>' . $contact["first_name"] . ' ' . $contact["last_name"] . '</h3>';
                            }
                            if (!empty($contact["nickname"])) {
                                echo '<h3>"' . $contact["nickname"] . '"</h3>';
                            }
                            ?>

                            <hr class="d-md-block d-none">
                        </div>
                        <div class="col-md-12 col-6">
                            <span class="d-block"><i class="fa-solid fa-cake-candles"></i> <?php echo $contact["birthday"] ?? "Nezadáno."; ?></span>
                            <span class="d-block"><i class="fa-solid fa-calendar-days"></i> <?php echo date("d. m. Y", strtotime($contact["created_at"])); ?></span>
                        </div>
                        <div class="col-md-12 col-12">
                            <span class="d-block pt-3">
                                Spolužák, 4Story, smraďoch
                                <button class="btn badge rounded-pill text-bg-primary" data-bs-toggle="modal" data-bs-target="#groupAssignModal"><i class="fa-solid fa-plus"></i></button>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">

    </div>
</div>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>