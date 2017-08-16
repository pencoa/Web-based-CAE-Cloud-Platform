<!DOCTYPE html>
<html>
	<?php
		require ("includes/config.php");
		include_once "includes/header.php";
		if ($_SESSION["logged_in"] != "YES") {
			header("Location: login.php");
		}
		
		$id = $_GET['job_id'];
		$sql_select = "SELECT * FROM job WHERE job_id = '".$id."'";
		$result = $dbh->query($sql_select);
		if ($result->fetch()["id_user"] != $_SESSION["id"] ) {
			header("Location: job_management.php");
		}
	?>

	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>

	  	<script>	
		  	function center(event)
		  	{
		  		document.getElementById('x3d_element').runtime.fitAll();
		  	}
			
			function center1(event)
		  	{
		  		document.getElementById('x3d_element_1').runtime.fitAll();
		  	}
	  	</script>
	</head>

	<body>
		<div id="x3d_display">
			
			<h1>3D Display of Model and Mesh</h1><br>
			<div style="padding-left: 5%; padding-right: 5%">	
				<x3d id='x3d_element' class='x3d_element'>
					<div id="instructions">
						<button type="button" onclick="center(event)" class="btn btn-secondary">Center</button>
						<a href="x3d_output/<?php echo $_GET['job_id'];?>.x3d" download><button type="button" class="btn btn-secondary">Download X3D</button></a>
						<a href="stp_uploads/<?php echo $_GET['job_id'];?>.step" download><button type="button" class="btn btn-secondary">Download step</button></a>
					</div>


					<scene>
						<viewpoint id = "angle1" position='45 0 200' orientation="0 0 1 0" description = "Cam Angle 1"></viewpoint>

						<inline id="x3d_object" url="x3d_output/<?php echo $_GET['job_id'];?>.x3d" onload="center();"></inline> 

					</scene> 
				</x3d>

				
				<x3d id='x3d_element_1' class='x3d_element'>
					<div id="instructions">
						<button type="button" onclick="center1(event)" class="btn btn-secondary">Center</button>
						<a href="gmsh_output/<?php echo $_GET['job_id'];?>/mesh.x3d" download><button type="button" class="btn btn-secondary">Download Mesh</button></a>
					</div>


					<scene>
						<viewpoint id = "angle1" position='45 0 200' orientation="0 0 1 0" description = "Cam Angle 1"></viewpoint>

						<inline id="x3d_object_1" url="gmsh_output/<?php echo $_GET['job_id'];?>/mesh.x3d" onload="center1();"></inline> 

					</scene> 
				</x3d>   
			</div>  
		</div>

	</body>
</html>