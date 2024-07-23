<?php
require("conn.php");
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Add Products</title>
</head>

<body>
    <div class="container bg-dark text-light p-3 rounded my-4">
        <div class="d-flex align-items-center justify-content-between px-3">
            <a href="index.php" class="text-white text-decoration-none">
                <h2> Add Products</h2>
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">
                Add Products
            </button>

        </div>
    </div>

    <div class="container mt-5 p-0">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM `products`";
                $result = mysqli_query($conn, $query);
                $i = 1;
                $fetch_src = FETCH_SRC;
                while ($fetch = mysqli_fetch_assoc($result)) {
                    echo <<<products
                        <tr class="align-middle">
                            <th scope="row">$i</th>
                            <td><img src="$fetch_src$fetch[img]" width="100px"></td>
                            <td>$fetch[name]</td>
                            <td>$fetch[price]</td>
                            <td>
                            <a href="index.php?edit=$fetch[id]" data-bs-toggle="modal" data-bs-target="#editproduct"
                            class="btn btn-warning me-2"><i class="bi bi-pencil-square"></i></a>
                            <button onclick="confirm_rem($fetch[id])" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            <td>
                            
                        </tr>
                        products;
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <Script>
        function confirm_rem(id) {
            if (confirm("Are you Sure,you want to delete this item?")) {
                window.location.href = "crud.php?rem=" + id;
            }
        }
    </Script>


    <!-- Modal -->
    <div class="modal fade" id="addproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Products</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" name="name" Required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Price</span>
                            <input type="price" class="form-control" name="price" min="1" Required>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Upload</label>
                        <input type="file" class="form-control" name="img" accept=".jpg, .png, .svg" Required>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="addproduct">Add</button>
                    </div>
                </div>
            </form>

        </div>
    </div>




    <div class="modal fade" id="editproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="GET" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Products</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" name="name" id="editname" Required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Price</span>
                            <input type="number" class="form-control" name="price" id="editprice" min="1" Required>
                        </div>
                    </div>
                    <img src="" id="editimg" width="100%" class="mb-3"><br>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Upload</label>
                        <input type="file" class="form-control" name="img" accept=".jpg, .png, .svg">
                        <input type="hidden" name="editpid" id="editpid">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="editproduct" id="edit">Edit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

<?php

if(isset($_GET['edit']) && $_GET['edit']>0){

    $editpid = mysqli_real_escape_string($conn, $_GET['edit']);
    $query = "SELECT * FROM `products` WHERE `id`='$editpid'";

    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);
    echo "
    <script>
    var editproduct = new bootstrap.Modal(document.getElementById('editproduct'), {
        keyboard: false
      });
    document.querySelector('#editname').value ='$fetch[name]';
    document.querySelector('#editprice').value= '$fetch[price]';
    document.querySelector('#editimg').src='$fetch_src.$fetch[img]';
    document.querySelector('#editpid').value= '$_GET[edit]';
    editproduct.show();
    </script>
    ";
}

?>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>