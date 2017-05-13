<?php
  session_start();
  function get_size($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    //$bytes /= pow(1024, $pow);
    $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
  } 
  if(isset($_SESSION['login']) && $_SESSION['login'] == 1) {
	  if($_SESSION['DF'] == "/Zaid_Khan") {
?>
<html>
    <header>
	    <title><?php echo $_SESSION['name']; ?></title>
		<link rel="stylesheet" href="../zk.css" />
	</header>
	<body>
	    <div style="text-align: right; padding= 5%;"><a href="../logout/">Sign Out</a>!</strong></div>
	    <h2 class="zk-container">&nbsp;&nbsp;<strong>Files in the Directory...</strong></h2>
		<div class="zk-container" style="text-align: right"><a href="../upload/">Upload</a>!</div>
		<div class="zk-container">
		    <table class=" zk-table zk-striped">
			    <thead>
				     <tr>
					     <th style="width: 10%">S.No.</th>
						 <th style="width: 50%">File Name</th>
						 <th style="width: 20%">File Size</th>
						 <th style="width: 10%"></th>
						 <th style="width: 10%"></th>
					 </tr>
			    </thead>
				<tbody>
<?php	  
          $df = $_SESSION['DF'];
		  $files = scandir('.');
		  $files = array_diff($files,array('.','..'));
		  $i = 1;
		  foreach($files as $file) {
			  if(strpos($file,'php') !== strlen($file)-3) {
				  
				  echo "<tr>";
				  echo "<td style='width: 10%'>$i</td>";
				  echo "<td style='width: 50%'>$file</td>";
				  echo "<td style='width: 20%; text-align: right;'>".get_size(filesize($file))."</td>";
				  echo "<td style='width: 10%'><a href='$file'>Open</a></td>";
				  echo "<td style='width: 10%'><a href='../download/?zk=".$file."'>Download</a></td>";
                  echo "</tr>";
                  $i += 1;				  
			  }
		  }
?>
                <tbody>
            </table>
		</div>
<?php
	  }
	  else {
		  $df = $_SESSION['DF'];
		  header("Location: ".$df,true);
	  }
  }
  else{
	  header("Location: /",true);
  }
?>
    </body>
</html>