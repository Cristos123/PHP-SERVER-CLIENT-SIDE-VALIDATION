<?php
include_once "connection.php";
function finalizePhoneNumberVerification($createdOn, $userId, $phoneNumberId, $dataOne, $dataTwo, $countryCode, $phoneNumber)
{
    global $conn;
    $primaryValue = 1;
    $userExistingPrimaryPhoneNumber = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `status` = 1 and `subjectType` = 0 and `subjectId` = '$userId' and `isPrimary` = 1 LIMIT 1"));
    if (!!$userExistingPrimaryPhoneNumber) {
        $primaryValue = 0;
    }
    mysqli_query($conn, "UPDATE `phoneNumber` SET `status` = '0', `updatedOn` = '$createdOn' WHERE `subjectType` = 0 and `code` = '$countryCode' and `value` = '$phoneNumber' and `id` <> '$phoneNumberId';");
    if (mysqli_query($conn, "UPDATE `phoneNumber` SET `status` = '1',`isPrimary` = '$primaryValue', `updatedOn` = '$createdOn' WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$userId' and `id` = '$phoneNumberId';")) {
        if (mysqli_query($conn, "UPDATE `phoneNumberVerification` SET `status` = '1', `updatedOn` = '$createdOn' WHERE `status` = 2 and `phoneNumberId` = '$phoneNumberId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo';")) {
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
if (!isset($_GET) || !isset($_GET['userId']) || !isset($_GET['dataOne']) || !isset($_GET['dataTwo']) || !isset($_GET['phoneNumberId'])) {
    header("Location:index.php");
} else {
    $phoneNumberId = $_GET['phoneNumberId'];
    $userId = $_GET['userId'];
    $dataOne = $_GET['dataOne'];
    $dataTwo = $_GET['dataTwo'];
    $createdOn = time();
    $phoneNumberVerificationObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumberVerification` WHERE `status` = 2 and `phoneNumberId` = '$phoneNumberId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' LIMIT 1"));
    if (!!$phoneNumberVerificationObject) {
        $phoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$userId' and `id` = '$phoneNumberId' LIMIT 1"));
        if (!!$phoneNumberObject) {
            $userObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `id` = '$userId' LIMIT 1"));
            if (isset($userObject) && !!$userObject && isset($userObject->status)) {
                if ($userObject->status == '0') {
                    header("Location:index.php");
                } else if ($userObject->status == '1') {
                    finalizePhoneNumberVerification($createdOn, $userId, $phoneNumberId, $dataOne, $dataTwo, $phoneNumberObject->code, $phoneNumberObject->value);
                } else if ($userObject->status == '2') {
                    if (mysqli_query($conn, "UPDATE `user` SET `status` = '1', `updatedOn` = '$createdOn'  WHERE `status` = 2 and `id` = '$userId';")) {
                        finalizePhoneNumberVerification($createdOn, $userId, $phoneNumberId, $dataOne, $dataTwo, $phoneNumberObject->code, $phoneNumberObject->value);
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
