<?php
    require 'php/sessionManager.php';
   
    $viewTitle = "Connexion";
    
    $message = "";
    if (session_Timeout_Occured()) {
        $message = "Expiration de session, veuillez vous connecter à nouveau.";
    }
    
    $Email = isset($_SESSION['Email'])? $_SESSION['Email'] : '';
    $EmailError = isset($_SESSION['EmailError'])? $_SESSION['EmailError'] : '';
    $passwordError = isset($_SESSION['passwordError'])? $_SESSION['passwordError'] : '';

    delete_session();
 
    anonymousAccess();

    $viewContent = <<< HTML
    <br>
    <div class="content loginForm">
        <h3>$message</h3>
        <br>
        <form method='post' action='login.php'>
        <span style='color:red'>$EmailError</span>
            <input  type='email' 
                    name='Email'
                    class="form-control"
                    required
                    RequireMessage = 'Veuillez entrer votre courriel'
                    InvalidMessage = 'Courriel invalide';
                    placeholder="adresse de courriel"
                    value=$Email > 
 
            
            <span style='color:red'>$passwordError</span>
            <input  type='password' 
                    name='Password' 
                    placeholder='Mot de passe'
                    class="form-control"
                    required
                    RequireMessage = 'Veuillez entrer votre mot de passe'
                    InvalidMessage = 'Mot de passe trop court' >
    
            <input type='submit' name='submit' value="Entrer" class="form-control btn-primary">
        </form>
        <div class="form">
            <hr>
            <a href="newUserForm.php"><button class="form-control btn-info">Nouveau compte</button>
        </div>
    </div>
    HTML;
    $viewScript = <<<HTML
        <script src='js/validation.js'></script>
        <script defer>
            initFormValidation();
            $("#addPhotoCmd").hide();
        </script>
    HTML;
    include "views/master.php";


