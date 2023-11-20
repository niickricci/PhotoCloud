<?php
$viewTitle = "Accès interdit!";
$viewContent = <<<HTML
    <br>
    <div class="loginForm">
    <h4>Vous devez vous connecter pour voir cette page</h4><br><br>
    <h2><a href='loginForm.php'>Connexion</a></h2>
    </div>
HTML;
$viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
        HTML;
include "views/master.php";
