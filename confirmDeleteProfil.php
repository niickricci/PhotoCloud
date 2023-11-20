<?php
    include 'php/sessionManager.php';
    include 'models/users.php';
    $viewTitle = "Retrait de compte";
    
    userAccess(200);

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
    $viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
    HTML;
    include "views/master.php";