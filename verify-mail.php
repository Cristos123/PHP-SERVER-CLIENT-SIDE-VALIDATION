<?php
include_once "connection.php";
function finalizeMailVerification($createdOn, $userId, $emailId, $dataOne, $dataTwo, $mailValue)
{
    global $conn;
    mysqli_query($conn, "UPDATE `email` SET `status` = '0', `updatedOn` = '$createdOn' WHERE`subjectType` = 0 and `value` = '$mailValue' and `id` <> '$emailId';");
    if (mysqli_query($conn, "UPDATE `email` SET `status` = '1', `updatedOn` = '$createdOn' WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$userId' and `id` = '$emailId';")) {
        if (mysqli_query($conn, "UPDATE `emailVerification` SET `status` = '1', `updatedOn` = '$createdOn' WHERE `status` = 2 and `emailId` = '$emailId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo';")) {
            $dataOne = randomString(16);
            $dataTwo = randomString(16);
            if (mysqli_query($conn, "INSERT INTO `session` (`id`, `status`, `subjectType`, `subjectId`, `dataOne`, `dataTwo`, `loginTime`, `logoutTime`) VALUES (NULL, '1', '0', '$userId', '$dataOne', '$dataTwo', '$createdOn', '');")) {
                $_SESSION['userId'] = $userId;
                $_SESSION['dataOne'] = $dataOne;
                $_SESSION['dataTwo'] = $dataTwo;

                header("Location:index.php");
            } else {
                header("Location:index.php");
            }
        } else {
            header("Location:index.php");
        }
    } else {
        header("Location:index.php");
    }
}
if (!isset($_GET) || !isset($_GET['userId']) || !isset($_GET['dataOne']) || !isset($_GET['dataTwo']) || !isset($_GET['emailId'])) {
    header("Location:index.php");
} else {
    $emailId = $_GET['emailId'];
    $userId = $_GET['userId'];
    $dataOne = $_GET['dataOne'];
    $dataTwo = $_GET['dataTwo'];
    $createdOn = time();
    $emailVerificationObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `emailVerification` WHERE `status` = 2 and `emailId` = '$emailId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' LIMIT 1"));
    if (!!$emailVerificationObject) {
        $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$userId' and `id` = '$emailId' LIMIT 1"));
        if (!!$emailObject) {
            $userObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `id` = '$userId' LIMIT 1"));
            if (isset($userObject) && !!$userObject && isset($userObject->status)) {
                if ($userObject->status == '0') {
                    header("Location:index.php");
                } else if ($userObject->status == '1') {
                    finalizeMailVerification($createdOn, $userId, $emailId, $dataOne, $dataTwo, $emailObject->value);
                } else if ($userObject->status == '2') {
                    if (mysqli_query($conn, "UPDATE `user` SET `status` = '1', `updatedOn` = '$createdOn'  WHERE `status` = 2 and `id` = '$userId';")) {
                        finalizeMailVerification($createdOn, $userId, $emailId, $dataOne, $dataTwo, $emailObject->value);
                    } else {
                        header("Location:index.php");
                    }
                } else {
                    header("Location:index.php");
                }
            } else {
                header("Location:index.php");
            }
        } else {
            header("Location:index.php");
        }
    } else {
        header("Location:index.php");
    }
}
