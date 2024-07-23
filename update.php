<?php
  
// Just Image Upload Practice


if(isset($_FILES['img'])){
    $file_name = $_FILES['img']['name'];
    $file_type = $_FILES['img']['type'];
    $file_tmp = $_FILES['img']['tmp_name'];
    $file_size = $_FILES['img']['size'];

    move_uploaded_file($file_tmp, "imag-upload/". $file_name);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="img" id="">
        <button type="submit">Submit</button>
    </form>
</body>
</html>