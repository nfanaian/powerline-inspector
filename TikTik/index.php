<?php
    require_once($_SERVER["DOCUMENT_ROOT"]. "/tiktik/config.php");
    checkMobile();
    header("Location: " . DIR_ROOT . "ticket.php");
?>
