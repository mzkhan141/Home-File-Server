<?php
session_start();
if(isset($_POST['btn-upload']))
{
	$pic = $_FILES['pic']['name'];
    $pic_loc = $_FILES['pic']['tmp_name'];
	$folder="../".$_SESSION['DF']."\\";
	if(move_uploaded_file($pic_loc,$folder.$pic))
	{
		?><script>alert('successfully uploaded');</script><?php
	}
	else
	{
		?><script>alert('error while uploading file');</script><?php
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<title>Upload</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="pic" />
<button type="submit" name="btn-upload">upload</button>
</form>
</body>
</html>