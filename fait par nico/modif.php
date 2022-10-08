<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
</head>
<body>
<h1>Modification du pays fait par nico :</h1>

<?php
require_once("tp_mysql.php");

try {
    $dbh = new PDO($dsn, $user, $pwd);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $req = sprintf("SELECT * FROM pays WHERE id = %d", $_GET['id']);
    $stmt = $dbh->query($req);
    $res = $stmt->fetch();
    // print_r($res);
} catch (PDOException $myexep) {
    die(sprintf('<p class="error">la connexion à la base de données à été refusée <em>%s</em></p>' .
        "\n", htmlspecialchars($myexep->getMessage())));
}
$id = $res['id'];
$nom = $res['nom'];
$code = $res['code'];
//$drapeau = $res['drapeau'] ?? '';

?>
<form action="modif.php" method="get">
    <?php
    if (!isset($_GET['nom'])) {
    ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            Pays n° : <?= $id ?? '' ?>
        </p>
        <p>
            <label for="nom">Nom du pays :</label>
            <input type="text" name="nom" id="nom" value=<?= $nom ?? '' ?> required>
        </p>
        <p>
            <label for="code">Code du pays :</label>
            <input type="text" name="code" id="code" value=<?= $code ?? '' ?> required>
        </p>
        <p>
            <label for="drapeau">Drapeau du pays :</label>
            <img class="drapeau_country" src="http://localhost/php/projet/image.php?id=<?= $id ?? '' ?>" alt="<?= $country['nom'] ?>">
            <input type="file" name="drapeau" id="drapeau" value=<?= $drapeau ?? '' ?> required>
        </p>
        <p>
            <input type="submit" value="Modifier">
        </p>

        <?php
        //Update country
        if (isset($_GET['nom']) && isset($_GET['code'])) {
            $nom = $_GET['nom'];
            $code = $_GET['code'];
            //$drapeau = $_POST['drapeau'];
            $sql = $dbh->prepare("UPDATE pays SET nom = ?, code = ? WHERE id = ?");
            $sql->execute([$nom, $code, $id]);
        }
    } else {
        ?>
        <h2>Pays modifié</h2>
        <p>
            Id : <?= $id ?? '' ?>
        </p>
        <p>
            Nom : <?= $_GET['nom'] ?? '' ?>
        </p>
        <p>
            Code : <?= $_GET['code'] ?? '' ?>
        </p>
        <p>
            <a href="lire_images.php">Retour à la liste des pays</a>
        </p>
    <?php
    }
    ?>
</body> 
</html>