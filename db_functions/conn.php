<?php
	// БД - SQLite 
	if(!is_file('db/db_user2.sqlite3')){
		file_put_contents('db/db_user2.sqlite3', null);
	}
	$conn = new PDO('sqlite:db/db_user2.sqlite3');
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$query = "CREATE TABLE IF NOT EXISTS user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username TEXT UNIQUE, pass TEXT, email TEXT UNIQUE, phonenumber TEXT UNIQUE)";
	$conn->exec($query);
	return $conn;
?>
