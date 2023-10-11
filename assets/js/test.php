<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./ajax.js"></script>
<?php
if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    echo $latitude . $longitude;
} else {
    echo "Les clés 'latitude' et/ou 'longitude' n'ont pas été transmises.";
}



