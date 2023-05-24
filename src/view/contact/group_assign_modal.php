<div class="modal" tabindex="-1" id="groupAssignModal">
    <div class="modal-dialog">
        <form method="POST" action="/group/assign" class="modal-content" id="groupForm">
            <div class="modal-header">
                <h5 class="modal-title">Přidat skupinu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <?php
                    if ($error) {
                        require 'form_error.php';
                    }
                    if ($message) {
                        require 'form_message.php';
                    }
                    ?>
                    <select class="form-select" aria-label="Default select example" required name="groupId" id="groupAssignSelect">
                        <?php
                        $returnId = function ($element) {
                            return $element["id"];
                        };

                        $contactGroupIds = array_map($returnId, $contactGroups);

                        foreach ($allGroups as $availableGroup) {
                            if (in_array($availableGroup["id"], $contactGroupIds)) {
                                continue;
                            }
                            echo '<option value="' . $availableGroup["id"] . '">' . $availableGroup["name"] . '</option>';
                        }
                        ?>
                        <option value="new-group">Vytvořit novou skupinu</option>
                    </select>
                    <div id="newGroupForm" class="d-none pt-3">
                        <label for="groupNameInput" class="col-sm-6 col-form-label">Název nové skupiny</label>
                        <input id="groupNameInput" type="text" name="name" class="form-control" placeholder="Název nové skupiny" value="Nová skupina" required>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="groupBackgroundColorInput" class="form-label pt-2">Barva skupiny</label>
                                <input type="color" class="form-control form-control-color" id="groupBackgroundColorInput" value="#563d7c" name="backgroundColor" title="Vyber barvu skupiny">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label pt-2">Barva textu</label>
                                <div class="" id="textColorInputContainer">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="textColor" value="white" checked>
                                        <label class="form-check-label" for="inlineRadio1">Bílá</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="textColor" value="black">
                                        <label class="form-check-label" for="inlineRadio2">Černá</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="form-label pt-2">Náhled</label>
                        <div class="d-block">
                            <span class="badge" id="groupPreviewPill">Náhled</span>
                        </div>
                    </div>
                    <input type="hidden" name="contactId" value="<?php echo $contact["id"]; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                <button type="submit" class="btn btn-success" value="Přidat kontakt">Přidat skupinu</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Group preview
    const groupBackgroundColorInput = document.querySelector("#groupBackgroundColorInput");
    const textColorInputContainer = document.querySelector('#textColorInputContainer');
    const groupNameInput = document.querySelector('#groupNameInput')

    const changeGroupPreviewPill = () => {
        const groupPreviewPill = document.querySelector("#groupPreviewPill");

        groupPreviewPill.style.backgroundColor = groupBackgroundColorInput.value;
        groupPreviewPill.style.color = textColorInputContainer.querySelector(":checked")?.value === "black" ? "#000000" : "#FFFFFF";
        groupPreviewPill.textContent = groupNameInput.value.replaceAll(" ", "") === "" ? "Nová skupina" : groupNameInput.value;
    }

    changeGroupPreviewPill();
    groupBackgroundColorInput.addEventListener("input", changeGroupPreviewPill);
    textColorInputContainer.addEventListener("change", changeGroupPreviewPill);
    groupNameInput.addEventListener("input", changeGroupPreviewPill);

    // Show the form if selected
    const assignSelect = document.querySelector("#groupAssignSelect");
    const newGroupForm = document.querySelector("#newGroupForm");
    // The whole form
    const groupForm = document.querySelector("#groupForm");


    const handleNewGroupForm = (e) => {
        const selectValue = assignSelect.value;

        // The new group form is shown
        if (selectValue === "new-group") {
            newGroupForm.classList.remove("d-none");
            groupForm.action = "/group/add";
        }
        // The new group form is hidden
        else {
            groupForm.action = "/group/assign";
            if (!newGroupForm.classList.contains("d-none")) {
                newGroupForm.classList.add("d-none");
            }
        }
    }
    assignSelect.addEventListener("change", function(e) {
        handleNewGroupForm();
    });
    handleNewGroupForm();
</script>