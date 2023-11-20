<?php
function saveImage($basePath, $imageData, $previousURL = "")
{
    if ($imageData == "" || strcmp($imageData, $previousURL) == 0) 
        // nothing is changed
        return $previousURL;
        
    if ($previousURL != "")
        // delete previous image file
        unlink($previousURL);
    // seperate mime and base64 image encoding
    $parts = explode(",", $imageData);
    // extract file extension from mime
    $extension = str_replace(";base64", "", str_replace("data:image/", ".", $parts[0]));
    // compile image file path
    $newImageFilePath = $basePath . GUIDv4() . $extension;
    // convert base-64 into binary without the mime and save to file
    file_put_contents($newImageFilePath, base64_decode($parts[1]));
    // return image file URL
    return $newImageFilePath;
}