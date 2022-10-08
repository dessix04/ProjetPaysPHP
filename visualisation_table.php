<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Visialisation PHP</title>
  <link rel="stylesheet" href="style.css">
</head>
<body><h1>Projet PHP</h1>
<?php
 require_once('tp_mysql.php');
 try { 
        $dbh = new PDO($dsn, $user, $pwd);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $res = $dbh->query("SELECT * FROM pays"); ?>
    <div class="toto">
      <table>
        <?php while ($row = $res->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <?php foreach ($row as $clef => $val) { ?>
                <td>
                    <?php echo $val ?>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
      </table>
    </div>
  <?php } catch(PDOException $myexep) {
        die(sprintf('<p class="error">Erreur SQL : <em>%s</em></p>'.
            "\n", htmlspecialchars($myexep->getMessage())));
    }?>
 </body>
</html>
