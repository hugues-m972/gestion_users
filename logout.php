<?php
session_start();
session_destroy();
header('Location: connecter.php');
exit;
?>
