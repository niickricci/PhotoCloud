<?php
include 'php/sessionManager.php';
include 'models/photos.php';
userAccess();

$viewTitle = "Modification de photo";

$id = (int) $_GET["id"];
if (!isset($_GET["id"]))
    redirect("illegalAction.php");

$photo = PhotosFile()->get($id);

if ($photo == null)
    redirect("illegalAction.php");

$ownerId = $photo->OwnerId();
if ($ownerId != (int) $_SESSION["currentUserId"])
    if(!isset($_SESSION["isAdmin"]))
        redirect("illegalAction.php");

$title = $photo->Title();
$description = $photo->Description();
$creationDate = $photo->CreationDate();
$shared = $photo->Shared() == "true" ? "checked" : "";
$image = $photo->Image();

$viewContent = <<<HTML
    <div class="content">
        <br>
        <form method='post' action='updatePhoto.php'>
            <input type="hidden" name = "Id" value=$id>
            <input type="hidden" name = "CreationDate" value=$creationDate>
            <input type="hidden" name = "OwnerId" value=$ownerId >
            <fieldset>
                <legend>Informations</legend>
                <input  type="Titre" 
                        class="form-control Alpha" 
                        name="Title" 
                        id="Title"
                        placeholder="Titre" 
                        required 
                        RequireMessage = 'Veuillez entrer un titre'
                        InvalidMessage = 'Le titre contient des caractères spéciaux' 
                        value="$title"/>

                <textarea  class="form-control Alpha" 
                            name="Description" 
                            id="Description"
                            placeholder="Description" 
                            rows="4"
                            required 
                            RequireMessage = 'Veuillez entrer une Description'>$description</textarea>

                <input  type="checkbox" 
                        name="Shared" 
                        id="Shared" $shared />  
                <label for="Shared">Partagée</label>
            </fieldset>
            <fieldset>
                <legend>Image</legend>
                <div class='imageUploader' 
                        newImage='false' 
                        controlId='Image' 
                        imageSrc='$image' 
                        required 
                        RequireMessage = 'Veuillez entrer une image'
                        waitingImage="images/Loading_icon.gif">
                </div>
            </fieldset>
            <input type='submit' name='submit' value="Enregistrer" class="form-control btn-primary">
        </form>
        <div class="cancel">
            <a href="photosList.php">
                <button class="form-control btn-secondary">Annuler</button>
            </a>
        </div>
    </div>
    HTML;

    $viewScript = <<<HTML
        <script src='js/validation.js'></script>
        <script src='js/imageControl.js'></script>
        <script defer>
            initFormValidation();
            $("#addPhotoCmd").hide();
        </script>
    HTML;

include "views/master.php";


