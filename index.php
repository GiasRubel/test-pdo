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

						$permited  = array('jpg', 'jpeg', 'png', 'gif');
					    $file_name = $_FILES['image']['name'];
					    // var_dump($file_name);
					    $file_size = $_FILES['image']['size'];
					    $file_temp = $_FILES['image']['tmp_name'];

					    $div = explode('.', $file_name);
					    $file_ext = strtolower(end($div));
					    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
					    $uploaded_image = "uploads/".$unique_image;

					    // var_dump( $uploaded_image);



					// var_dump($subject_id);

					if (empty($name) or empty($subject_id))
					{
					echo "<span style='color:red;'>Fill inputs</span>";
					}
					elseif (empty($file_name)) {
						
						echo "Select an Image";
					}elseif ($file_size >1048567) {
						echo "Image Size should be less then 1MB!";
					} elseif (in_array($file_ext, $permited) === false) {
						echo "you can upload only:".implode(',',$permited)." Files";
					}
					else{

						move_uploaded_file($file_temp, $uploaded_image);

						$result= $student->add($name,$subject_id,$uploaded_image);

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
			    <input type="text" class="form-control" placeholder="Enter Name" name="name">
			    
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
			    <input class="form-check-input" type="checkbox" value="<?= $row["name"]?>"  name="subject[]"><?= $row["name"]?> <br>
			    
			<?php } ?>
			  </div>
			  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>

		<div class="col-md-6">
			<table class="table">
			    <thead>
			      <tr>
			        <th>Serial</th>
			        <th>Name</th>
			        <th>Subject</th>
			        <th>Image</th>
			        <th width="40%">Action</th>
			      </tr>
			    </thead>
			    <tbody>
			    	<?php
			    		$id = 1;
			    		$result = $student->getallstudent();
			    		foreach ($result as $row) {
			    	?>
			      <tr>
			        <td><?= $id++ ?></td>
			        <td><?= $row['name']?></td>
			        <td><?= substr($row['subject_id'],0,-1)?></td>
			        <td><img src="<?= $row['image']?>" alt="" width="100px" height="80px"></td>
			        <td>
			        	<a href="edit.php?eid=<?= $row['id']?>"><button style="margin: -2px;">Edit</button></a> ||
			        	<a href="delete.php?id=<?= $row['id']?>"><button>delete</button></a>
			        </td>
			      </tr>
			    <?php } ?>
			    </tbody>
			  </table>
		</div>
	</div>
</div>
</body>
</html>