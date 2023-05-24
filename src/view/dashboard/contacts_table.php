<table class="table table-striped" id="contactsTable">
    <thead>
        <tr>
            <th scope="col">Přezdívka</th>
            <th scope="col">Jméno</th>
            <th scope="col">Příjmení</th>
            <th scope="col">Akce</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($contacts as $contact) {
            echo '<tr class="contact-table-row">';

            
            echo "<td>";
            echo $contact["nickname"];
            echo "</td>";
            
            echo "<td>";
            echo $contact["first_name"];
            echo "</td>";
            
            echo "<td>";
            echo $contact["last_name"];
            echo "</td>";
            
            echo "<td>";

            echo '<a class="btn btn-warning text-white" href="contact/detail/' . $contact["id"] . '" title="Kontakt ' . $contact["first_name"] . ' ' . $contact["last_name"] . ' ' . $contact["nickname"] . '">';
            echo '<i class="fa-solid fa-eye"></i>';
            echo '</a>';

            echo "</td>";


            echo "</tr>";
        }
        ?>
    </tbody>
</table>