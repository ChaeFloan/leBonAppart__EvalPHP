<?php
require "fonctions/connexionDB.php";
$db = getConnexion();

// Récupération de la liste des annonces avec le détail de chacune
$query = $db->prepare(
    "SELECT id, title, description, postal_code, city, type, price
    FROM advert
    ORDER BY id DESC"
);
$query->execute();
$allAdverts = $query->fetchAll();

// Compte du nombre d'annonces disponibles
$query = $db->prepare(
    "SELECT COUNT(*)
    FROM advert"
);
$query->execute();
$countAdverts = $query->fetchAll();

$totalAdverts = $countAdverts[0]["COUNT(*)"];

// Pour la partie réservation
$query = $db->prepare(
    "SELECT reservation_message
    FROM advert
    ORDER BY id DESC"
);
$query->execute();
$reservation = $query->fetchAll();


$templates = "templates/consultAllAdvert.phtml";
require "templates/layout.phtml";