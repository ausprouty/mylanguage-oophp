<?php

    $isoCodes = getIso();
    foreach ($isoCodes as $isoCode){
        $hlCode = getHL($isoCode['languageCodeIso']);
        if ($hlCode){
            echo ("$hlCode<br>");
            updateBible($hlCode, $isoCode['languageCodeIso']) ;
        }
    }

    function getIso(){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT distinct languageCodeIso FROM bibles
          WHERE languageCodeHL = :blank";
        $params = array(':blank' => '' );
        $statement = $dbConnection->executeQuery($query, $params);
        $isoCodes= $statement->fetchAll(PDO::FETCH_ASSOC);
        return $isoCodes;
    }
    function getHL($isoCode){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT languageCodeHL FROM hl_languages
            WHERE languageCodeIso = :languageCodeIso
            LIMIT 1";
        $params = array(':languageCodeIso' => $isoCode );
        $statement = $dbConnection->executeQuery($query, $params);
        $hl= $statement->fetch(PDO::FETCH_COLUMN);
        return $hl;
    }
    function updateBible($hlCode, $isoCode){
        $dbConnection = new DatabaseConnection();
        $query = "UPDATE bibles  SET languageCodeHL = :languageCodeHL
            WHERE languageCodeIso = :languageCodeIso";
       $params = array(
           ':languageCodeIso' => $isoCode ,
           ':languageCodeHL' => $hlCode
       );
       $dbConnection->executeQuery($query, $params);

    }
     