<?php
$db = mysqli_connect('127.0.0.1', 'root', '', '#dbname go here');
  if (mysqli_connect_errno()) {
    echo 'Database connection failed with errors: '  .mysqli_connect_error();
    die();

  }


 $preview = ((isset($_POST['preview']))?sanitize($_POST['preview']):'');
 $title = ((isset($_POST['title']))?sanitize($_POST['title']):'');
  if (isset($_POST['upload'])) {


      $file = $_FILES['file']['name'];
      $file_loc = $_FILES ['file']['tmp_name'];
      $file_type = $_FILES['file']['type'];
      $file_size = $_FILES['file']['size'];
      $fileExt = explode('.', $file);
      $folder = "../uploads/";
      $new_file_name = strtolower($file);
      $final_file = str_replace('', '-',$new_file_name);
      $allowed = array('odt','pdf','doc','docx');
        $required = array('preview','title');
        foreach($required as $field){
          if ($_POST[$field] == ''){
            $_SESSION['error_flash']= 'All Fields are required';

          }
        }
        
      if (move_uploaded_file($file_loc, $folder.$final_file)) {
        $sqlquery = $db->query("INSERT INTO projects (name, file, type, size, preview, title, downloads)
         VALUES ('$file', '$final_file', '$file_type','$file_size', '$preview', '$title', 0 ) ");
        if ($sqlquery) {
          $_SESSION['success_flash']= 'File Uploaded Successfuly ';
          header("Location: viewproject.php?success");
        }else{
          $_SESSION['error_flash']= 'File Upload failed';
          header("Location: add_project.php?failed");

        }
      }


  }

?>
<form class="" action="add_project.php?" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="form-group col-md-6">
      <label for="title">Title<span class="text-danger">*</span>:</label>
      <input type="text" name="title" value="" class="form-control">
    </div>
  <div class="form-group col-md-6">
    <label for="preview">Preview<span class="text-danger">*</span>:</label><br>
    <textarea name="preview" id="preview" rows="6"  class="form-control" >

    </textarea>
  </div>
  <div class="form-group col-md-6">
    <label for="file">File:</label><br>
    <input type="file" name="file" value="" class="form-control">
  </div>
  <div class="form-group pull-right">
    <a href="viewproject.php" class="btn btn-secondary">Cancel</a>
    <input type="submit" name="upload" value="Add Project" class="btn btn-success pull-right "><div class="clearfix"></div>
  </div>
</div>
</form><!--end of form -->



