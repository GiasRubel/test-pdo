<?php

require_once('config.php');

class Student{

	public function __construct()
	{
		$database = new DatabaseConnection();
	}

	public function add($name,$subject_id,$uploaded_image)
	{
		global $pdo;

		$query = "insert into student (name,subject_id,image) values(?,?,?)" ;

		$result = $pdo->prepare($query);

		$result->execute([$name,$subject_id,$uploaded_image]);

		return true;

	// var_dump($subject_id);
	}

	public function getsubject()
	{
		global $pdo;

		$query = "select * from subject";

		$result = $pdo->prepare($query);

		$result->execute();

		$row =  $result->fetchAll();

		return $row;

		// var_dump($row);

	}

	public function getallstudent()
	{
		global $pdo;

		$query = "select * from student";

		$result = $pdo->prepare($query);

		$result->execute();

		return $result->fetchALL();
	}

	public function destroy($id)
	{
		global $pdo;

		$query = "delete from student where id = ? ";

		$result = $pdo->prepare($query);

		$result->execute([$id]);

		return $result;
	}

	public function getstudentbyId($eid)
	{
		global $pdo;

		$query = "select name,subject_id from student where id = ? ";

		$result = $pdo->prepare($query);

		$result->execute([$eid]);

		return $result->fetch();
	}

	public function update($name,$subject_id,$uploaded_image,$eid)
	{
		global $pdo;

		$query = "update student set name = ?,
		                             subject_id = ? ,
		                             image = ?
		                             where id = ? " ;

		$result = $pdo->prepare($query);

		$result->execute([$name,$subject_id,$uploaded_image,$eid]);

		return true;
	}
}