<?php
include 'php/sessionManager.php';
include 'models/users.php';
include 'models/photos.php';

userAccess();

$userId = isset($_GET['id']) ? (int)$_GET['id'] : 'default';

if ($userId != 'default') {
    if (($userId != (int)$_SESSION["currentUserId"])) {
        if (!isset($_SESSION["isAdmin"])) {
            redirect("illegalAction.php");
        }

        $currentUserId = $userId;

        do {
            $photos = PhotosFile()->toArray();
            $oneDeleted = false;
            foreach ($photos as $photo) {
                if ($photo->OwnerId() == $currentUserId) {
                    $oneDeleted = true;
                    PhotosFile()->remove($photo->Id());
                    break;
                }
            }
        } while ($oneDeleted);

        UsersFile()->remove($currentUserId);

        redirect('usersList.php');
    }
}
$currentUserId = (int)$_SESSION["currentUserId"];

do {
    $photos = PhotosFile()->toArray();
    $oneDeleted = false;
    foreach ($photos as $photo) {
        if ($photo->OwnerId() == $currentUserId) {
            $oneDeleted = true;
            PhotosFile()->remove($photo->Id());
            break;
        }
    }
} while ($oneDeleted);

UsersFile()->remove($currentUserId);

redirect('usersList.php');