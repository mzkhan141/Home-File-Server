<?php
  session_start();
  session_destroy();
  echo "<script type='text/javascript'> alert('You have Successfully Logged out!'); </script>";
  header("Location: /",true);
  exit();
?>