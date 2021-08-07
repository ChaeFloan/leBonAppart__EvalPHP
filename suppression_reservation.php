<?php
require "fonctions/connexionDB.php";
$db = getConnexion();

$query = $db->prepare(
    "SELECT id, title, description, postal_code, city, type, price
    FROM advert
    WHERE id = ?"
);
$query->execute(
    [$_GET["id"]]
);
$detailAdvert = $query->fetchAll();

$identifiant = $detailAdvert[0]['id'];

// Sur cette page, on nettoie le message de réservation cliqué afin de faire de nouveau apparaître l'espace de commentaire et la disponibilité de l'annonce
$query = $db->prepare(
    "UPDATE advert
    SET reservation_message = ''
    WHERE id = ?"
);
$query->execute(
    [$_GET["id"]]
);
header("Location: consultAdvert.php?id=$identifiant");
exit();