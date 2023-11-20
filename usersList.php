<?php
include 'php/sessionManager.php';
include_once "models/Users.php";

adminAccess();

$viewTitle = "Gestion des usagers";
$list = UsersFile()->toArray();
$viewContent = "";

//Admin
if (isset($_POST['userId']) && isset($_POST['newType'])) {
    $userId = (int)$_POST['userId'];
    $newType = $_POST['newType'];
    $user = UsersFile()->get($userId);
    $user->setType($newType);
    UsersFile()->update($user);

    header('Location: usersList.php'); 
    exit;
}
//Bloquer
if (isset($_POST['userId']) && isset($_POST['newBlocked'])) {
    $userId = (int)$_POST['userId'];
    $newBlocked = $_POST['newBlocked'];
    $user = UsersFile()->get($userId);
    $user->setBlocked($newBlocked);
    UsersFile()->update($user);

    header('Location: usersList.php'); 
    exit;
}
//Remove

foreach ($list as $User) {

    //Skip le user connecter
    if($User->id() == $_SESSION["currentUserId"]){
        continue;
    }

    $id = strval($User->id());
    $name = $User->name();
    $email = $User->Email();
    $avatar = $User->Avatar();

    /******************************Admin***************************************/
    $type = $User->Type();
    $newType = $type == 1 ? 0 : 1;
    $adminIcon = $type == 1 ? "fa fa-user-gear mx-2" : "fa fa-user mx-2";
    $UserCmdAdmin = <<<HTML
        <form method="POST">
            <input type="hidden" name="userId" value="$id">
            <input type="hidden" name="newType" value="$newType">
            <button type="submit" class="cmdIconVisible blueCmd $adminIcon"></button>
        </form>
        HTML;
    /******************************Blocked**************************************/
    $blocked = $User->Blocked();
    $newBlocked = $blocked == 1 ? 0 : 1;
    $styleBlocked = $blocked == 1 ? "redCmd" : "greenCmd";
    $UserCmdBlocked = <<<HTML
    <form method="POST">
        <input type="hidden" name="userId" value="$id">
        <input type="hidden" name="newBlocked" value="$newBlocked">
        <button type="submit" class="cmdIconVisible $styleBlocked fa fa-circle-xmark mx-2"></button>
    </form>
    HTML;
    /******************************Remove*************************************/
    $UserCmdRemove = <<<HTML
        <form method="POST">
    <a class="cmdIconVisible goldenrodCmd fa fa-user-slash mx-2"></a>
    </form>
    HTML;
    /*************************************************************************/


    $UserHTML = <<<HTML
    <div class="UserRow" User_id="$id">
        <div class="UserContainer">
            <div class="UserLayout">
                <div class="UserAvatar" style="background-image:url('$avatar')"></div>
                <div class="UserInfo">
                    <span class="UserName">$name</span>
                    <a href="mailto:$email" class="UserEmail" target="_blank" >$email</a>
                </div>
            </div>
            <div class="UserCommandPanel">
                $UserCmdAdmin
                $UserCmdBlocked
                $UserCmdRemove
            </div>
        </div>
    </div>           
    HTML;
    $viewContent = $viewContent . $UserHTML;
}

$viewScript = <<<HTML
    <script src='js/session.js'></script>
    <script defer>
        $("#addPhotoCmd").hide();
    </script>
HTML;


include "views/master.php";
