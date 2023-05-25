<?php
$seo = new SEO();
$seo->title = "Dashboard";

require_once __DIR__ . "/../layout/layout_top.php";

?>

<div class="container">
    <?php
    require 'group_assign_modal.php';
    require 'note_edit_modal.php';
    require 'contact_edit_modal.php';
    require 'photo_upload_modal.php';
    require 'information_add_modal.php';
    if ($error) {
        require 'form_error.php';
    }
    if ($message) {
        require 'form_message.php';
    }
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-5 text-center text-md-start pb-md-0 pb-3">
                    <img width="200" alt="Profilová fotografie" src="<?php echo $contact["profile_photo"] ? "/uploads/" . $contact["profile_photo_path"] : "/resources/user_icon.png" ?>">
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12 col-7">
                            <?php
                            if (!empty($contact["last_name"])) {
                                echo '<h3 class="contact-name-heading"><i class="fa-solid fa-user me-3"></i>' . $contact["first_name"] . ' ' . $contact["last_name"] . '</h3>';
                            }
                            if (!empty($contact["nickname"])) {
                                echo '<h3 class="contact-name-heading"><i class="fa-solid fa-user-group me-2"></i>"' . $contact["nickname"] . '"</h3>';
                            }
                            ?>

                            <hr class="d-md-block d-none">
                        </div>
                        <div class="col-md-12 col-5">
                            <div class="row">
                                <div class="col-md-9">
                                    <span class="d-block"><i class="fa-solid fa-cake-candles"></i> <?php echo $contact["birth_date"] ? date("d. m. Y", strtotime($contact["birth_date"])) : "Nezadáno."; ?></span>
                                    <span class="d-block"><i class="fa-solid fa-calendar-days"></i> <?php echo date("d. m. Y", strtotime($contact["created_at"])); ?></span>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <button class="btn p-0" id="profileEditButton" data-bs-toggle="modal" data-bs-target="#contactEditModal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <span class="d-block pt-3">
                                <?php
                                foreach ($contactGroups as $contactGroup) {
                                    echo '<a href="/group/unassign/?groupId=' . $contactGroup["id"] . '&contactId=' . $contact["id"] . '" onclick="return confirm(`Opravdu chcete skupinu ' . $contactGroup["name"] . ' z kontaktu odstranit?`)"><span class="badge me-2" style="background-color:' . $contactGroup["background_color"] . ';color:' . $contactGroup["text_color"] . '">' . $contactGroup["name"] . '</span></a>';
                                }
                                ?>
                                <button class="btn badge rounded-pill text-bg-primary" data-bs-toggle="modal" data-bs-target="#groupAssignModal"><i class="fa-solid fa-plus"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="text-end">
                <?php
                foreach ($information as $singleInformation) {
                    echo '<span class="d-block">' . $singleInformation["value"] . '<a href="/information/delete?contactId=' . $contact["id"] . '&informationId=' . $singleInformation["id"] . '" onclick="return confirm(`Opravdu chcete tuto informaci smazat?`)" class="ms-3 information-icon ' . $singleInformation["icon_class_name"] . '"></a></span>';
                }
                ?>
                <button class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#informationAddModal">
                    Přidat informaci
                </button>
            </div>

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-9">
            <form method="POST" action="/note/insert" class="row pb-3">
                <div class="col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="note" placeholder="Nová poznámka" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Nová poznámka</label>
                    </div>
                </div>
                <div class="col-md-2 pt-2">
                    <button type="submit" class="btn btn-success" title="Uložit poznámku">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-warning text-white" id="changeNewNoteVisibility" title="Změnit viditelnost">
                        <i class="fa-solid fa-eye" style="width:20px"></i>
                    </button>
                </div>
                <input type="hidden" name="hidden" value="false">
                <input type="hidden" name="contactId" value="<?php echo $contact["id"]; ?>">
            </form>
            <table class="table">
                <tbody>
                    <?php
                    //print_r($notes);
                    foreach ($notes as $note) {
                        echo "<tr class='row'>";

                        echo '<td class="col-10 ps-3 word-break" class="" data-noteid="' . $note["id"] . '" data-length="' . strlen($note["note"]) . '" data-note="' . $note["note"] . '" data-hidden=' . $note["hidden"] . '>';

                        if ($note["hidden"] == 1) {
                            echo str_repeat("*", strlen($note["note"]));
                        }
                        //
                        else {
                            echo $note["note"];
                        }
                        echo "</td>";

                        echo '
                        <td class="col-2">
                            <div class="dropdown ms-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                ' . ($note["hidden"] == 1 ? '<li><a role="button" class="dropdown-item note-show-button" href="#" data-id=' . $note["id"] . ' >Zobrazit</a></li>' : "") . '
                                <li><a role="button" data-bs-toggle="modal" data-bs-target="#noteEditModal" class="dropdown-item note-edit-button" href="#" data-id=' . $note["id"] . ' >Upravit</a></li>
                                <li><a class="dropdown-item" href="/note/' . ($note["hidden"] == 1 ? 'unhide' : 'hide') . '?noteId=' . $note["id"] . '&contactId=' . $contact["id"] . '" role="button">Permanentně ' . ($note["hidden"] == 1 ? 'odkrýt' : 'skrýt') . '</a></li>
                                <li><a class="dropdown-item" href="/note/delete?noteId=' . $note["id"] . '&contactId=' . $contact["id"] . '" onclick="return confirm(`Opravdu chcete smazat poznámku?`)">Smazat</a></li>
                                </ul>
                            </div>
                        </td>';

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <h3>Tady budou vazby mezi kontakty</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#photoUploadModal">
                Přidat fotku
            </button>
        </div>
        <div class="col-12 pt-3">

            <div class="row">
                <?php
                foreach ($photos as $photo) {
                    echo '<div class="col-xl-4 col-md-4 col-6">';
                    echo '<div class="contact-photo-container">';
                    echo '<span class="contact-photo" style="background-image:url(/uploads/' . $photo["path"] . ');" title="Fotografie ' . $photo["id"] . ' ke kontaktu."></span>';
                    echo '<div class="contact-photo-button-container">
                    <a class="btn btn-secondary" href="/contact/profilephoto?contactId=' . $contact["id"] . '&photoId=' . $photo["id"] . '" onclick="return confirm(`Nastavit jako profilovku?`)"><i class="fa-solid fa-user"></i></a>
                    <a class="btn btn-danger" href="/photo/delete?contactId=' . $contact["id"] . '&photoId=' . $photo["id"] . '" onclick="return confirm(`Opravdu nenávratně smazat?`)"><i class="fa-solid fa-trash"></i></a>
                    </div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    // Add note form
    const visibilityToggleButton = document.querySelector("#changeNewNoteVisibility");
    const hiddenVisibilityInput = document.querySelector("input[name=hidden]");

    const handleToggle = () => {
        if (hiddenVisibilityInput.value === "false") {
            hiddenVisibilityInput.value = "true";
            visibilityToggleButton.querySelector("i").classList.remove("fa-eye");
            visibilityToggleButton.querySelector("i").classList.add("fa-eye-slash");
        } else {
            hiddenVisibilityInput.value = "false";
            visibilityToggleButton.querySelector("i").classList.remove("fa-eye-slash");
            visibilityToggleButton.querySelector("i").classList.add("fa-eye");
        }
    }
    visibilityToggleButton.addEventListener("click", handleToggle);

    // Note hide/show
    const showTheNote = (e) => {
        const td = document.querySelector(`td[data-noteid="${e.target.dataset.id}"]`);

        if (td.dataset.hidden === "1") {
            td.innerHTML = td.dataset.note;
            e.target.textContent = "Skrýt";
            td.dataset.hidden = "0";
        } else {
            td.innerHTML = Array(parseInt(td.dataset.length) + 1).join("*");
            e.target.textContent = "Zobrazit";
            td.dataset.hidden = "1";
        }
    }

    const noteShowButtons = document.querySelectorAll(".note-show-button") ?? [];

    for (const button of noteShowButtons) {
        button.addEventListener("click", showTheNote);
    }

    // Note edit modal
    const noteEditButtons = document.querySelectorAll(".note-edit-button") ?? [];
    const noteEditTextarea = document.querySelector("#noteEditTextarea");
    const noteEditNoteIdInput = document.querySelector("#noteEditNoteIdInput");

    const prepareTheNoteEdit = (e) => {
        const td = document.querySelector(`td[data-noteid="${e.target.dataset.id}"]`);

        noteEditTextarea.innerHTML = td.dataset.note.replaceAll("<br>", "\n");
        noteEditNoteIdInput.value = e.target.dataset.id;
    }


    for (const button of noteEditButtons) {
        button.addEventListener("click", prepareTheNoteEdit);
    }

    // Profile edit
</script>


<?php
require_once __DIR__ . "/../layout/layout_bottom.php";
?>