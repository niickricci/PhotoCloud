<?php
    include 'php/sessionManager.php';
    include 'models/users.php';
    $viewTitle = "Profil";
    
    userAccess();

    $user = UsersFile()->get($_SESSION['currentUserId']);
    $id = $user->Id();
    $name = $user->Name();
    $email = $user->Email();
    $newImage = false;
    $avatar = $user->Avatar();
    $type = $user->Type();
    $blocked = $user->Blocked();
    $viewContent = <<< HTML
    <div class="content">
        <br>
        <form method='post' action='updateProfil.php'>
            <input type="hidden" name="Id" id="Id" value="$id"/>
            <input type="hidden" name="Type" id="Type" value="$type"/>
            <input type="hidden" name="Blocked" id="Blocked" value="$blocked"/>
            <fieldset>
                <legend>Adresse ce courriel</legend>
                <input  type="email" 
                        class="form-control Email" 
                        name="Email" 
                        id="Email"
                        placeholder="Courriel" 
                        required 
                        RequireMessage = 'Veuillez entrer votre courriel'
                        InvalidMessage = 'Courriel invalide'
                        CustomErrorMessage ="Ce courriel est déjà utilisé"
                        value="$email" >

                <input  class="form-control MatchedInput" 
                        type="text" 
                        matchedInputId="Email"
                        name="matchedEmail" 
                        id="matchedEmail" 
                        placeholder="Vérification" 
                        required
                        RequireMessage = 'Veuillez entrez de nouveau votre courriel'
                        InvalidMessage="Les courriels ne correspondent pas" 
                        value="$email" >
            </fieldset>
            <fieldset>
                <legend>Mot de passe</legend>
                <input  type="password" 
                        class="form-control" 
                        name="Password" 
                        id="Password"
                        placeholder="Mot de passe" 
                        InvalidMessage = 'Mot de passe trop court' >

                <input  class="form-control MatchedInput" 
                        type="password" 
                        matchedInputId="Password"
                        name="matchedPassword" 
                        id="matchedPassword" 
                        placeholder="Vérification" 
                        InvalidMessage="Ne correspond pas au mot de passe" >
            </fieldset>
            <fieldset>
                <legend>Nom</legend>
                <input  type="text" 
                        class="form-control Alpha" 
                        name="Name" 
                        id="Name"
                        placeholder="Nom" 
                        required 
                        RequireMessage = 'Veuillez entrer votre nom'
                        InvalidMessage = 'Nom invalide'
                        value="$name" >
            </fieldset>
            <fieldset>
                <legend>Avatar</legend>
                <div class='imageUploader' 
                        newImage='$newImage' 
                        controlId='Avatar' 
                        imageSrc='$avatar' 
                        waitingImage="images/Loading_icon.gif">
            </div>
            </fieldset>
        
            <input type='submit' name='submit' id='saveUser' value="Enregistrer" class="form-control btn-primary">
                
        </form>
        <div class="cancel">
        <a href="photosList.php">
            <button class="form-control btn-secondary">Annuler</button>
        </a>

        <div class="cancel">
            <hr>
            <a href="confirmDeleteProfil.php">
                <button class="form-control btn-warning">Effacer le compte</button>
            </a>
        </div>
    </div>
    HTML;
    $viewScript = <<<HTML
        <script src='js/validation.js'></script>
        <script src='js/imageControl.js'></script>
        <script defer>
            $("#addPhotoCmd").hide();
            addConflictValidation('testConflict.php', 'Email', 'saveUser' );
        </script>
    HTML;
    include "views/master.php";


