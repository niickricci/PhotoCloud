<?php
include 'views/header.php';
if (!isset($pageTitle))
    $pageTitle = "";
if (!isset($viewHead))
    $viewHead = "";
if (!isset($viewStyle))
    $viewStyle = "";
if (!isset($viewContent))
    $viewContent = "";
if (!isset($viewScript))
    $viewScript = "";
    
$stylesBundle = "";
if (file_exists("views/stylesBundle.html"))
    $stylesBundle = file_get_contents("views/stylesBundle.html");

$scriptsBundle = "";
if (file_exists("views/scriptsBundle.html"))
    $scriptsBundle = file_get_contents("views/scriptsBundle.html");

$localScript = "";

if (isset($_SESSION["validUser"]) || isset($_SESSION["validAdmin"])) {
    $timeout = (int)$_SESSION["timeout"];
    $localScript = <<<HTML
    <script> $(document).ready(()=>{  timeout($timeout); }) </script>
    HTML;
} 

echo <<<HTML
    <!DOCTYPE html>
    <html>
    <header>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>$pageTitle</title>
        $stylesBundle
        $viewStyle
    </header>
    <body>
        <div id="main">
            <div id="header">
                $viewHead
            </div>
            $viewHeadCustom
            <div id="content">
                $viewContent
            </div>
        </div>
        $scriptsBundle
        $viewScript
        $localScript
    </body>
    </html>
    HTML;
?>