<?php 
if (file_exists(__DIR__."/autoload.php")) {
    require_once __DIR__."/autoload.php";
}

if (isset($_GET["edit_id"])) {
    $edit_id = $_GET["edit_id"];
    $sql = "SELECT * FROM dev WHERE id ='$edit_id'";
    $statement = connect()->prepare($sql);
    $statement->execute();
    $singleData = $statement->fetch(PDO::FETCH_OBJ);
    if(!$singleData){
        header("Location:index.php");
    }
}else{
    header("Location:index.php");
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
</head>
<body>

<?php 

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["dev_form_submit"])){
   $name  = $_POST["name"];
   $email = $_POST["email"];
   $phone = $_POST["phone"];
   $gender = $_POST["gender"] ?? "";
   $location = $_POST["location"];
   $age = $_POST["age"];
   $skill = $_POST["skill"];

// get files

$devs_image = $singleData->image;
   if (!empty($_FILES["image"]["name"])) {
   $devs_image =   move([
        "name" =>  $_FILES["image"]["name"],
        "tmp_name" => $_FILES["image"]["tmp_name"],
     ],"media/devs/");

     unlink(__DIR__."/media/devs/".$singleData->image);
   }

  
    $sql = "UPDATE  dev SET name=:name,email=:email,phone=:phone,gender=:gender,location=:location,age=:age,skill=:skill,image=:image WHERE id = '$edit_id'";
    $statement = connect()-> prepare($sql);
    $statement->execute([
        ":name" => $name,
        ":email" => $email,
        ":phone" => $phone,
        ":gender" => $gender,
        ":location" => $location,
        ":age" => $age,
        ":skill" => $skill,
        ":image" => $devs_image
    ]);
    setMessage("deletMsg","Data Updated Successfully");
    header("Location:index.php");
}




?>
    <section>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <a class=" btn btn-primary" href="./index.php">Back</a>
                    <br>
                    <br>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center ">Edit Devs</h5>
                            <hr>
                            <?php echo $msg ?? ""; ?>
                            <form action="<?php echo $_SERVER["PHP_SELF"]?>?edit_id=<?php echo $edit_id?>" method="post" enctype="multipart/form-data">
                                <div class="my-3">
                                    <label for="name">Name</label>
                                    <input type="text" value="<?php echo $singleData->name?>" name="name" class=" form-control">
                                </div>
                                <div class="my-3">
                                    <label for="email">Email</label>
                                    <input type="text" value="<?php echo $singleData->email?>"  name="email" class=" form-control">
                                </div>
                                <div class="my-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" value="<?php echo $singleData->phone?>" name="phone" class=" form-control">
                                </div>
                                <div class="my-3">
                                    <label for="skill">	Skill</label>
                                    <input type="text" value="<?php echo $singleData->skill?>" name="skill" class=" form-control">
                                </div>
                                <div class="my-3">
                                    <label for="location">	Location</label>
                                    <input type="text" value="<?php echo $singleData->Location?>" name="location" class=" form-control">
                                </div>
                                <div class="my-3">
                                    <label for="age">	Age</label>
                                    <input type="text" value="<?php echo $singleData->age?>" name="age" class=" form-control">
                                </div>
                                <div class="my-3">
                                    <img class=" rounded-circle" width="100" height="100" src="media/devs/<?php echo $singleData->image?>" alt="">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" class=" form-control">
                                </div>
                                <div class="my-3">
                                    <label for="age">Gender</label>
                                    <label>
                                        <input  <?php echo $singleData->gender == 'Male' ? 'checked': "";?> value="Male" type="radio" name="gender" id=""> Male
                                    </label>
                                    <label>
                                        <input <?php echo $singleData->gender == 'Female' ? 'checked': "";?> value="Female" type="radio" name="gender" id=""> Female
                                    </label>
                                </div>
                                <div class="my-3">
                                    <button type="submit" name="dev_form_submit" class=" btn btn-primary">Submit</button>
                                    <button type="reset" class=" btn btn-warning">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>