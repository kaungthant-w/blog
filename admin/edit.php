<?php
session_start();
require("../config/config.php");

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

if($_POST) {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    
    if($_FILES['image']['name'] != null) {
        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file, PATHINFO_EXTENSION);

        if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
            echo "<script>alert('Image must be png, jpg, jpeg.')</script>";
        } else {
            $title = $_POST["title"];
            $content = $_POST["content"];
            $image = $_FILES["image"]["name"];

            move_uploaded_file($_FILES['image']['tmp_name'], $file);

            $stmt = $pdo -> prepare("UPDATE posts SET title='$title', content='$content', image='$image' WHERE id='$id'");
            $result = $stmt -> execute();

            if($result) {
                echo "<script>alert('Successfully Updated.');window.location.href='index.php';</script>";
            }
        }

    } else {

        $stmt = $pdo -> prepare("UPDATE posts SET title='$title', content='$content' WHERE id='$id'");
        $result = $stmt -> execute();

        if($result) {
            echo "<script>alert('Successfully Updated.');window.location.href='index.php';</script>";
        }
        
    }
}

$stmt = $pdo -> prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
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
                  <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                          <label for="title">Title</label>
                          <input type="text" name="title" id="title" class="form-control" value="<?php echo $result[0]["title"]; ?>">
                      </div>

                      <div class="form-group">
                          <label for="content">Content</label>
                          <textarea name="content" class="form-control" id="content" cols="10" rows="10"><?php echo $result[0]["content"]; ?></textarea>
                      </div>

                      <div class="form-group mb-3">
                          <label class="d-block" for="">Image</label>
                          <img src="images/<?php echo $result[0]['image'] ?>" class="img-thumbnail w-25 h-25" alt="">
                          <input type="file" name="image" value="" class="form-control" value="">
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