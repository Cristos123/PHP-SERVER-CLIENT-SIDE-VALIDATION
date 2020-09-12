<?php
include_once "connection.php";
$target_dir = "uploads/";
$defaultProfilePicture = "static/" . basename("0000.png");
$defaultContentType = "image/png;";

if(isset($_GET)&&isset($_GET['userId'])){
    $userId = $_GET['userId'];
    $userObject;
    if($currentlyLoggedInUser->id == $userId){
        $userObject = $currentlyLoggedInUser;
    }else{
        $userObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `status` = 1 and `id` = '$userId' LIMIT 1"));
    }
    if(!!$userObject){
        $profilePictureObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `profilePicture` WHERE `userId` = '$userId' and `status` = 1 LIMIT 1"));
        if(!!$profilePictureObject){
            $defaultProfilePicture = $profilePictureObject->path;
            $defaultContentType = $profilePictureObject->contentType;
        }
    }
}else if(!!$currentlyLoggedInUser){
    $profilePictureObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `profilePicture` WHERE `userId` = '$currentlyLoggedInUser->id' and `status` = 1 LIMIT 1"));
    if(!!$profilePictureObject){
        $defaultProfilePicture = $profilePictureObject->path;
        $defaultContentType = $profilePictureObject->contentType;
    }
}

header('Content-Type: '.$defaultContentType );
readFileByChunkSize($defaultProfilePicture,1024*1024);
