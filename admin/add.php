<?php
session_start();
require("../config/config.php");

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

if($_POST) {
    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file, PATHINFO_EXTENSION);

    if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be png, jpg, jpeg.')</script>";
    } else {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $image = $_FILES["image"]["name"];

        move_uploaded_file($_FILES['image']['tmp_name'], $file);

        $stmt = $pdo -> prepare("INSERT INTO posts(title, content, image, author_id)VALUES(:title, :content, :image, :author_id)");

        $result = $stmt -> execute(
            array(':title' => $title, ':content' => $content, ':author_id' => $_SESSION['user_id'], ':image' => $image)
        );

        if($result) {
            echo "<script>alert('Successfully added.')</script>";
        }
    }
}

?>


<?php include "header.php"; ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <?php

              ?>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="add.php" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" name="title" id="title" class="form-control" >
                      </div>

                      <div class="form-group">
                          <label for="content">Content</label>
                          <textarea name="content" class="form-control" id="content" cols="10" rows="10"></textarea>
                      </div>

                      <div class="form-group">
                          <label for="">Image</label>
                          <input type="file" name="image" class="form-control" value="" required>
                      </div>

                      <div class="form-group">
                          <input type="submit" class="btn btn-success" name="" value="Submit">
                          <a href="index.php" class="btn btn-warning">Back</a>
                      </div>
                  </form>
                
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