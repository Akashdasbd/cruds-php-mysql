<?php
if (file_exists(__DIR__."/autoload.php")) {
    require_once __DIR__."/autoload.php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

if(isset($_GET["silgeId"])){
    $silgeId = ($_GET["silgeId"]);
    $sql = "SELECT * FROM dev WHERE id = '$silgeId'";
    $steament = connect()->prepare($sql);
    $steament->execute();
    $data = $steament->fetch(PDO::FETCH_OBJ);
    

    if ($silgeId == $data->id) {
        ?>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6 border-1 shadow rounded-2 p-4 d-flex justify-content-center text-center">
               
                    <div>
                    <a class=" btn btn-primary" href="./index.php">Back</a>
                    <hr>
                    <img height="100px" width="100px" class=" rounded-circle" src="./media/devs/<?php echo $data->image?>" alt="">
                    <h3  class=" text-uppercase my-3">Name: <?php echo $data->name?></h3>
                    <h4  class=" text-uppercase my-3">Email: <?php echo $data->email?></h4>
                    <h4  class=" text-uppercase my-3">Phone: <?php echo $data->phone?></h4>
                    <h4  class=" text-uppercase my-3">Gender: <?php echo $data->gender?></h4>
                    <h4  class=" text-uppercase my-3">Location: <?php echo $data->Location?></h4>
                    <h4  class=" text-uppercase my-3">Age: <?php echo $data->age?></h4>
                    <h4  class=" text-uppercase my-3">Skill: <?php echo $data->skill?></h4>
                    <?php
                    $joinDate = $data->createdAt;
                    $joinArr = explode(" ",$joinDate);
                    ?>
                    <h4  class=" text-uppercase my-3">Join Date: <?php echo $joinArr[0]?></h4>
                    </div>  

                </div>
            </div>
        </div>
        <?php
    }else{
        header("location:index.php");
    }
}else{
    header("location:index.php");
}



?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>