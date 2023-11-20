<?php
include 'php/sessionManager.php';
include 'models/photos.php';
userAccess();
$photo = new Photo($_POST);
PhotosFile()->update($photo);
redirect('photosList.php');
