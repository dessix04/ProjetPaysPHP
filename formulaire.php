<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <style>
     form {background-color:#CFC;}
     fieldset {width:20em;text-align:right}
      svg {
            width : 150px;
            max-height: 3rem;
        }
    </style>
</head>
<body>
<?php
require_once("tp_mysql.php");
try {
  if (!isset($_REQUEST['id'])){
    echo <<<EOD
        <form action="#" method="get">
            <fieldset>ID<input type="text" name="id"/></fieldset>
            <fieldset>Nom<input type="text" name="nom"/></fieldset>
            <fieldset>Code<input type="text" name="code"/></fieldset>
            <fieldset>Drapeau<input type="text" name="drapeau"/></fieldset>
            <input type="submit" value="Envoyer"/>
        </form>
  EOD;
  }else {
  $dbh = new PDO($dsn, $user, $pwd);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $req = sprintf("SELECT * FROM pays WHERE id = %d or nom = %s or code = %s", $_GET['id'], $dbh->quote($_GET['nom']), $dbh->quote($_GET['code']));
  $stmt = $dbh->query($req);
  $res = $stmt->fetch()?>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Code</th>
        <th>Drapeau</th>
    </tr>
    <tr> 
      <td><?= $res['id'] ?? '' ?></td>
      <td><?= $res['nom'] ?? '' ?></td>
      <td><?= $res['code'] ?? '' ?></td>
      <td><?= $res['drapeau']?? '' ?></td>
    </tr>
  </table>
  <a href="http://localhost/php/Projet/formulaire.php">revenir sur le formulaire</a>
  <?php
  ;}
  // print_r($res);
} catch (PDOException $myexep) {
  die(sprintf('<p class="error">la connexion à la base de données à été refusée <em>%s</em></p>' .
    "\n", htmlspecialchars($myexep->getMessage())));
}
?>
</body>
</html>