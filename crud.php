<?php

require("conn.php");

function image_upload($img){
    $tmp_loc = $img['tmp_name'];
    $new_name = random_int(1111,9999).$img['name'];
    $new_loc = UPLOAD_SRC.$new_name;
    if(!move_uploaded_file($tmp_loc, $new_loc)){
        header('Location: index.php?alert=img_upload');
        exit;
    }else{
        return  $new_name;
    }  
}

function image_remove($img){
    if(!unlink(UPLOAD_SRC.$img)){
        header('location: index.php?alert=img_rem_fail');
        exit;
    }
}

if(isset($_POST['addproduct'])){
   foreach($_POST as $key => $Value)
   {
    $_POST [$key] = mysqli_real_escape_string($conn,$Value);
   }
   
   
    $imgpath = image_upload($_FILES['img']);

    $query = "INSERT INTO `products`(`name`, `price`, `img`) 
    VALUES ('$_POST[name]','$_POST[price]','$imgpath')";

    if(mysqli_query($conn,$query)){
        header("location: index.php?success=addedd");
    }else{
        header("location: index.php?alert=add_Failed");
    }

    
}


if(isset($_GET['rem']) && $_GET['rem']>0)
{
    $query = "SELECT * FROM `products` where `id`='$_GET[rem]'";
    $result = mysqli_query($conn,$query);   
    $fetch = mysqli_fetch_assoc($result);

    image_remove($fetch['img']);

    $query = "DELETE FROM `products` WHERE `id`='$_GET[rem]'";
    if(mysqli_query($conn,$query))
    {
        header("location: index.php?success=removed");
    }else{
        header("location: index.php?alert=removed_failed");
    }
}


if(isset($_POST["edit"])){
    foreach($_POST as $key => $Value)
   {
    $_POST [$key] = mysqli_real_escape_string($conn,$Value);
   }

   if(file_exists($_FILES['img']['tmp_name']) || is_uploaded_file($_FILES['img']['tmp_name']))
   {
    $query = "SELECT * FROM `products` where `id`='$_POST[editpid]'";
    $result = mysqli_query($conn,$query);   
    $fetch = mysqli_fetch_array($result);

    image_remove($fetch["img"]);
    $imgpath = image_upload($_FILES('img'));

    $update = "UPDATE `products` SET `name`='$_POST[name]',`price`='$_POST[price]'',`img`='$imgpath' WHERE `id`= '$_POST[editpid]'";

   }else
   {
    $update = "UPDATE `products` SET `name`='$_POST[name]',`price`='$_POST[price]', WHERE `id`= '$_POST[editpid]'";
   }
   if(mysqli_query($conn,$update)){
    header("location: index.php?success=updated");
   }else{
    header("location: index.php?success=updated_failed");
   }
}

?>