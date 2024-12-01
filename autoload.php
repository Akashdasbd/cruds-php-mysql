<?php 
if (file_exists(__DIR__."/config/connectDB.php")) {
    require_once __DIR__."/config/connectDB.php";
};

if(file_exists(__DIR__."/app/functions.php")){
    require_once __DIR__."/app/functions.php";
}