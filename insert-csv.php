<?php

require 'database.php';

$path = "gac.csv";

try {

        $db->exec(

                sprintf("LOAD DATA local INFILE '%s' INTO TABLE mobiledata 

                FIELDS TERMINATED BY ';'

                LINES TERMINATED BY '\n'

                IGNORE 3 LINES", 

                $path)
        );

        echo "insertion du fichier csv réussi";

} catch(Exception $e) {

        echo "l'insertion du fichier a échoué";
}
