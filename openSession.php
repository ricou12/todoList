<?php
function newCreateSession($id){
    session_start();
    $_SESSION['user'] = $id;
}