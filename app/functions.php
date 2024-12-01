<?php 
/**
 * @param array $files
 * @param string $path
 * @return string 
 */

function move(array $files , string $path = "media/"){
    $temp_name = $files["tmp_name"];
    $file_name = $files["name"];

    $file_array = explode(".",$file_name);
    $file_extension = end($file_array);

    $unique_name = time() . "_". rand(10000,99999)."_". str_shuffle("1234567890").".".$file_extension;

    move_uploaded_file($temp_name,$path . $unique_name);
    return $unique_name;
}


function createAlert (string $message , string $type = "danger"){
    return "<div class='alert alert-$type'>$message</div>";
}


function setMessage($key,$msg){
    setcookie($key,$msg,time()+2);
}

function getMessage($key,$type = "danger"){
    if (isset($_COOKIE[$key])) {
        $message =$_COOKIE[$key];
        echo "<div class='alert d-flex justify-content-between alert-$type'>$message <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }else{
        return "";
    }
}