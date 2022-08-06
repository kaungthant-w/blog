<?php
session_start();
require("../config/config.php");

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

include "header.php";

if($_POST) {

  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  
  if(!empty($_POST["role"])) {
    $role = 1;
  } else {
    $role = 0;
  }
  
  $stmt = $pdo -> prepare("SELECT * FROM users WHERE email = :email");

  $stmt -> bindValue(":email", $email);
  $stmt -> execute();
  $user = $stmt -> fetch(PDO::FETCH_ASSOC);

if($user) {
  echo "<script>alert('Email duplicated!')</script>";
} else {
    $stmt = $pdo -> prepare("INSERT INTO users(name, email, password, role)VALUES(:name, :email, :password, :role)");

    $result = $stmt -> execute(
        array(':name' => $name, ':email' => $email, ':password' => $password, ':role' => $role)
    );

    if($result) {
        echo "<script>alert('Successfully user added.');window.location.href='users.php';</script>";
    }
}
}

?>


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Add User</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body w-50 mx-auto">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group form-check">
                    <input type="checkbox" name="role" value="1" class="form-check-input">
                    <label for="role">Permission for Admin</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                    <button type="users.php" class="btn btn-warning">Back</button>
                </form>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>
</div><!-- /.content -->

  <!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
<div class="p-3">
    <h5>Title</h5>
    <p>Sidebar content</p>
</div>
</aside>
<!-- /.control-sidebar -->
<?php
include "footer.php";
?>
