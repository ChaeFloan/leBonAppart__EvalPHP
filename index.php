<?php

require "fonctions/connexionDB.php";
$db = getConnexion();

// La page d'accueil / index doit contenir la liste des annonces dans un ordre chronologique, il doit y avoir x annonces
$limit = 10;

if(!empty($_POST["selectionLimit"])){
    if($_POST["selectionLimit"] == 5){
        $limit = 5;
    }
    if($_POST["selectionLimit"] == 10){
        $limit = 10;
    }
    if($_POST["selectionLimit"] == 15){
        $limit = 15;
    }
}

// Récupérer les annonces depuis la BDD
$query = $db->prepare(
    "SELECT id, title, description, postal_code, city, type, price
    FROM advert
    ORDER BY id DESC
    LIMIT $limit "
);
$query->execute();
$allAdverts = $query->fetchAll();

// Pour le compte total d'annonces
$query = $db->prepare(
    "SELECT COUNT(*)
    FROM advert"
);
$query->execute();
$countAdverts = $query->fetchAll();

$totalAdverts = $countAdverts[0]["COUNT(*)"];



$templates = "templates/index.phtml";
require "templates/layout.phtml";