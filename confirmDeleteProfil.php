<?php
    include 'php/sessionManager.php';
    include 'models/users.php';
    $viewTitle = "Retrait de compte";
    
    userAccess(200);

    
    $userId = isset($_GET['id']) ? (int)$_GET['id'] : 'default';

    if($userId != 'default'){
        $user = UsersFile()->get($userId);
        $name = $user->Name();

        if (($userId != (int)$_SESSION["currentUserId"])) { 
            if(!isset($_SESSION["isAdmin"])){
                redirect("illegalAction.php");
            }
        }
    }
    
    if($userId == 'default'){
        $userId = (int)$_SESSION["currentUserId"];
    }

    if($userId == (int)$_SESSION["currentUserId"]){
        $viewContent = <<<HTML
        <div class="content loginForm">
            <br>
           <h3> Voulez-vous vraiment effacer votre compte? </h3>
            <div class="form">
                <a href="deleteProfil.php"><button class="form-control btn-danger">Effacer mon compte</button>
                <br>
                <a href="editProfilForm.php" class="form-control btn-secondary">Annuler</a>
            </div>
        </div>
        HTML;
    }
    else{ //Admin
        $viewContent = <<<HTML
        <div class="content loginForm">
            <br>
           <h3> Voulez-vous vraiment effacer $name? </h3>
            <div class="form">
                <a href="deleteProfil.php?id=$userId"><button class="form-control btn-danger">Effacer $name</button>
                <br>
                <a href="usersList.php" class="form-control btn-secondary">Annuler</a>
            </div>
        </div>
        HTML;
    }
    $viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
    HTML;
    include "views/master.php";