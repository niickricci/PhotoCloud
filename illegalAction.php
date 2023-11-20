<?php
$viewTitle = "Action illégale!";
$viewContent = <<<HTML
    <br>
    <div class="loginForm">
    <h4>Vous devez ne détener pas les droits pour accomplir cette action.</h4><br><br>
    <h2><a href='loginForm.php'>Connexion</a></h2>
    </div>
HTML;
$viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
        HTML;
include "views/master.php";