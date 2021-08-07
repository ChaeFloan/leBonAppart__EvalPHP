<?php
require "fonctions/connexionDB.php";
$db = getConnexion();

// Si les champs du formulaire ne sont pas vides, ajouter les informations renseignées dans chaque input dans la base de donnée
if(!empty($_POST["title"]) && !empty($_POST["description"]) && !empty($_POST["postal_code"]) && !empty($_POST["city"]) && !empty($_POST["type"]) && !empty($_POST["price"])){
    $query = $db->prepare(
        "INSERT INTO advert (title, description, postal_code, city, type, price)
        VALUES (?, ?, ?, ?, ?, ?)"
    );
    $query->execute([
        htmlspecialchars($_POST["title"]),
        htmlspecialchars($_POST["description"]),
        htmlspecialchars($_POST["postal_code"]),
        htmlspecialchars($_POST["city"]),
        $_POST["type"],
        htmlspecialchars($_POST["price"])]
    );
    $newAdvert = $query->fetchAll(); 
    header("Location: index.php");
    exit();
}

     



















$templates = "templates/newAdvert.phtml";
require "templates/layout.phtml";