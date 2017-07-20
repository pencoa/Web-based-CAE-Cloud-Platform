<!DOCTYPE html>
<html>
	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>
	

		<script>

		  	function displayCoordinates(event)
		  	{
		  		var coordinates = event.hitPnt;
		  		
		  		//alert(Object.keys(event.target._x3domNode._objectID));
		  		//alert(event.target._x3domNode._objectID);
		  		//alert(Object.keys(event.hitObject);
		  		// alert($(event).attr('id'));

		  		//document.getElementById("temp").setAtribute('diffuseColor', '0 0 1');


		  		val = parseInt(event.target._x3domNode._objectID);
		  		anchorColor = '0 0.75 0.75';
		  		pressureColor = '0.5 1 0.5';
		  		defaultColor = '0.65 0.65 0.65';

		  		if (event.button == 1) {
		  			$('#marker').attr('translation', event.hitPnt);
		  			
		  			if (isSelected(anchorColor, val)) {
		  				setFaceColor(defaultColor, val);
		  			} else {
		  				setFaceColor(anchorColor, val);
		  			}

			   		document.getElementById('a_x').value = coordinates[0];
			   		document.getElementById('a_y').value = coordinates[1];
			   		document.getElementById('a_z').value = coordinates[2];

		  		} else if (event.button == 2) {
		  			$('#marker2').attr('translation', event.hitPnt);

				   	if (isSelected(pressureColor, val)) {
		  				setFaceColor(defaultColor, val);
		  			} else {
		  				setFaceColor(pressureColor, val);
		  			}

			   		document.getElementById('p_x').value = coordinates[0];
			   		document.getElementById('p_y').value = coordinates[1];
			   		document.getElementById('p_z').value = coordinates[2];
		  		}

		  	}

		  	function setFaceColor(color, value)
		  	{
		  		document.getElementById('Object__Shape_Mat_'.concat(String(value - 2))).setAttribute('diffuseColor', color);
		  	}

		  	function isSelected(color, value)
		  	{
		  		if (document.getElementById('Object__Shape_Mat_'.concat(String(value - 2))).getAttribute('diffuseColor') == color) {
		  			return true;
		  		} else {
		  			return false;
		  		}
		  	}

		  	function calculateFace(event)
		  	{
		  		var element = document.getElementById('jobid').textContent;
		   		var extracted_id = element.replace("Job Id: ", "");

		  		$.ajax({
		   			type: "POST",
		   			url: 'calls_converter.php',
		   			data: { 
		   				anchorX: 21.4,
		   				anchorY: document.getElementById('a_y').value,
		   				anchorZ: document.getElementById('a_z').value,
		   				pressureX: document.getElementById('p_x').value,
		   				pressureY: document.getElementById('p_y').value,
		   				pressureZ: document.getElementById('p_z').value,
		   				job_id: extracted_id
		   			},
		   			success: function(data) {
		   				console.log(data);
		   			}
		   		});
		  	}

		  </script>
	  </head>


    <body>
    <h1>3D Display of Uploaded File (<?php echo $_GET["step_file"];?>)</h1>
    <h2 id=jobid>Job Id: <?php echo $_GET["job_id"];?> </h2>

        <x3d width='500px' height='400px'> 
            <scene>
            	<!-- <inline nameSpaceName="Object" mapDEFToID="true" url="x3d_output/<?php echo $_GET["job_id"];?>.x3d" onclick="displayCoordinates(event)"></inline>  -->
            	<inline nameSpaceName="Object" mapDEFToID="true" url="x3d_output/"<?php $_GET["job_id"]?> onclick="displayCoordinates(event)"></inline> 
            	<Transform id="marker" scale="2.5 2.5 2.5" translation="0 0 0">
			        <Shape>
			            <Appearance>
			                <Material diffuseColor="#FF6666"></Material>
			            </Appearance>
			            <Sphere></Sphere>
			        </Shape>
			    </Transform>

			    <Transform id="marker2" scale="2.5 2.5 2.5" translation="0 0 0">
			        <Shape>
			            <Appearance>
			                <Material diffuseColor="#66FFAA"></Material>
			            </Appearance>
			            <Sphere></Sphere>
			        </Shape>
			    </Transform>

            </scene> 
        </x3d> 

        <h5 style="color: #FF6666">Left Click for Anchor Selection</h5>
        <h5 style="color: #66FFAA">Right Click for Pressure Selection</h5>

		<form method="post" action="calls_converter.php">
			Density:
			<input type="text" name="density"><br>
			Young's Modulus:
			<input type="text" name="youngs_mod"><br>
			Poisson's Ratio:
			<input type="text" name="poissons"><br>
			Element Size:
			<input type="text" name="element_size"><br>
			Material:
			<input type="text" name="material"><br><br>
			Anchor Coordinates:<br>
			X: <input type="text" id="a_x" name="a_x"><br>
			Y: <input type="text" id="a_y" name="a_y"><br>
			Z: <input type="text" id="a_z" name="a_z"><br><br>
			Pressure Applied Coordinates:<br>
			X: <input type="text" id="p_x" name="p_x"><br>
			Y: <input type="text" id="p_y" name="p_y"><br>
			Z: <input type="text" id="p_z" name="p_z"><br><br>
			Job Id:
			<input type="text" readonly="readonly" name="id" value=<?php echo $_GET["job_id"];?>><br>
			<input type="submit" value="Submit">
		</form>
		

    </body>
</html>