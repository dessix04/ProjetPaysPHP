<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php
require_once("tp_mysql.php");
try {
  if (empty($_REQUEST['envoi'])){
    $form = <<<EOD
        <form action="#" method="get">
            <input type="hidden" name="id" value="%d"/>
            <fieldset>Nom:<input type="text" name="nom"/></fieldset>
            <fieldset>Code:<input type="text" name="code"/></fieldset>
            <input type="submit" name="envoi" value="Envoyer"/>
        </form>
    EOD;
    if (isset($_GET['id'])) {
      printf($form, $_GET['id']);
    } else {
      echo "<h1>Passez par le tableau des pays</h1>\n";
    }
  } else {
    $dbh = new PDO($dsn, $user, $pwd);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_GET["id"] ?? 1;
    $req = sprintf("UPDATE pays SET nom=%s , code=%s WHERE id=%d", $dbh->quote($_GET['nom']), $dbh->quote($_GET['code']), $id);
    $stmt = $dbh->query($req);
    echo '<a href="http://localhost/php/Projet/lire_images.php">ci revoyez le mis à jour</a>';
    $res = $stmt->fetch();
  }

  // print_r($res);
} catch (PDOException $myexep) {
  die(sprintf('<p class="error">la connexion à la base de données à été refusée <em>%s</em></p>' .
    "\n", htmlspecialchars($myexep->getMessage())));
}
?>
</body>
</html>