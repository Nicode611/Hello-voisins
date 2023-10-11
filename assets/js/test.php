

<?php
if (isset($_POST['donnee'])) {
    $donnee = $_POST['donnee'];
    echo "La donnée reçue est : " . $donnee;
} else {
    echo "Aucune donnée reçue.";
}
?>




