<?php
    session_start();
    require("../config/config.php");

    if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
    header("Location:login.php");
    }

    if($_SESSION["role"] != 1) {
      header("Location:login.php");
    }
<<<<<<< HEAD
    
=======
>>>>>>> 0c30c30db8d3326e452cb613a9b1ccc5986c093b

    if($_POST) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];

        if(empty($_POST["role"])) {
          $role = 0;
        } else {
          $role = 1;
        }

        $stmt = $pdo -> prepare("SELECT * FROM users WHERE email = :email AND id != :id");

        $stmt -> execute(array(":email"=> $email, ':id' => $id));
        $user = $stmt -> fetch(PDO::FETCH_ASSOC);
        
        if($user){

            echo "<script>alert('Email duplicated')</script>";
            
        } else {
          $stmt = $pdo -> prepare("UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$id'");
          $result = $stmt -> execute();
          if($result) {
              echo "<script>alert('Successfully Updated.');window.location.href='users.php';</script>";
          }
        }
        
      }

      $stmt = $pdo -> prepare("SELECT * FROM users WHERE id=".$_GET['id']);
      $stmt -> execute();

      $result = $stmt -> fetchAll();

?>


<?php include "header.php"; ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
<<<<<<< HEAD
                  <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                          <label for="name">name</label>
                          <input type="text" name="name" id="name" class="form-control" value="<?php echo $result[0]["name"]; ?>">
                      </div>

                      <div class="form-group">
                          <label for="email">email</label>
                          <input type="email" name="email" id="email" class="form-control" value="<?php echo $result[0]['email']; ?>">
                      </div>

                      <div class="form-group form-check">
                          <input type="checkbox" name="role" class="form-check-input" id="role" value="1" <?php echo $result[0]["role"] ? "checked" : ""; ?>>
                          <label for="role">Permission for admin</label>
                      </div>

                      <div class="form-group">
                          <input type="submit" class="btn btn-success" name="" value="Submit">
                          <a href="users.php" class="btn btn-warning">Back</a>
                      </div>
                  </form>
=======
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                      <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                      <label for="name">name</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php echo $result[0]["name"]; ?>">
                  </div>

                  <div class="form-group">
                      <label for="email">email</label>
                      <input type="email" name="email" id="email" class="form-control" value="<?php echo $result[0]['email']; ?>">
                  </div>

                  <div class="form-group form-check">
                      <input type="checkbox" name="role" class="form-check-input" id="role" value="1">
                      <label for="role">Permission for admin</label>
                  </div>

                  <div class="form-group">
                      <input type="submit" class="btn btn-success" name="" value="Submit">
                      <a href="users.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
>>>>>>> 0c30c30db8d3326e452cb613a9b1ccc5986c093b
                
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
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