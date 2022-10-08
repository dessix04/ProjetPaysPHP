<?php
header('Content-type: image/svg+xml'); 
require_once('tp_mysql.php');
try { 
        $dbh = new PDO($dsn, $user, $pwd);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = $_GET["id"] ?? 1;
        $res = sprintf("SELECT drapeau FROM pays WHERE id=%d" , $id);
        $stmt = $dbh->query($res);
        $img = $stmt->fetchColumn();
        if (empty($img)) {
          echo <<<EOI
          <svg xmlns="http://www.w3.org/2000/svg" width="500" height="500">';
          <rect width="500" height="500"  fill="orange"/> 
          <text x="20" y="150" font-family="Sans-serif" font-size="25">Pas de drapeau</text>
          </svg>
          EOI;
        } else {
            echo $img;
        }
} catch(PDOException $myexep) {
        die(sprintf('<p class="error">Erreur SQL : <em>%s</em></p>'.
            "\n", htmlspecialchars($myexep->getMessage())));
}


