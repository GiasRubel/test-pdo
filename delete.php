<?php
require_once('student.php');

$student = new Student();

if (isset($_GET['id'])) {
	$id = $_GET['id'];

	$result = $student->destroy($id);

	if ($result) {
		header("Location:index.php");
	}
}