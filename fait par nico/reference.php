<?php
//import data from a csv file to database table pays
require_once("access.php");

$path_file = "data/pays.csv";
$table_name = "pays";

$create_table_req = "CREATE TABLE IF NOT EXISTS $table_name (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    code VARCHAR(3) NOT NULL,
    drapeau  BLOB,
    PRIMARY KEY (id)
)";

try {
    $dbh =  new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $myexep) {
    die(sprintf('<p class="error">la connexion à la base de données à été refusée <em>%s</em></p>' .
        "\n", htmlspecialchars($myexep->getMessage())));
}

//create table pays
if ($dbh->exec($create_table_req) === false) {
    die(sprintf('<p class="error">la création de la table %s à été refusée <em>%s</em></p>' .
        "\n", $table_name, htmlspecialchars($dbh->errorInfo()[2])));
} else {
    echo "<p>la table $table_name a été créée</p>\n";
}

//read csv file
if ($csv_file = fopen($path_file, "r")) {
    echo "<p>le fichier $path_file a été ouvert</p>\n";
    while ($line = fgetcsv($csv_file, 0, ",")) {
        echo "<p>ligne lue : " . implode(" ", $line) . "</p>\n";
    }
    fclose($csv_file);
} else {
    printf('<p class="error">Le fichier <samp>%s</samp> ne peut pas être ouvert en lecture.</p>' . "\n", $path_file);
}

//insert data from csv file to table pays

if ($csv_file = fopen($path_file, 'r')) {
    while ($line = fgetcsv($csv_file, 0, ",")) {
        $sql = $dbh->prepare("INSERT INTO $table_name (id, nom, code) VALUES (:id, :nom, :code)");
        $sql->execute([
            'id' => $line[0],
            'nom' => $line[1],
            'code' => $line[2],
        ]);
    }
    fclose($csv_file);
} else {
    printf('<p class="error">Le fichier <samp>%s</samp> ne peut pas être ouvert en lecture.</p>' . "\n", $path_file);
}

//fermeture de la BDD
unset($dbh);
