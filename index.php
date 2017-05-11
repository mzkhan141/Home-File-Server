<!DOCTYPE html>
<?php
  session_start();
  define("HOST","127.0.0.1");
  define("USER","root");
  define("PASS","");
  define("DATABASE","HomeServer");
  function prepare_dir($dirnam) {
	  $read = fopen("Zaid_Khan/index.php","r");
	  $write = fopen($dirnam."/index.php","w");
	  while(!feof($read)) {
		  $data = fread($read,1024);
		  $data = str_replace("Zaid_Khan",$dirnam,$data);
		  fwrite($write,$data);
	  }
	  fclose($read);
	  fclose($write);
  }
?>
<html>
    <head>
	    <title>ZK</title>
	    <meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="zk.css">
	</head>
	<body>
	    <?php
		  if(!(isset($_SESSION['login']) && $_SESSION['login'] == 1)) {
			  if(isset($_POST['login'])) {
				  $uname = $_POST['uname'];
				  $pwd = $_POST['pass'];
				  $db_Handle = mysqli_connect(HOST,USER,PASS,DATABASE);
				  if($db_Handle) {
					  $uname = str_replace('\'','',$uname);
					  $pwd = str_replace('\'','',$pwd);
					  $SQL = "SELECT * FROM users where Username='".$uname."' and Password='".$pwd."'";
					  $result = mysqli_query($db_Handle,$SQL);
					  if($result) {
						  $row = mysqli_fetch_assoc($result);
						  if(count($row) >= 1) {
							  $_SESSION['login'] = 1;
							  $_SESSION['name'] = $row['Name'];
							  $_SESSION['DF'] = $row['DataFolder'];
							  $df = $row['DataFolder'];
							  $addr = $_SERVER['HTTP_HOST'];
							  header("Location: ".$df,true);
							  exit();
						  }
						  else {
							  echo "<script type='text/javascript'> alert('Invalid Credentials'); </script>";
						  }
					  }
					  else {
						  echo "<script type='text/javascript'> alert('Some Error occured while trying to log you in!'); </script>";
					  }
				  }
				  else {
					  echo "<script type='text/javascript'> alert('Some Error occured while connecting to the database!'); </script>";
				  }
			  }
			  if(isset($_POST['signup'])) {
				  $name = $_POST['name'];
				  $uname = $_POST['uname'];
				  $pwd = $_POST['pass'];
				  $name = str_replace('\'','',$name);
				  $uname = str_replace('\'','',$uname);
				  $pwd = str_replace('\'','',$pwd);
				  if(strlen($name) >= 4 && strlen($name) <= 50) {
					  if(strlen($uname) >= 4 && strlen($uname) <= 20) {
						  if(strlen($pwd) >= 6 && strlen($pwd) <= 40) {
							  $db_handle = mysqli_connect(HOST,USER,PASS,DATABASE);
							  if($db_handle) {
								  $SQL = "SELECT * FROM users WHERE Username='".$uname."'";
								  $result = mysqli_query($db_handle,$SQL);
								  if($result) {
									  $row = mysqli_fetch_assoc($result);
									  if(count($row) == 0) {
										  $SQL = "INSERT INTO users (Name,Username,Password,DataFolder) VALUES ('".$name."','".$uname."','".$pwd."','/".str_replace(' ','_',$name)."')";
										  $result = mysqli_query($db_handle,$SQL);
										  $_SESSION['login'] = 1;
										  $_SESSION['name'] = $name;
										  $_SESSION['DF'] = "/".str_replace(' ','_',$name);
										  mkdir(str_replace(' ','_',$name));
										  prepare_dir(str_replace(' ','_',$name));
										  $addr = $_SERVER['HTTP_HOST'];
										  header("Location: ".str_replace(' ','_',$name),true);
                                          exit();										  
										  }
									  else {
										  "<script type='text/javascript'> alert('Username already taken!'); </script>";
									  }
								  }
								  else {
									  "<script type='text/javascript'> alert('Some Error Occured while querying the database!'); </script>";
								  }
							  }
							  else {
								  "<script type='text/javascript'> alert('Some Error occured while connecting to the database!'); </script>";
							  }
						  }
						  else {
							  "<script type='text/javascript'> alert('Password must be between 6 to 40 charecters!'); </script>";
						  }
					  }
					  else {
						  "<script type='text/javascript'> alert('Username should be between 4 to 20 charecters'); </script>";
					  }
				  }
				  else {
					  "<script type='text/javascript'> alert('Name should be between 4 to 50 charecters!'); </script>";
				  }
			  }
	    ?>
		      <div style="padding-left: 35%; padding-right: 35%; padding-top: 10%;">
			  <div class="zk-card-24">
			      <div style="border: 5px solid #e699ff; background-color: gray; color: #ffffff;">
				  <?php if(isset($_GET['task'])) { 
				            if($_GET['task'] == "signin") {
				  ?>
				  <a href="/"><img src="back.png"/></a>
				  <h3 style="padding-top: 10px;"><center>Log In!</center></h3><br />
				  <form name="signin" class="zk-form zk-col-s6" method="post" action="">
				      <span>Username :</span>
					  <input name="uname" class="zk-input" type="text" placeholder="Username" maxlength="20" style="padding: 10px; width: 100%;" required /><br />
					  <span>Password :</span>
					  <input name="pass" class="zk-input" type="password" placeholder="Password" maxlength="40" style="padding: 10px; width: 100%;" required /><br />
					  <input name="login" type="submit" class="btn" value="Log In" style="background-color: cyan; width: 70px; height: 35px; border-radius: 40%;" />
				  </form>
							<?php }
							elseif($_GET['task'] == "signup") { ?>
							<a href="/"><img src="back.png"/></a>
				  <h3 style="padding-top: 10px;"><center>Sign Up!</center></h3><br />
				  <form name="signup" class="zk-form zk-col-s6" method="post" action="">
				      <span>Name :</span>
					  <input name="name" class="zk-input" type="text" placeholder="Name" maxlength="50" style="padding: 10px; width: 100%;" required /><br />
				      <span>Username :</span>
					  <input name="uname" class="zk-input" type="text" placeholder="Username" maxlength="20" style="padding: 10px; width: 100%;" required /><br />
					  <span>Password :</span>
					  <input name="pass" class="zk-input" type="password" placeholder="Password" maxlength="40" style="padding: 10px; width: 100%;" required /><br />
					  <input name="signup" type="submit" class="btn" value="Sign Up" style="background-color: cyan; width: 70px; height: 35px; border-radius: 40%;" />
				  </form>	
							<?php }
				  }
				    else { ?>
						<br /><br /><center><a href="?task=signin">Sign In!</center><br /><br />
						<center><a href="?task=signup">Sign Up!</center><br /><br />
					<?php }
				  ?>
			  </div></div></div>
		<?php  }
		  else {
			  $df = $_SESSION['DF'];
			  $addr = $_SERVER['HTTP_HOST'];
			  header("Location : ".$df,true);
		  }
		?>
	</body>
</html>