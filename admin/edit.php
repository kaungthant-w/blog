<?php
session_start();
require("../config/config.php");
require("../config/common.php");

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

if($_POST) {

  if(empty($_POST["title"]) || empty($_POST["content"] )) {
    if(empty($_POST["title"])) {
      $titleError = 'Title cannot be empty';
    }
    if(empty($_POST["content"])) {
      $contentError = "Content cannot be empty";
    }
  } else {
      
    $id = $_POST["id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    
    if($_FILES['image']['name'] != null) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file, PATHINFO_EXTENSION);

      if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be png, jpg, jpeg.')</script>";
      }else{
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
}

$stmt = $pdo -> prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt -> execute();
$result = $stmt -> fetchAll();
?>

<?php include "header.php"; ?>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form action="" method="post" enctype="multipart/form-data">
              <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                <div class="form-group">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                  <label for="title">Title</label> <span class="text-danger ml-3"><?php echo empty($titleError) ? '': "*".$titleError; ?></span>
                  <input type="text" name="title" id="title" class="form-control" value="<?php echo escape($result[0]["title"]); ?>">
                </div>

                <div class="form-group">
                  <label for="content">Content</label><span class="text-danger ml-3"><?php echo empty($contentError) ? '': "*".$contentError; ?></span>
                  <textarea name="content" class="form-control" id="content" cols="10" rows="10"><?php echo escape($result[0]["content"]); ?></textarea>
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