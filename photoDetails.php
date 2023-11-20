<?php
include 'php/sessionManager.php';
include "models/photos.php";
include "models/users.php";
    $viewTitle = "Details Photos";
    
    userAccess();
    $viewContent = "";

    $imageId = isset($_GET['id']) ? $_GET['id'] : 'default';
    $photo = PhotosFile()->get((int)$imageId);
    $title = $photo->Title();
    $description = $photo->Description();
    $image = $photo->Image();
    $owner = UsersFile()->Get($photo->OwnerId());
    $ownerName = $owner->Name();
    $ownerAvatar = $owner->Avatar();
    $creationDate = $photo->CreationDate();
    $shared = $photo->Shared() == "true";
    $visible = $shared;

    if (($photo->OwnerId() == (int)$_SESSION["currentUserId"]) || isset($_SESSION["isAdmin"])) { //ADMIN
            $visible = true;

    }
    if ($visible) {
        $photoHTML = <<<HTML
            <br>
            <div>
            <img class="UserAvatarSmall"src="$ownerAvatar" alt="">
            <span class="UserName">$ownerName</span>
            </div>
            <div class="photoDetailsTitle">$title</div>
            <div class="photoDetailsDescription">$description</div>
            <div class="photoImage"><img src="$image" alt=""></div>
            <div class="photoDetailsCreationDate">Date de création: $creationDate</div>
            HTML;
            $viewContent = $viewContent . $photoHTML;
    }
    else{
        redirect("illegalAction.php");
    }
$viewContent = $viewContent . "</div>";

$viewScript = <<<HTML
    <script src='js/session.js'></script>
    <script defer>
        $("#addphotoCmd").hide();
    </script>
HTML;

include "views/master.php";
