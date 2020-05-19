<?php
    if(!(isset($_SESSION['perso']))) {
        header('Location: index.php');
    }
?>