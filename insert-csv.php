<?php

require 'database.php';

$path = "gac.csv";

$db->exec(

    sprintf("LOAD DATA local INFILE '%s' INTO TABLE mobiledata 
    
            FIELDS TERMINATED BY ';'
            
            LINES TERMINATED BY '\n'

            IGNORE 3 LINES", 
            
            $path)
    );

    var_dump('insertion du fichier csv réussi');

    die();