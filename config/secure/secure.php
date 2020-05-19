<?php
    if(!(isset($_SESSION['id_client']))) {
        header('Location: index.php');
    }
?>