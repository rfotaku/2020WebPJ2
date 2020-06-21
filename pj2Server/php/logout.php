<?php
session_start();
function loginOut()
{
    unset($_SESSION['username']);
}

loginOut();
echo "<script>window.location.href='../../pj2Web/html/login.html'</script>";
?>