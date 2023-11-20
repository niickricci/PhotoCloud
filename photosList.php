<?php
include 'php/sessionManager.php';
include "models/photos.php";
include "models/users.php";
$viewName="photoList";
userAccess();
$viewTitle = "Photos";
$list = PhotosFile()->toArray();
$viewContent = "<div class='photosLayout'>";
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'default';
switch ($sortOrder) {

    //Tri par owner
    case 'owners':
        usort($list, function ($a, $b) {
            $sA = no_Hyphens(UsersFile()->Get($a->OwnerId())->Name());
            $sB = no_Hyphens(UsersFile()->Get($b->OwnerId())->Name());
            return strcmp($sA, $sB);
        });
        break;
    case 'date':
        usort($list, function ($photo_a, $photo_b)
        {
            $time_a = (int)$photo_a->CreationDate();
            $time_b = (int)$photo_b->CreationDate();
            if ($time_a == $time_b) return 0;
            if ($time_a > $time_b) return -1;
            return 1;
        });
    }
foreach ($list as $photo) {
    $id = strval($photo->id());
    $title = $photo->Title();
    $description = $photo->Description();
    $image = $photo->Image();
    $owner = UsersFile()->Get($photo->OwnerId());
    $ownerName = $owner->Name();
    $ownerAvatar = $owner->Avatar();
    $shared = $photo->Shared() == "true";
    $sharedIndicator = "";
    $editCmd = "";
    $visible = $shared;
    if (($photo->OwnerId() == (int)$_SESSION["currentUserId"]) || isset($_SESSION["isAdmin"])) { //ADMIN
        $visible = true;
        $editCmd = <<<HTML
            <a href="editPhotoForm.php?id=$id" class="cmdIconSmall fa fa-pencil" title="Editer $title"> </a>
            <a href="confirmDeletePhoto.php?id=$id"class="cmdIconSmall fa fa-trash" title="Effacer $title"> </a>
        HTML;
        if ($shared) {
            $sharedIndicator = <<<HTML
                <div class="UserAvatarSmall transparentBackground" style="background-image:url('images/shared.png')" title="partagée"></div>
            HTML;
        } 
    }
    if ($visible) {
    $photoHTML = <<<HTML
        <div class="photoLayout" photo_id="$id">
            <div class="photoTitleContainer" title="$description">
                <div class="photoTitle ellipsis">$title</div> $editCmd</div>
            <a href="photoDetails.php?id=$id" target="_blank">
                <div class="photoImage" style="background-image:url('$image')">
                    <div class="UserAvatarSmall transparentBackground" style="background-image:url('$ownerAvatar')" title="$ownerName"></div>
                    $sharedIndicator
                </div>
            </a>
        </div>           
        HTML;
        $viewContent = $viewContent . $photoHTML;
    }
}
$viewContent = $viewContent . "</div>";

$viewScript = <<<HTML
    <script src='js/session.js'></script>
    <script defer>
        $("#addphotoCmd").hide();
    </script>
HTML;

include "views/master.php";
