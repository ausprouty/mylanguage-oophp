<?php

$dbConnection = new DatabaseConnection();

$query = "SELECT * FROM hl_bilingual_tracts";
try {
    $statement = $dbConnection->executeQuery($query);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    return null;
}
foreach ($results as $data){
    $webpage = str_replace('http://www.hereslife.com/downloads/tracts/', '', $data['webpage']);
    $webpage = str_replace('.pdf', '.html', $data['webpage']);
    $query = "UPDATE hl_bilingual_tracts
        SET webpage = :webpage WHERE id = :id
        LIMIT 1";
    $params = array(':webpage'=>$webpage, ':id'=>$data['id']);
}