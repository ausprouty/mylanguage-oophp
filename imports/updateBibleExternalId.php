<?php

$dbConnection = new DatabaseConnection();
$query = "SELECT * FROM bibles
    WHERE source = :youversion
    AND externalId LIKE :old";
$params = array(
    ':youversion' => 'youversion',
    ':old' => '%-%' );
$statement = $dbConnection->executeQuery($query, $params);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $data){
    $new = str_replace('-', '/%.', $data['externalId']);
    $query = "UPDATE bibles  SET externalId = :externalId
    WHERE bid = :bid
    LIMIT 1";
    $params = array(
        ':externalId' => $new,
        ':bid' => $data['bid']
    );
    $dbConnection->executeQuery($query, $params);
    echo (" $new <br>");
}

     