<?php
require_once('student.php');
$student = new Student();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<?php 
			if (isset($_GET['eid'])) {
			 	$eid = $_GET['eid'];

			 	$students = $student->getstudentbyId($eid);

			 	// var_dump($students);


			 	$subject_match = explode(',', $students["subject_id"]);

			 	// var_dump($subject_match);
			 } 

			$subject_id = '';

				if (isset($_POST['submit'])) 
				{
					$name = $_POST['name'];

					if (isset($_POST['subject'])) {
						$subject = $_POST['subject'];

						foreach ($subject as $subjects) {
							$subject_id .= $subjects.',';
						}
					}

					// var_dump($subject_id);

					if (empty($name) or empty($subject_id))
					{
					echo "<span style='color:red;'>Fill inputs</span>";
					}
					else{

						$result= $student->update($name,$subject_id,$eid);

						if ($result) {
							header("Location:index.php");
						}
						else{
							echo "no";
						}
					}
				}
			?>
			<form action="" method="post" enctype="multipart/form-data">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Name</label>
			    <input type="text" class="form-control" placeholder="Enter Name" name="name" value="<?= $students["name"]?>">
			    
			  </div>
			 <div class="form-group">
			     <label for="exampleFormControlFile1">Example file input</label>
			     <input type="file" class="form-control-file" name="image">
			   </div>
			  <div class="form-check">
			  	<?php
			  	$results = $student->getsubject();
			  	foreach ($results as $row) {
			  ?>
			    <input class="form-check-input" type="checkbox" value="<?= $row["name"]?>"  name="subject[]" 
			    <?php if (in_array($row["name"], $subject_match)): ?>
			    	checked
			    <?php endif ?>><?= $row["name"]?> <br>
			    
			<?php } ?>
			  </div>
			  <button type="submit" name="submit" class="btn btn-primary">Update</button>
			</form>
		</div>


	</div>
</div>
</body>
</html>