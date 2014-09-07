<?php
$connect=mysqli_connect('localhost', 'root', '', 'books');
       if(!$connect){
           echo 'Грешка в базата данни';
           exit();
       }
       mysqli_query($connect,'SET NAMES utf8');
?>
