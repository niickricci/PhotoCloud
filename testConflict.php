<?php
require 'models/users.php';

$user = new User();
$user->setEmail($_GET['Email']);
$user->setId((int) $_GET['Id']);
$result = UsersFile()->Conflict($user);

header('Content-type: application/json');
echo json_encode($result);