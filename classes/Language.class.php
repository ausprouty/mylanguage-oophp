<?php



class Language extends DbConnection
{

// see  https://www.php.net/manual/en/pdostatement.execute.php
public function findByHL($id)
    {
    $dbh= $this->connect();
    $sth = $dbh->prepare('SELECT * FROM hl_language WHERE hl_id = :id LIMIT 1');
	$sth ->execute (array('id'=>'eng00'));
    $record = $sth->fetch(PDO::FETCH_ASSOC);
    return ($record);
    }

}


/*<?php
// Database credentials
$dsn = 'mysql:host=localhost;dbname=your_database_name';
$user = 'your_username';
$password = 'your_password';

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $password);

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to select a record
    $sql = 'SELECT * FROM language WHERE index = :index LIMIT 1';

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind the parameter
    $index = 'eng00';
    $stmt->bindParam(':index', $index);

    // Execute the query
    $stmt->execute();

    // Fetch the record as an associative array
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    // Output the result
    print_r($record);

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
*/
