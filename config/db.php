<?php
    $db = new PDO('mysql:host=localhost;dbname=personnages;charset=utf8', 'root', '');
    //$db = new PDO('mysql:host=db5000437920.hosting-data.io;dbname=dbs418657;charset=utf8', 'dbu231251', '!Gigi!29');
    $manager = new PersonnagesManager($db);
    
?>