<?php
session_start();
setcookie(session_name(), '', time() - 3600, '/');
session_destroy();
header('Location: /index.php');
exit();