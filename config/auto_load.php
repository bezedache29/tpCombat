<?php
    function chargerClass($class) {
        include($class . '.php');
    }
    spl_autoload_register('chargerClass');
?>