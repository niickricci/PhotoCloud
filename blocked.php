<?php
$viewTitle = "Compte bloqué";
$viewContent = <<<HTML
    <br>
    <div class="loginForm">
    <h4>Votre compte est bloqué...</h4><br><br>
    <h2><a href='loginForm.php'>Retour</a></h2>
    </div>
HTML;
$viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
        HTML;
include "views/master.php";