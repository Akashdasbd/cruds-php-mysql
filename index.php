<?php
if (file_exists(__DIR__ . "/autoload.php")) {
    require_once __DIR__ . "/autoload.php";
}

?>
<?php
$sql = "SELECT Location FROM dev";
$steatment = connect()->prepare($sql);
$steatment->execute();
$data = $steatment->fetchAll(PDO::FETCH_OBJ);

$locationLists = [];
foreach ($data as $item) {
    array_push($locationLists, $item->Location);
}

$locationLists = array_unique($locationLists);

$sql = "SELECT skill FROM dev";
$steatment = connect()->prepare($sql);
$steatment->execute();
$Skill_data = $steatment->fetchAll(PDO::FETCH_OBJ);
$skillLists = [];
foreach ($Skill_data as $item) {
    array_push($skillLists, $item->skill);
}
$skillLists = array_unique($skillLists);


$search_location = null;
$search_Gender = null;
$search_email = null;
$search_name = null;
$search_skill = null;
$search_phone = null;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search_submit"])) {
    $search_location = $_POST["locaton"] ?? "";
    $search_Gender = $_POST["gender"] ?? "";
    $search_email = $_POST["search_email"] ?? "";
    $search_name = $_POST["search_name"] ?? "";
    $search_skill = $_POST["search_skill"] ?? "";
    $search_phone = $_POST["search_phone"] ?? "";
}


if(isset($_GET['trash_Id'])){
    $trash_id = $_GET['trash_Id'];
    $sql = "UPDATE dev SET trash=:trash,status=:status WHERE id = '$trash_id'";
    $statement = connect()->prepare($sql);
    $statement->execute([
        ":trash" => '1',
        ":status" => '0'
    ]);
    setMessage("deletMsg", "Data Trash Successfully");
    header("location:index.php");
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
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="buton">
                    <a class=" btn btn-primary" href="./creat.php">creat new Devs</a>
                    <a class=" btn btn-danger" href="./trash.php">Trash Page</a>
                    </div>
                    
                    <br>
                    <br>
                    <div class="d-flex justify-content-between">
                        <form class=" d-flex gap-4" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                            <div>
                                <label for="">Select Location</label>
                                <select name="locaton" id="">
                                    <option value="">-Location-</option>
                                    <?php foreach ($locationLists as $location): ?>
                                        <option <?php echo $search_location == $location ? 'selected' : '' ?> value="<?php echo $location ?>"><?php echo $location ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="">Select Gender</label>
                                <select name="gender" id="gender">
                                    <option value="">-Gender-</option>
                                    <option value="Male" <?php echo $search_Gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo $search_Gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                            <div>
                                <label for="">Search Email</label>
                                <input value="<?php echo $search_email ?>" type="text" name="search_email" placeholder="<?php echo $search_email ?? 'Search Email'; ?>">
                            </div>
                            <div>
                                <label for="">Search Name</label>
                                <input value="<?php echo $search_name ?>" type="text" name="search_name" placeholder="<?php echo $search_name ?? 'Search Name'; ?>">
                            </div>
                            <div>
                                <label for="">Search Phone</label>
                                <input value="<?php echo $search_phone ?>" type="text" name="search_phone" placeholder="<?php echo $search_phone ?? 'Search Phone'; ?>">
                            </div>
                            <div>
                                <label for="">Select Skill</label>
                                <select name="search_skill" id="">
                                    <option value="">-Skill-</option>
                                    <?php foreach ($skillLists as $skill): ?>
                                        <option <?php echo $search_skill == $skill ? 'selected' : '' ?> value="<?php echo $skill ?>"><?php echo $skill ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button name="search_submit" type="submit">Submit</button>
                        </form>

                    </div>

                    <br>
                    <br>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center ">Our Developers</h5>
                            <br>
                            <br>
                            <?php getMessage("deletMsg") ?>
                            <hr>
                            <table class=" table table-bordered">
                                <thead>
                                    <tr class=" align-items-center align-middle text-center">
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Location</th>
                                        <th>Age</th>
                                        <th>Skil</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "SELECT * FROM dev";
                                    $conditions = [];
                                    $params = [];

                                    $conditions[]="trash = :trashNumbar";
                                    $params[':trashNumbar']='0';
                                    $conditions[]="status= :statusNumbar";
                                    $params[':statusNumbar'] = '1';
                                    // Add conditions dynamically
                                    if (!empty($search_location)) {
                                        $conditions[] = "Location = :location";
                                        $params[':location'] = $search_location;
                                    }
                                    if (!empty($search_Gender)) {
                                        $conditions[] = "Gender = :gender";
                                        $params[':gender'] = $search_Gender;
                                    }

                                    if (!empty($search_email)) {
                                        $conditions[] = "email = :email";
                                        $params[':email'] = $search_email;
                                    }

                                    if (!empty($search_name)) {
                                        $conditions[] = "name = :name";
                                        $params[':name'] = $search_name;
                                    }
                                    if (!empty($search_skill)) {
                                        $conditions[] = "skill = :skill";
                                        $params[':skill'] = $search_skill;
                                    }

                                    if (!empty($search_phone)) {
                                        $conditions[] = "phone = :phone";
                                        $params[':phone'] = $search_phone;
                                    }

                                    // Append conditions to the query
                                    if ($conditions) {
                                        $sql .= " WHERE " . implode(" AND ", $conditions);
                                    }
                                    $steatment = connect()->prepare($sql);
                                    $steatment->execute($params);
                                    $data = $steatment->fetchAll(PDO::FETCH_OBJ);

                                    foreach ($data as $key => $itam):
                                    ?>

                                        <tr class="  align-middle text-center">
                                            <td><?php echo $key + 1 ?></td>
                                            <td><img class=" rounded-bottom-pill  object-fit-cover  photo" src="media/devs/<?php echo $itam->image ?>" alt=""></td>
                                            <td><?php echo $itam->name ?></td>
                                            <td><?php echo $itam->email ?></td> 
                                            <td><?php echo $itam->phone ?></td>
                                            <td><?php echo $itam->gender ?></td>
                                            <td><?php echo $itam->Location ?></td>
                                            <td><?php echo $itam->age ?></td>
                                            <td><?php echo $itam->skill ?></td>

                                            <td>
                                                <a class=" btn btn-sm btn-success" href="#"><i class="fa-solid fa-thumbs-up"></i></a>
                                            </td>
                                            <td>
                                                <a class=" btn btn-sm btn-info" href="single.php?silgeId=<?php echo $itam->id ?>"><i class="fa-solid fa-eye"></i></a>
                                                <a class=" btn btn-sm btn-warning" href="edit.php?edit_id=<?php echo $itam->id ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a class=" btn btn-sm btn-danger" href="index.php?trash_Id=<?php echo $itam->id ?>"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>