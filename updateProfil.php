<?php
require 'php/sessionManager.php';
require 'models/users.php';
userAccess();

$user = UsersFile()->get($_SESSION['currentUserId']);
$newUser = new User($_POST);

if ($newUser->Password() == "") {
    $newUser->setPassword($user->Password());
}
if ($newUser->Avatar() != "") {
    $_SESSION["avatar"] = "";
}
UsersFile()->update($newUser);
$user = UsersFile()->get($_SESSION['currentUserId']);
$_SESSION["name"] = $user->Name();
$_SESSION["avatar"] = $user->Avatar();
$_SESSION['Email'] = $user->Email();
redirect('photosList.php');