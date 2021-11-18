<?php

//host -> nom de votre server
//dbname->nom de la base de données
//root -> nom user de la base de données
// '' => veuillez ajouter mot de passe de connexion

//[PDO::MYSQL_ATTR_LOCAL_INFILE => true] => config qui permet d'utiliser la fonction LOAD DATA INFILE pour importer rapidement un fichier csv

$db = new PDO('mysql:host=localhost;dbname=phonedata', 'root', '', [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);