<?php
require "fonctions/connexionDB.php";
$db = getConnexion();

// Récupération du détail de chaque annonce
$query = $db->prepare(
    "SELECT id, title, description, postal_code, city, type, price
    FROM advert
    WHERE id = ?"
);
$query->execute(
    [$_GET["id"]]
);
$detailAdvert = $query->fetchAll();

// Si un message est laissé pour la réservation du bien, enregistrer les informations dans la BDD
if(!empty($_POST["reservation_message"])){
    $query = $db->prepare(
        "UPDATE advert
        SET reservation_message = ?
        WHERE id = ?"
    );
    $query->execute(
        [htmlspecialchars($_POST["reservation_message"]), 
        $_GET["id"]]
    );
}

// Récupérer les données afin de les afficher sur la page
$query = $db->prepare(
    "SELECT reservation_message
    FROM advert
    WHERE id = ?"
);
$query->execute(
    [$_GET["id"]]
);
$reservation = $query->fetchAll();

// Pour les pages précédent et suivant
$identifiant = (int)$_GET["id"];
$precedentIdentifiant = $identifiant - 1;
$suivantIdentifiant = $identifiant + 1;

// Reprise du compte d'annonces afin de limiter les accès aux boutons précédent et suivant
$query = $db->prepare(
    "SELECT COUNT(*)
    FROM advert"
);
$query->execute();
$countAdverts = $query->fetchAll();

$totalAdverts = $countAdverts[0]["COUNT(*)"];

// Sécurité pour le dépassement de pages dans l'url
if($_GET["id"] < 1 || $_GET["id"] > $totalAdverts){
    header("Location: index.php");
    exit();
}

$templates = "templates/consultAdvert.phtml";
require "templates/layout.phtml";