<?php
session_start();
$dbHost;
$dbUser;
$dbPassword;
$mailPassword;
$mailUser;
$mailHost;
function isValidEmail($email)
{
    return preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', strtolower($email));
}
function containValidEmail($emails)
{
    if (is_array($emails) && count($emails) > 0) {
        $foundEmail = false;
        for ($ppp = 0; $ppp < count($emails); $ppp++) {
            if (isValidEmail($emails[$ppp])) {
                $foundEmail = true;
                break;
            }
        }
        return $foundEmail;
    } else {
        return false;
    }
}
function isValidEmailArray($emails)
{
    if (is_array($emails) && count($emails) > 0) {
        $foundNoNEmail = false;
        for ($ppp = 0; $ppp < count($emails); $ppp++) {
            if (!isValidEmail($emails[$ppp])) {
                $foundNoNEmail = true;
                break;
            }
        }
        return !$foundNoNEmail;
    } else {
        return false;
    }
}
function isValidUsername($username)
{
    return preg_match('/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/', $username);
}
function isvalidImage($profilePicture)
{
    return preg_match('/[\.jpg|\.jpeg|\.png]$/i', $profilePicture);
}

$domainName;
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Report all PHP errors (see changelog)
    error_reporting(E_ALL);
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $domainName = "justlocal.xyz";
    $mailPassword = "t64M2]HjB!]4}M6j?vLqb";
    $mailUser = "ceo@justlocal.xyz";
    $mailHost = "mail.justlocal.xyz";
} else {
    // Turn off all error reporting
    error_reporting(0);
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $domainName = "haneysbeauty.com";
    $mailPassword = "";
    $mailUser = "ceo@haneysbeauty.com";
    $mailHost = "mail.haneysbeauty.com";
}
$conn = mysqli_connect($dbHost, $dbUser, $dbPassword);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/**
 * This example shows making an SMTP connection with authentication.
 */

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'vendor/autoload.php';

function sendSMS($phoneNumbers, $senderName, $content)
{
}
function sendMailWithHost($sendFrom, $recievers, $senderName, $subject, $content, $replyToName)
{
    global $mailHost;
    global $domainName;
    global $mailUser;
    global $mailPassword;
    if (!(containValidEmail($recievers) || (is_string($recievers) && isValidEmail($recievers))) || !isValidEmail("$sendFrom@$domainName")) {
        return false;
    }
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // SMTP::DEBUG_OFF = off (for production use)
    // SMTP::DEBUG_CLIENT = client messages
    // SMTP::DEBUG_SERVER = client and server messages
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    //Set the hostname of the mail server
    $mail->Host = $mailHost;
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 587;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    $mail->Username = $mailUser;
    //Password to use for SMTP authentication
    $mail->Password = $mailPassword;
    //Set who the message is to be sent from
    $mail->setFrom("$sendFrom@$domainName", $senderName);
    //Set an alternative reply-to address
    $mail->addReplyTo($mailUser, $replyToName);
    //Set who the message is to be sent to
    if (containValidEmail($recievers)) {
        for ($nnn = 0; $nnn < count($recievers); $nnn++) {
            if (isValidEmail($recievers[$nnn])) {
                $mail->addAddress($recievers[$nnn]);
            }
        }
    } elseif (is_string($recievers) && isValidEmail($recievers)) {
        $mail->addAddress($recievers);
    }

    //Set the subject line
    $mail->Subject = $subject;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($content);
    return !!$mail->Send();
}

$databaseName = "case";
if (mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$databaseName`;")) {
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`user` (
`id` INT NOT NULL AUTO_INCREMENT ,
`uniqueString` varchar(16) NOT NULL,
`status` varchar(2) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`guest` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`associatedUserId` varchar(16) NOT NULL,
`associatedAdminId` varchar(16) NOT NULL,
`ips` TEXT NOT NULL,
`userAgent` TEXT NOT NULL,
`dataOne` varchar(16) NOT NULL,
`dataTwo` varchar(16) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS `$databaseName`.`name` (
 `id` INT NOT NULL AUTO_INCREMENT ,
 `status` varchar(2) NOT NULL,
 `userId` varchar(16) NOT NULL,
 `first` varchar(200) NOT NULL,
 `last` varchar(200) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`emailVerification` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`emailId` varchar(16) NOT NULL,
`dataOne` varchar(16) NOT NULL,
`dataTwo` varchar(16) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`phoneNumberVerification` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`phoneNumberId` varchar(16) NOT NULL,
`dataOne` varchar(16) NOT NULL,
`dataTwo` varchar(16) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`passwordRecovery` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`subjectType` varchar(2) NOT NULL,
`subjectId` varchar(16) NOT NULL,
`dataOne` varchar(16) NOT NULL,
`dataTwo` varchar(16) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`product` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`uniqueString` varchar(16) NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productBrand` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productCategory` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productSize` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productColor` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productTitle` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productShortDescription` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productLongDescription` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productOfferScheme` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`price` varchar(100) NOT NULL,
`activeableBy` varchar(100) NOT NULL,
`minimumUnit` varchar(255) NOT NULL,
`maximumUnit` varchar(255) NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`productStock` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`productId` varchar(100) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`cartItem` (
 `id` INT NOT NULL AUTO_INCREMENT ,
 `status` varchar(2) NOT NULL,
 `guestId` varchar(255) NOT NULL,
 `productId` varchar(255) NOT NULL,
 `productOfferSchemeId` varchar(255) NOT NULL,
 `unitCount` varchar(255) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`username` (
 `id` INT NOT NULL AUTO_INCREMENT ,
 `status` varchar(2) NOT NULL,
 `subjectType` varchar(2) NOT NULL,
 `subjectId` varchar(16) NOT NULL,
 `value` varchar(16) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`email` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`subjectType` varchar(2) NOT NULL,
`subjectId` varchar(16) NOT NULL,
`value` varchar(255) NOT NULL,
`isPrimary` varchar(2) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`phoneNumber` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`subjectType` varchar(2) NOT NULL,
`subjectId` varchar(16) NOT NULL,
`code` varchar(255) NOT NULL,
`value` varchar(255) NOT NULL,
`isPrimary` varchar(2) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`address` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `status` varchar(2) NOT NULL,
    `isPrimary` varchar(2) NOT NULL,
    `subjectType` varchar(2) NOT NULL,
    `subjectId` varchar(16) NOT NULL,
    `zipcode` varchar(100) NOT NULL,
    `value` varchar(255) NOT NULL,
    `createdOn` varchar(255) NOT NULL,
    `updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS `$databaseName`.`password` (
 `id` INT NOT NULL AUTO_INCREMENT ,
 `status` varchar(2) NOT NULL,
 `subjectType` varchar(2) NOT NULL,
 `subjectId` varchar(16) NOT NULL,
 `value` varchar(255) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS `$databaseName`.`admin` (
 `id` INT NOT NULL AUTO_INCREMENT ,
 `status` varchar(2) NOT NULL,
 `userId` varchar(16) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS `$databaseName`.`session` (
   `id` INT NOT NULL AUTO_INCREMENT ,
   `status` varchar(2) NOT NULL,
   `subjectType` varchar(2) NOT NULL,
   `subjectId` varchar(16) NOT NULL,
   `dataOne` varchar(16) NOT NULL,
   `dataTwo` varchar(16) NOT NULL,
   `loginTime` varchar(255) NOT NULL,
   `logoutTime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS `$databaseName`.`profilePicture` (
   `id` INT NOT NULL AUTO_INCREMENT ,
   `status` varchar(2) NOT NULL,
   `userId` varchar(16) NOT NULL,
   `path` varchar(1000) NOT NULL,
   `contentType` varchar(255) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
 CREATE TABLE IF NOT EXISTS `$databaseName`.`brand` (
 `id` INT NOT NULL AUTO_INCREMENT ,
 `status` varchar(2) NOT NULL,
 `value` TEXT NOT NULL,
 `createdBy` varchar(255) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`category` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`size` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `$databaseName`.`color` (
`id` INT NOT NULL AUTO_INCREMENT ,
`status` varchar(2) NOT NULL,
`colorCode` TEXT NOT NULL,
`value` TEXT NOT NULL,
`createdBy` varchar(255) NOT NULL,
`createdOn` varchar(255) NOT NULL,
`updatedOn` varchar(255) NOT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS `$databaseName`.`productImage` (
   `id` INT NOT NULL AUTO_INCREMENT ,
   `status` varchar(2) NOT NULL,
   `userId` varchar(16) NOT NULL,
   `createdBy` varchar(255) NOT NULL,
   `path` varchar(1000) NOT NULL,
   `contentType` varchar(255) NOT NULL,
 `createdOn` varchar(255) NOT NULL,
 `updatedOn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;");
}
mysqli_close($conn);
$conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $databaseName);


// Read a file and display its content chunk by chunk
function readFileByChunkSize($filename, $chunkSize, $retbytes = TRUE)
{
    $buffer = '';
    $cnt    = 0;
    $handle = fopen($filename, 'rb');

    if ($handle === false) {
        return false;
    }

    while (!feof($handle)) {
        $buffer = fread($handle, $chunkSize);
        echo $buffer;
        ob_flush();
        flush();
        if ($retbytes) {
            $cnt += strlen($buffer);
        }
    }

    $status = fclose($handle);

    if ($retbytes && $status) {
        return $cnt; // return num. bytes delivered like readfile() does.
    }

    return $status;
}

function randomString($length)
{
    $finalString = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str = $chars[rand(0, $size - 1)];
        $finalString .= $str;
    }
    return $finalString;
}
function randomInteger($length)
{
    $finalString = "";
    $chars = "0123456789";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str = $chars[rand(0, $size - 1)];
        $finalString .= $str;
    }
    return (int)$finalString;
}

$currentGuest;
$currentlyLoggedInUserId;
$currentlyLoggedInUserDataOne;
$currentlyLoggedInUserDataTwo;
$currentlyLoggedInUserSession;
$currentlyLoggedInUser;

$currentlyLoggedInAdminId;
$currentlyLoggedInAdminDataOne;
$currentlyLoggedInAdminDataTwo;
$currentlyLoggedInAdminSession;
$currentlyLoggedInAdmin;
if (isset($_SESSION)) {
    if (isset($_SESSION['userId']) && isset($_SESSION['dataOne']) && isset($_SESSION['dataTwo'])) {
        $currentlyLoggedInUserId = $_SESSION['userId'];
        $currentlyLoggedInUserDataOne = $_SESSION['dataOne'];
        $currentlyLoggedInUserDataTwo = $_SESSION['dataTwo'];
        $currentlyLoggedInUserSession = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `session` WHERE `status` = 1 and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUserId' and `dataOne` = '$currentlyLoggedInUserDataOne' and `dataTwo` = '$currentlyLoggedInUserDataTwo' LIMIT 1"));
        if (!!$currentlyLoggedInUserSession) {
            $currentlyLoggedInUser = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `status` > 0 and `id` = '$currentlyLoggedInUserId' LIMIT 1"));

            if (!!$currentlyLoggedInUser && isset($_SESSION['adminId']) && isset($_SESSION['adminDataOne']) && isset($_SESSION['adminDataTwo'])) {

                $currentlyLoggedInAdminId = $_SESSION['adminId'];
                $currentlyLoggedInAdminDataOne = $_SESSION['adminDataOne'];
                $currentlyLoggedInAdminDataTwo = $_SESSION['adminDataTwo'];
                $currentlyLoggedInAdminSession = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `session` WHERE `status` = 1 and `subjectType` = 1 and `subjectId` = '$currentlyLoggedInAdminId' and `dataOne` = '$currentlyLoggedInAdminDataOne' and `dataTwo` = '$currentlyLoggedInAdminDataTwo' LIMIT 1"));
                if (!!$currentlyLoggedInAdminSession) {
                    $currentlyLoggedInAdmin = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `admin` WHERE `status` > 0 and `id` = '$currentlyLoggedInAdminId' LIMIT 1"));
                }
            }
        }
    }
    $associatedUserId = (isset($currentlyLoggedInUserId) && is_string($currentlyLoggedInUserId)) ? $currentlyLoggedInUserId : "";
    $associatedAdminId = (isset($currentlyLoggedInAdminId) && is_string($currentlyLoggedInAdminId)) ? $currentlyLoggedInAdminId : "";
    $supposedCreatedOn = time();
    if (isset($_SESSION['guestId']) && isset($_SESSION['guestDataOne']) && isset($_SESSION['guestDataTwo'])) {
        $guestId = $_SESSION['guestId'];
        $dataOne = $_SESSION['guestDataOne'];
        $dataTwo = $_SESSION['guestDataTwo'];
        $currentGuest = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `guest` WHERE `status` = 1 and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' and `id` = '$guestId' LIMIT 1"));
        if (!!$currentGuest) {
            $ips = json_decode($currentGuest->ips);
            array_push($ips, $_SERVER['REMOTE_ADDR']);
            $ips = json_encode(array_unique($ips));
            $toUpdate = [];
            if ($currentGuest->ips != $ips) {
                array_push($toUpdate, "`ips` = '$ips'");
            }
            if ($currentGuest->associatedUserId == "" && $currentGuest->associatedUserId != $associatedUserId) {
                array_push($toUpdate, "`associatedUserId` = '$associatedUserId'");
            }
            if (($currentGuest->associatedAdminId == "" || $currentGuest->associatedUserId == $associatedUserId) && $currentGuest->associatedAdminId != $associatedAdminId) {
                array_push($toUpdate, "`associatedAdminId` = '$associatedAdminId'");
            }
            if (count($toUpdate) > 0) {
                array_push($toUpdate, "`updatedOn` = '$supposedCreatedOn'");
                $updateFieldsString = join(",", $toUpdate);
                if (mysqli_query($conn, "UPDATE `guest` SET $updateFieldsString WHERE `id` = '$currentGuest->id';")) {
                    $currentGuest = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `guest` WHERE `status` = 1 and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' and `id` = '$guestId' LIMIT 1"));
                }
            }
        } else {
            $ips = json_encode([$_SERVER['REMOTE_ADDR']]);
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $dataOne = randomString(16);
            $dataTwo = randomString(16);
            if (mysqli_query($conn, "INSERT INTO `guest` (`id`, `status`, `associatedUserId`, `associatedAdminId`, `ips`, `userAgent`, `dataOne`, `dataTwo`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$associatedUserId', '$associatedAdminId', '$ips', '$userAgent', '$dataOne', '$dataTwo', '$supposedCreatedOn', '');")) {
                $currentGuest = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `guest` WHERE `status` = 1 and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' and `associatedUserId` = '$associatedUserId' and `associatedAdminId` = '$associatedAdminId' LIMIT 1"));
                if (!!$currentGuest) {
                    $_SESSION['guestId'] = $currentGuest->id;
                    $_SESSION['guestDataOne'] = $dataOne;
                    $_SESSION['guestDataTwo'] = $dataTwo;
                }
            }
        }
    } else {
        $ips = json_encode([$_SERVER['REMOTE_ADDR']]);
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $dataOne = randomString(16);
        $dataTwo = randomString(16);
        if (mysqli_query($conn, "INSERT INTO `guest` (`id`, `status`, `associatedUserId`, `associatedAdminId`, `ips`, `userAgent`, `dataOne`, `dataTwo`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$associatedUserId', '$associatedAdminId', '$ips', '$userAgent', '$dataOne', '$dataTwo', '$supposedCreatedOn', '');")) {
            $currentGuest = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `guest` WHERE `status` = 1 and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' and `associatedUserId` = '$associatedUserId' and `associatedAdminId` = '$associatedAdminId' LIMIT 1"));
            if (!!$currentGuest) {
                $_SESSION['guestId'] = $currentGuest->id;
                $_SESSION['guestDataOne'] = $dataOne;
                $_SESSION['guestDataTwo'] = $dataTwo;
            }
        }
    }
}
