<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichier</title>
    <style>
        svg,img {
            width : 150px;
            max-height: 3rem;
        }
    </style>
</head>
<body>
<?php
require_once('tp_mysql.php');
try { 
        $dbh = new PDO($dsn, $user, $pwd);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $res = $dbh->query("SELECT * FROM pays"); 
        echo "<table>\n";
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) { 
           echo '<tr>';
           foreach ($row as $clef => $val) {
                echo "<td>";
              //          $type = ($clef == 'nom') ? 'nom' : 'text';
              //          printf('%d "%s %s'."\n", $clef, $type, $val,);
                if ($clef == 'drapeau') printf('<a href="modifier.php?id=%d"><img src="image.php?id=%d"/></a>',
                                                  $row['id'], $row['id']);
                else echo htmlspecialchars($val);
                echo "</td>";
            } 
            echo "</tr>\n";
        }
        echo "</table>\n";}
        catch(PDOException $myexep) {
        die(sprintf('<p class="error">Erreur SQL : <em>%s</em></p>'.
            "\n", htmlspecialchars($myexep->getMessage())));
    }?>
</body>
</html>