<?php

require 'database.php';

// On parcourt les données de la table
$stmt = $db->query("SELECT * FROM mobiledata");

while ($row = $stmt->fetch()) {
    
    // On récupère la date de l'appel au format string
    $date = $row['date'];

    // On convertit la date au format date sql
    $dateArray = explode('/', $date);

    $newdate = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];

    // Si l'appel a été effectué au plus tôt le 2012-02-15
    if(stristr($row['type'], 'appel') AND $newdate >= "2012-02-15") {

        // On enregistre la durée de chaque appel en secondes dans le tableau totalSeconds
        $parsed = date_parse($row['duree_reel']);
        
        $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
    
        $otalSeconds[] = $seconds;

    } 
    
    // Si la colonne type contient le mot sms
      
    if(stristr($row['type'], 'sms')) {

        // On ajoute le type dans un tableau
        $totalSms[] = $row['type'];

    }

}

// On additionne toutes les secondes du tableau totalSeconds pour avoir la durée totale des appels en secondes
$allSeconds = array_sum($otalSeconds);

// On convertit ces secondes au format heures/minutes/secondes
$hours = gmdate('H', $allSeconds);
$minutes = gmdate('i', $allSeconds);
$seconds = gmdate('s', $allSeconds);

// On compte le nombre de sms à partir du nombre d'éléments dans le tableau totalSms;
$countSms = count($totalSms);

// On affiche la durée total des appels et le nombre totale de sms

echo "<p>La durée totale des appels depuis le 15 Février 2012 (inclus) est de: $hours heures, $minutes minutes, et $seconds secondes</p>";

echo "Le nombre total de sms est : $countSms";

// On récupère les données pour afficher le top 10 des data par abonné
$data = $db->query("SELECT DISTINCT * FROM mobiledata WHERE type LIKE '%connexion%'");

while ($row = $data->fetch()) {

    //Si l'heure d'utilisation est inférieure à 8h ou supérieure à 18h
    if(strtotime($row['heure']) < strtotime("08:00:00") OR strtotime($row['heure']) > strtotime("18:00:00")) {

        // On enregistre la quantité de datas dans le tableau volumes
        $volumes[] = $row['duree_reel'];

    }

}

// On récupère le top 10 des datas et on stocke cela dans un tableau
rsort($volumes);
$volumes = array_unique($volumes);
$maxValues = array_slice($volumes, 0, 10);

// On initialise la première position du top 10 à 1;
$i = 1;

echo "<p>Top 10 data par abonné ci après:</p>";

// On parcourt le tableau qui contient le top 10 des data
forEach($maxValues as $value) {

    // On récupère en base de données les clients qui ont utilisé les datas concernés
    $newdata = $db->query("SELECT DISTINCT duree_reel, client FROM mobiledata WHERE duree_reel = $value");

    // On affiche le top 10 des datas par client;
    while ($row = $newdata->fetch()) {

        $client = $row['client'];

        $duree = $row['duree_reel'];

       echo "<p>Position: $i | Client : $client | Quantité de data : $duree</p>";
        
    }

    $i++;

}