<?php
include 'php/sessionManager.php';
include 'models/photos.php';
$viewTitle = "Retrait de photo";

userAccess();

if(!isset($_GET["id"]))
    redirect("illegalAction.php");

$id = (int) $_GET["id"];

$photo = PhotosFile()->get($id);
if ($photo == null)
    redirect("illegalAction.php");

if ($photo->OwnerId() != (int) $_SESSION["currentUserId"])
    redirect("illegalAction.php");

PhotosFile()->remove($id);
redirect("photosList.php");