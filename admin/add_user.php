<?php
session_start();
require("../config/config.php");

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

if($_SESSION["role"] != 1) {
  header("Location:login.php");
}

include "header.php";

if($_POST) {
  // echo strlen($_POST["password"]);exit();
  if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]) || strlen($_POST['password']) < 4) {
    if(empty($_POST["name"])) {
      $nameError = 'name cannot be empty';
    }
    if(empty($_POST["email"])) {
      $emailError = "email cannot be empty";
    }

    if(empty($_POST["password"])) {
      $passwordError = "password cannot be empty";
    }
    
    if(strlen($_POST['password']) < 4){
      $passwordError = "Password should be 4 characters at least";
    } 
  }else{
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if(empty($_POST["role"])) {
      $role = 0;
    } else {
      $role = 1;
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
          <div class="card-body w-50 mx-auto">
            <form action="" method="post" enctype="multipart/form-data">

              <div class="form-group">
                <label for="name">Username</label><span class="text-danger ml-3"><?php echo empty($nameError) ? '': "*".$nameError; ?></span>
                <input type="text" name="name" class="form-control">
                </div>

              <div class="form-group">
                <label for="email">email</label><span class="text-danger ml-3"><?php echo empty($emailError) ? '': "*".$emailError; ?></span>
                <input type="email" name="email" class="form-control">
              </div>

              <div class="form-group">
                <label for="password">password</label><span class="text-danger ml-3"><?php echo empty($passwordError) ? '': "*".$passwordError; ?></span>
                <input type="password" name="password" class="form-control">
              </div>

              <div class="form-group form-check">
                <input type="checkbox" name="role" value="1" class="form-check-input" checked>
                <label for="role">Permission for Admin</label>
              </div>

              <button type="submit" class="btn btn-primary">Add User</button>
              <button class="btn"><a href="users.php" class="btn btn-warning">Back</a></button>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<aside class="control-sidebar control-sidebar-dark">
<div class="p-3">
    <h5>Title</h5>
    <p>Sidebar content</p>
</div>
</aside>
<?php
include "footer.php";
?>
