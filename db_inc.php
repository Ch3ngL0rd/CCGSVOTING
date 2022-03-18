<?php

/* Host name of the MySQL server */
$host = 'localhost';

/* MySQL account username */
$user = 'testuser';

/* MySQL account password */
$passwd = 'testdev123';

/* The schema you want to use */
$schema = 'testSchema';

/* Connection with MySQLi, procedural-style */
$mysqli = mysqli_connect($host, $user, $passwd, $schema);

/* Check if the connection succeeded */
if (!$mysqli)
{
   echo 'Connection failed<br>';
   echo 'Error number: ' . mysqli_connect_errno() . '<br>';
   echo 'Error message: ' . mysqli_connect_error() . '<br>';
   die();
}

echo 'Successfully connected!<br>';