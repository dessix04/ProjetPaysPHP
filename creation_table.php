<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Projet PHP</title>
  <style>
  </style>
</head>
<body><h1>Projet PHP</h1>
<?php
    require_once('tp_mysql.php');
    try {
      $fp = fopen('/home/stag/Téléchargements/pays.csv','r');
      $filename ='/var/www/html/php/Projet/flags';
      $i=0; 
      $dbh = new PDO($dsn, $user, $pwd);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->exec("DROP TABLE IF EXISTS pays");     
      $dbh->exec("CREATE TABLE IF NOT EXISTS pays (id INT AUTO_INCREMENT PRIMARY KEY,
                                     nom VARCHAR(250),
                                     code VARCHAR(240),
                                     drapeau LONGBLOB)");
      while ($ligne = fgets($fp, 2000)) {
        $vals = explode(',', trim($ligne));
        if (is_numeric($vals[0]) &&
           preg_match('#^[[:alpha:]]{1,20}$#', $vals[1]) &&
           preg_match('#^[[:alpha:]]{1,4}$#', $vals[2])) {
            $drapFic = $filename.'/'.$vals[2].'.svg';
            if (file_exists($drapFic)) {
              $drap = file_get_contents($drapFic);
            } else {
              $drap = '';
            }
            $req = sprintf("INSERT INTO pays (id, nom, code, drapeau) VALUES (%d, %s, %s, %s)",
                           $vals[0], $dbh->quote($vals[1]), $dbh->quote($vals[2]), $dbh->quote($drap));
            echo htmlspecialchars($vals[1])." inséré<br/>\n";
            flush();
            $dbh->exec($req);
        }
      }
      fclose($fp);
    } catch (PDOException $myexep) {
      die(sprintf('<p class="error">Erreur SQL : <em>%s</em></p>'.
		  "\n", htmlspecialchars($myexep->getMessage())));
    }
    ?>
    </body>
    </html>