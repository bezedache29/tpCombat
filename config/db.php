<?php
    $db = new PDO('mysql:host=localhost;dbname=personnages;charset=utf8', 'root', '');
    $manager = new PersonnagesManager($db);
    
?>
