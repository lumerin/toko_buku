<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['akses']);
session_destroy();
echo "<script>alert('Logout Successfull');document.location.href='../index.php'</script>";
?>