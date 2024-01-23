<?php

require 'function.php';

if(isset($_SESSION['login'])){
    //yaudah
}else{
    header('location:login.php');
};

?>