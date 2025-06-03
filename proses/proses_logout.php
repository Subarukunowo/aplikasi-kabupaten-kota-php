
<?php
session_start();
session_destroy();
header('Location: /kabupaten-kota/page/user/login.php');
exit;
?>