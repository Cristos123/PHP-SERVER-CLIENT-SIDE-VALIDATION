<?php
include_once "connection.php";
$result = array("success" => false, "message" => "No data specified.");

function emailVerify($emailObject)
{
    global $conn;
    global $domainName;
    $verificationURL = false;
    if (!!$emailObject) {
        $emailId = $emailObject->id;
        $userId = $emailObject->subjectId;
        $dataOne = randomString(16);
        $dataTwo = randomString(16);
        $createdOn = time();
        if (mysqli_query($conn, "INSERT INTO `emailVerification` (`id`, `status`, `emailId`, `dataOne`, `dataTwo`, `createdOn`, `updatedOn`) VALUES (NULL, '2', '$emailId', '$dataOne', '$dataTwo', '$createdOn', '');")) {
            $verificationURL = "http://$domainName/verify-mail.php?userId=$userId&emailId=$emailId&dataOne=$dataOne&dataTwo=$dataTwo";
            sendMailWithHost("hello", [$emailObject->value], "Hello", "Email Verification", "<p>Click on this link to verify your email before you continue to login</p><br><a href=\"$verificationURL\">Verififcation</a>", "Ceo");
        }
    }
    return $verificationURL;
}
function phoneNumberVerify($phoneNumberObject)
{
    global $conn;
    global $domainName;
    $verificationURL = false;
    if (!!$phoneNumberObject) {
        $phoneNumberId = $phoneNumberObject->id;
        $userId = $phoneNumberObject->subjectId;
        $dataOne = randomInteger(3);
        $dataTwo = randomInteger(3);
        $createdOn = time();
        if (mysqli_query($conn, "INSERT INTO `phoneNumberVerification` (`id`, `status`, `phoneNumberId`, `dataOne`, `dataTwo`, `createdOn`, `updatedOn`) VALUES (NULL, '2', '$phoneNumberId', '$dataOne', '$dataTwo', '$createdOn', '');")) {
            $verificationURL = "http://$domainName/verify-phone.php?userId=$userId&phoneNumberId=$phoneNumberId&dataOne=$dataOne&dataTwo=$dataTwo";
            sendSMS(["$phoneNumberObject->code$phoneNumberObject->value"], "Hello", "Enter code $dataOne$dataTwo on the space provided or Click on $verificationURL to verify your phone number");
        }
    }
    return $verificationURL;
}

function getNumberFromString($phoneNumber)
{
    return str_replace(".", "", str_replace("+", "", str_replace("-", "", filter_var($phoneNumber, FILTER_SANITIZE_NUMBER_INT))));
}

function doNumberInsertion($userId, $countryCode, $phoneNumber, $createdOn, $result)
{
    global $conn;
    if (mysqli_query($conn, "INSERT INTO `phoneNumber` (`id`, `status`, `subjectType`, `subjectId`, `code`, `value`, `isPrimary`, `createdOn`, `updatedOn`) VALUES (NULL, '2', '0', '$userId', '$countryCode', '$phoneNumber', '0', '$createdOn', '');")) {
        $newPhoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `code` = '$countryCode' and `value` = '$phoneNumber' and `subjectType` = 0 and `subjectId` = '$userId' and `status` = 2 LIMIT 1"));
        if (!!$newPhoneNumberObject) {
            $possibleURL = phoneNumberVerify($newPhoneNumberObject);
            if (!!$possibleURL && is_string($possibleURL)) {
                $result = array_merge($result, array("success" => true, "message" => "Verification phone number has been sent to $countryCode$phoneNumber,check your sms inbox to activate the phone number for your account"));
            } else {
                $result = array_merge($result, array("success" => false, "message" => "Failed to send verification link Please try again later!"));
            }
        } else {
            $result = array_merge($result, array("success" => false, "message" => "Failed to find just inserted phone number Please try again later!"));
        }
    } else {
        $result = array_merge($result, array("success" => false, "message" => "Failed to insert new phone number to your account"));
    }
    return $result;
}


if (isset($_POST)) {

    $contentType = (null !== getallheaders() && isset(getallheaders()["Content-Type"])) ? getallheaders()["Content-Type"] : "";
    if (!$contentType) {
        $result = array_merge($result, array("success" => false, "message" => "no Content type Specified"));
    } else if (!is_string($contentType)) {
        $result = array_merge($result, array("success" => false, "message" => "Invalid Content type Specified"));
    } else {
        $contentType = strtolower($contentType);
        $data = (object) [];
        if (strpos($contentType, "application/json") !== false) {
            $json = file_get_contents('php://input');
            if (isset($json) && $json) {
                $data = json_decode($json);
            }
        } else if (strpos($contentType, "multipart/form-data") !== false) {
            $data = (object) array_merge($_POST, $_FILES);
        } else {
            $result = array_merge($result, array("success" => false, "message" => "Unhandled Content type Specified"));
        }
        if (isset($data) && isset($data->action) && !!$data) {
            switch ($data->action) {
                case "register": {
                        $username = strtolower(mysqli_real_escape_string($conn, $data->username));
                        $password = mysqli_real_escape_string($conn, $data->password);
                        $confirmPassword = mysqli_real_escape_string($conn, $data->confirmPassword);
                        $firstname = mysqli_real_escape_string($conn, $data->firstname);
                        $lastname = mysqli_real_escape_string($conn, $data->lastname);
                        $email = strtolower(mysqli_real_escape_string($conn, $data->email));

                        if (empty($firstname)  || !is_string($firstname) || strlen($firstname) < 3) {
                            $result = array_merge($result, array("success" => false, "message" => "Please first name can not be less than three(3) characters"));
                        } else if (strlen($firstname) > 30) {
                            $result = array_merge($result, array("success" => false, "message" => "Please first name cannot be more than 30 characters"));
                        } else if (empty($lastname)  || !is_string($lastname) || strlen($lastname) < 3) {
                            $result = array_merge($result, array("success" => false, "message" => "Please last name can not be less than three(3) characters"));
                        } else if (strlen($lastname) > 30) {
                            $result = array_merge($result, array("success" => false, "message" => "Please last name cannot be more than 30 characters"));
                        } elseif (empty($email) || !isValidEmail($email)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide valid email"));
                        } else if (empty($username)  || !is_string($username) || strlen($username) < 3 || !isValidUsername($username)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide username"));
                        } else if (empty($password) || !is_string($password) || strlen($password) < 8) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide password"));
                        } else if (empty($confirmPassword) || !is_string($confirmPassword) || strlen($confirmPassword) < 8) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide password"));
                        } else if ($password != $confirmPassword) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  confirm password must match password"));
                        } else if (!$data->checkbox) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  accept terms and condition"));
                        } else {
                            $usernameObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `username` WHERE `value` = '$username' AND `subjectType` = 0 LIMIT 1"));
                            $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$email' AND `subjectType` = 0 LIMIT 1"));

                            if (!!$usernameObject) {
                                $result = array_merge($result, array("success" => false, "message" => "Please username already exist"));
                            } else if (!!$emailObject) {
                                $result = array_merge($result, array("success" => false, "message" => "Please email already exist"));
                            } else {
                                $uniqueString = randomString(16);
                                $createdOn = time();
                                if (mysqli_query($conn, "INSERT INTO `user` (`id`, `uniqueString`, `status`, `createdOn`, `updatedOn`) VALUES (NULL, '$uniqueString', '2', '$createdOn', '');")) {
                                    $user = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `uniqueString` = '$uniqueString' and `createdOn` = '$createdOn' LIMIT 1"));

                                    $userId = $user->id;

                                    if (mysqli_query($conn, "INSERT INTO `email` (`id`, `status`, `subjectType`, `subjectId`, `value`, `isPrimary`, `createdOn`, `updatedOn`) VALUES (NULL, '2', '0', '$userId', '$email', '1', '$createdOn', '');")) {
                                        if (mysqli_query($conn, "INSERT INTO `name` (`id`, `status`, `userId`, `first`, `last`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$userId', '$firstname','$lastname', '$createdOn', '');")) {
                                            if (mysqli_query($conn, "INSERT INTO `username` (`id`, `status`, `subjectType`, `subjectId`, `value`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '0', '$userId', '$username', '$createdOn', '');")) {
                                                $password = md5($password); //encrypt the password before saving in the database
                                                if (mysqli_query($conn, "INSERT INTO `password` (`id`, `status`, `subjectType`, `subjectId`, `value`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '0', '$userId', '$password', '$createdOn', '');")) {
                                                    $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$email' AND `subjectType` = 0 and `status` = 2 LIMIT 1"));
                                                    if (!!$emailObject) {

                                                        $possibleURL = emailVerify($emailObject);
                                                        if (!!$possibleURL && is_string($possibleURL)) {
                                                            $result = array_merge($result, array("success" => true, "message" => "You are now signed up", "redirectTo" => "welcome.php?id=$userId&uniqueString=$uniqueString"));
                                                        } else {
                                                            $result = array_merge($result, array("success" => true, "message" => "Failed to send verification link Please try again later!", "redirectTo" => "welcome.php?id=$userId&uniqueString=$uniqueString"));
                                                        }
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Failed to  find just inserted email Please try again later!"));
                                                    }
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "error inserting password"));
                                                }
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "error inserting username"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "error inserting name"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "error inserting email"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "error inserting user"));
                                }
                            }
                        }
                        break;
                    }
                case "login": {

                        //Login code
                        $usernameOrEmail = strtolower(mysqli_real_escape_string($conn, $data->usernameOrEmail));
                        $password = mysqli_real_escape_string($conn, $data->password);

                        if (empty($usernameOrEmail)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide username"));
                        } else if (empty($password)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide password"));
                        } else {
                            //$password = md5($password);

                            //$query = "SELECT * FROM username WHERE username ='$username' ";
                            $canProceed = false;
                            $userId;
                            if (isValidEmail($usernameOrEmail)) {
                                $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$usernameOrEmail' AND `subjectType` = 0 and `status` = 1 LIMIT 1"));
                                if (!!$emailObject) {
                                    $canProceed = true;
                                    $userId = $emailObject->subjectId;
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "This email doesn't exist in our records"));
                                }
                            } else if (isValidUsername($usernameOrEmail)) {
                                $usernameObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `username` WHERE `value` = '$usernameOrEmail' AND `subjectType` = 0 and `status` = 1 LIMIT 1"));
                                if (!!$usernameObject) {
                                    $canProceed = true;
                                    $userId = $usernameObject->subjectId;
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "This username doesn't exist in our records"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please provide either a username or email"));
                            }
                            if ($canProceed && !!$userId) {
                                $password = md5($password);
                                $passwordObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `password` WHERE `value` = '$password' AND `status` = 1 AND `subjectType` = 0 and `subjectId` = '$userId' LIMIT 1"));
                                if (!!$passwordObject) {
                                    $dataOne = randomString(16);
                                    $dataTwo = randomString(16);
                                    $createdOn = time();
                                    if (mysqli_query($conn, "INSERT INTO `session` (`id`, `status`, `subjectType`, `subjectId`, `dataOne`, `dataTwo`, `loginTime`, `logoutTime`) VALUES (NULL, '1', '0', '$userId', '$dataOne', '$dataTwo', '$createdOn', '');")) {
                                        $_SESSION['userId'] = $userId;
                                        $_SESSION['dataOne'] = $dataOne;
                                        $_SESSION['dataTwo'] = $dataTwo;
                                        $result = array_merge($result, array("success" => true, "message" => "You are now logged in"));
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "error login user session"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Incorrect password"));
                                }
                            }
                        }
                        break;
                    }
                case "forget-password": {
                        //
                        $email = strtolower(mysqli_real_escape_string($conn, $data->email));

                        if (empty($email) || !isValidEmail($email)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide valid email"));
                        } else {
                            $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$email' AND `subjectType` = 0 and `status` = 1 LIMIT 1"));
                            if (!!$emailObject) {
                                $dataOne = randomString(16);
                                $dataTwo = randomString(16);
                                $createdOn = time();
                                mysqli_query($conn, "UPDATE `passwordRecovery` SET `status` = '0', `updatedOn` = '$createdOn'  WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$emailObject->subjectId';");
                                if (mysqli_query($conn, "INSERT INTO `passwordRecovery` (`id`, `status`, `subjectType`, `subjectId`, `dataOne`, `dataTwo`, `createdOn`, `updatedOn`) VALUES (NULL, '2', '0', '$emailObject->subjectId',  '$dataOne', '$dataTwo', '$createdOn', '');")) {
                                    $recoveryUrl = "http://$domainName/change-password.php?userId=$emailObject->subjectId&dataOne=$dataOne&dataTwo=$dataTwo";
                                    sendMailWithHost("hello", [$emailObject->value], "Hello", "Password Recovery", "<p>You asked to reset your password</p><br><a href=\"$recoveryUrl\">Change Password</a>", "Ceo");
                                    $result = array_merge($result, array("success" => true, "message" => "Please check your email for password resent link"));
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Unable to insert password recovery"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "This email doesn't exist in our records"));
                            }
                        }
                        break;
                    }
                case "change-password": {
                        $password = mysqli_real_escape_string($conn, $data->password);
                        $confirmPassword = mysqli_real_escape_string($conn, $data->confirmPassword);
                        $userId = mysqli_real_escape_string($conn, $data->userId);
                        $passwordRecoveryId = mysqli_real_escape_string($conn, $data->passwordRecoveryId);
                        $dataOne = mysqli_real_escape_string($conn, $data->dataOne);
                        $dataTwo = mysqli_real_escape_string($conn, $data->dataTwo);
                        if (empty($password) || !is_string($password) || strlen($password) < 8) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide password"));
                        } else if (empty($confirmPassword) || !is_string($confirmPassword) || strlen($confirmPassword) < 8) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide password"));
                        } else if ($password != $confirmPassword) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  confirm password must match password"));
                        } else if (empty($userId) || !is_string($userId)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  wrong user"));
                        } else if (empty($userId) || !is_string($userId)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  wrong user"));
                        } else if (empty($passwordRecoveryId) || !is_string($passwordRecoveryId)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  wrong user id"));
                        } else if (empty($dataOne) || !is_string($dataOne)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  wrong user data input"));
                        } else if (empty($dataTwo) || !is_string($dataTwo)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please  cant find you in our database"));
                        } else {
                            $userObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `status` > 0 and `id` = '$userId' LIMIT 1"));
                            $passworRecoveryObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `passwordRecovery` WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$userId' and `id` = ' $passwordRecoveryId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' LIMIT 1"));
                            if (!!$userObject) {
                                if (!!$passworRecoveryObject) {
                                    $createdOn = time();
                                    if (mysqli_query($conn, "UPDATE `password` SET `status` = '0',`updatedOn` = '$createdOn' WHERE `subjectType` = 0 and `subjectId` = '$userObject->id';")) {
                                        $pass = md5($password);
                                        if (mysqli_query($conn, "INSERT INTO `password` (`id`, `status`, `subjectType`, `subjectId`, `value`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '0', '$userId', '$pass', '$createdOn', '');")) {
                                            mysqli_query($conn, "UPDATE `passwordRecovery` SET `status` = '1',`updatedOn` = '$createdOn' WHERE `status` > 0 and `subjectType` = 0 and `subjectId` = '$userId' and `id` = ' $passwordRecoveryId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo';");
                                            $dataOne = randomString(16);
                                            $dataTwo = randomString(16);
                                            $createdOn = time();
                                            if (mysqli_query($conn, "INSERT INTO `session` (`id`, `status`, `subjectType`, `subjectId`, `dataOne`, `dataTwo`, `loginTime`, `logoutTime`) VALUES (NULL, '1', '0', '$userId', '$dataOne', '$dataTwo', '$createdOn', '');")) {
                                                $_SESSION['userId'] = $userId;
                                                $_SESSION['dataOne'] = $dataOne;
                                                $_SESSION['dataTwo'] = $dataTwo;
                                                $result = array_merge($result, array("success" => true, "message" => "Password changed succesfully, You are now logged in"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "error login user session"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "password recovery is not successful"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Unable to update password Please try again later!"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "No account found"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please  username does not exist"));
                            }
                        }
                        break;
                    }
                case "welcome": {
                        //$uniqueString = randomString(16);
                        //$userId = "";


                        $userId = mysqli_real_escape_string($conn, $data->userId);
                        $uniqueString = mysqli_real_escape_string($conn, $data->uniqueString);
                        if (!$userId) {
                            $result = array_merge($result, array("success" => false, "message" => "This User doesn't exist in our records"));
                        } elseif (!$uniqueString) {
                            $result = array_merge($result, array("success" => false, "message" => "This is wrong user in our records"));
                        } else {
                            $userObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `id` = '$userId' and `uniqueString` = '$uniqueString' LIMIT 1"));
                            if (isset($userObject) && !!$userObject && isset($userObject->status) && $userObject->status == '2') {

                                $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `subjectType` = 0 and `subjectId` = '$userObject->id' AND `status` = 2 LIMIT 1"));

                                if (!!$emailObject) {
                                    $possibleURL = emailVerify($emailObject);
                                    if (!!$possibleURL && is_string($possibleURL)) {
                                        $result = array_merge($result, array("success" => true, "message" => "Email sent"));
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Email not sent"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "We couldn't find any unverified email for this user"));
                                }
                            } else if (isset($userObject) && !!$userObject && isset($userObject->status) && $userObject->status == '1') {
                                $result = array_merge($result, array("success" => false, "message" => "User is already verified"));
                            } else if (isset($userObject) && !!$userObject && isset($userObject->status) && $userObject->status == '0') {
                                $result = array_merge($result, array("success" => false, "message" => "User is already deleted"));
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "User doesn't exist"));
                            }
                        }
                        break;
                    }
                case "admin-login": {
                        //admin Login code
                        $usernameOrEmail = strtolower(mysqli_real_escape_string($conn, $data->usernameOrEmail));
                        $password = mysqli_real_escape_string($conn, $data->password);

                        if (empty($usernameOrEmail)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide username"));
                        } else if (empty($password)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide password"));
                        } else {
                            $anyActiveAdminObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `admin` WHERE `status` = 1 LIMIT 1"));
                            if (!!$anyActiveAdminObject) {
                                //$password = md5($password);

                                //userId,userId,userId,userId
                                //$query = "SELECT * FROM username WHERE username ='$username' ";
                                $canProceed = false;
                                $adminId;
                                if (isValidEmail($usernameOrEmail)) {
                                    $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$usernameOrEmail' AND `subjectType` = 1 and `status` = 1 LIMIT 1"));
                                    if (!!$emailObject) {
                                        $canProceed = true;
                                        $adminId = $emailObject->subjectId;
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "This email doesn't exist in our records"));
                                    }
                                } else if (isValidUsername($usernameOrEmail)) {
                                    $usernameObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `username` WHERE `value` = '$usernameOrEmail' AND `subjectType` = 1 and `status` = 1 LIMIT 1"));
                                    if (!!$usernameObject) {
                                        $canProceed = true;
                                        $adminId = $usernameObject->subjectId;
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "This username doesn't exist in our records"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please provide either a username or email"));
                                }
                                if ($canProceed && !!$adminId) {
                                    $adminObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `admin` WHERE `id` = '$adminId' and  `status` = 1 LIMIT 1"));
                                    if (!!$adminObject) {
                                        $password = md5($password);
                                        $passwordObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `password` WHERE `value` = '$password' AND `status` = 1 AND `subjectType` = 1 and `subjectId` = '$adminId' LIMIT 1"));
                                        if (!!$passwordObject) {
                                            $dataOne = randomString(16);
                                            $dataTwo = randomString(16);
                                            $createdOn = time();
                                            if (mysqli_query($conn, "INSERT INTO `session` (`id`, `status`, `subjectType`, `subjectId`, `dataOne`, `dataTwo`, `loginTime`, `logoutTime`) VALUES (NULL, '1', '1', '$adminId', '$dataOne', '$dataTwo', '$createdOn', '');")) {
                                                $_SESSION['adminId'] = $adminId;
                                                $_SESSION['adminDataOne'] = $dataOne;
                                                $_SESSION['adminDataTwo'] = $dataTwo;


                                                $userDataOne = randomString(16);
                                                $userDataTwo = randomString(16);
                                                $createdOn = time();
                                                if (mysqli_query($conn, "INSERT INTO `session` (`id`, `status`, `subjectType`, `subjectId`, `dataOne`, `dataTwo`, `loginTime`, `logoutTime`) VALUES (NULL, '1', '0', '$adminObject->userId', '$userDataOne', '$userDataTwo', '$createdOn', '');")) {
                                                    $_SESSION['userId'] = $adminObject->userId;
                                                    $_SESSION['dataOne'] = $userDataOne;
                                                    $_SESSION['dataTwo'] = $userDataTwo;
                                                    $result = array_merge($result, array("success" => true, "message" => "You have successfully logged in as an admin"));
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "error login user session"));
                                                }
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "error login user session"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Incorrect password"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Admin with that credential is no longer active"));
                                    }
                                }
                            } else {
                                if (isset($currentlyLoggedInUser) && !!$currentlyLoggedInUser) {
                                    if (isValidEmail($usernameOrEmail) || isValidUsername($usernameOrEmail)) {
                                        $createdOn = time();
                                        if (mysqli_query($conn, "INSERT INTO `admin` (`id`, `status`, `userId`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$currentlyLoggedInUser->id', '$createdOn', '');")) {
                                            $justInsertedAdmin = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `admin` WHERE `userId` = '$currentlyLoggedInUser->id' and `status` = 1 LIMIT 1"));
                                            if (!!$justInsertedAdmin) {
                                                $canProceed = false;
                                                if (isValidEmail($usernameOrEmail)) {
                                                    if (mysqli_query($conn, "INSERT INTO `email` (`id`, `status`, `subjectType`, `subjectId`, `value`, `isPrimary`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '1', '$justInsertedAdmin->id', '$usernameOrEmail', '1', '$createdOn', '');")) {
                                                        $canProceed = true;
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Unable to insert email for admin"));
                                                    }
                                                } else {
                                                    if (mysqli_query($conn, "INSERT INTO `username` (`id`, `status`, `subjectType`, `subjectId`, `value`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '1', '$justInsertedAdmin->id', '$usernameOrEmail', '$createdOn', '');")) {
                                                        $canProceed = true;
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Unable to insert username for admin"));
                                                    }
                                                }
                                                if ($canProceed) {
                                                    $pass = md5($password);
                                                    if (mysqli_query($conn, "INSERT INTO `password` (`id`, `status`, `subjectType`, `subjectId`, `value`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '1', '$justInsertedAdmin->id', '$pass', '$createdOn', '');")) {

                                                        $dataOne = randomString(16);
                                                        $dataTwo = randomString(16);
                                                        $createdOn = time();
                                                        if (mysqli_query($conn, "INSERT INTO `session` (`id`, `status`, `subjectType`, `subjectId`, `dataOne`, `dataTwo`, `loginTime`, `logoutTime`) VALUES (NULL, '1', '1', '$justInsertedAdmin->id', '$dataOne', '$dataTwo', '$createdOn', '');")) {
                                                            $_SESSION['adminId'] = $justInsertedAdmin->id;
                                                            $_SESSION['adminDataOne'] = $dataOne;
                                                            $_SESSION['adminDataTwo'] = $dataTwo;
                                                            $result = array_merge($result, array("success" => true, "message" => "You have successfully created the first admin on this app"));
                                                        } else {
                                                            $result = array_merge($result, array("success" => false, "message" => "error login user session"));
                                                        }
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Unable to insert passwor for admin"));
                                                    }
                                                }
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Unable to find just inserted admin"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "error login user session"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Please provide either a username or email"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please login as a regular user so you canbe upgrade to been an admin"));
                                }
                            }
                        }
                        //userId,userId,userId,userId
                        break;
                    }
                case "profile-upload": {
                        if (!$currentlyLoggedInUser) {
                            $result = array_merge($result, array("success" => false, "message" => "Please login before continue."));
                        } else if (!isset($data->profilePicture) || !isset($data->profilePicture["tmp_name"])) {
                            //Unable to find image uploaded
                        } else {
                            $newFileName = 'profile_' . $currentlyLoggedInUser->id . '_' . time() . '_' . $data->profilePicture["name"];
                            $target_dir = "uploads/";
                            $target_file = $target_dir . basename($newFileName);

                            if ($data->profilePicture['size'] > 300000) {
                                $result = array_merge($result, array("success" => false, "message" => "Please Image size should not be greater than 300kb"));
                            } else {
                                //$usernameObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `username` WHERE `value` = '$username' AND `subjectType` = 0 and`status` = 1 LIMIT 1"));
                                if (move_uploaded_file($data->profilePicture["tmp_name"], $target_file)) {
                                    $imageContentType = $data->profilePicture["type"];
                                    $createdOn = time();
                                    if (mysqli_query($conn, "UPDATE `profilePicture` SET `status` = '0', `updatedOn` = '$createdOn'  WHERE `status` = '1' and `userId` = '$currentlyLoggedInUser->id';")) {
                                        if (mysqli_query($conn, "INSERT INTO `profilePicture` (`id`, `status`, `userId`, `path`, `contentType`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$currentlyLoggedInUser->id', '$target_file', '$imageContentType', '$createdOn', '');")) {
                                            $result = array_merge($result, array("success" => true, "message" => "Upload successful"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Please there was error inserting your picture"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Unable to remove old profile picture"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please there was uploading your file"));
                                }
                            }
                        }
                        break;
                    }
                case "add-address": {
                        $address = mysqli_real_escape_string($conn, $data->address);
                        $zipcode = mysqli_real_escape_string($conn, $data->zipcode);
                        if (!(!empty($zipcode) && is_string($zipcode) && strlen($zipcode) >= 5)) {
                            $zipcode = "";
                        }
                        if (empty($address) || !is_string($address)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide contact address"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $userExistingAddressSameAsNew = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `address` WHERE `status` = 1 and `value` = '$address' and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' LIMIT 1"));
                                if (!!$userExistingAddressSameAsNew) {
                                    $result = array_merge($result, array("success" => false, "message" => "This address seems to be active for you already"));
                                } else {
                                    $userExistingPrimaryAddress = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `address` WHERE `status` = 1 and `isPrimary` = '1' and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' LIMIT 1"));
                                    $addressPrimaryValue = 1;
                                    if (!!$userExistingPrimaryAddress) {
                                        $addressPrimaryValue = 0;
                                    }
                                    if (mysqli_query($conn, "INSERT INTO `address` (`id`, `status`, `isPrimary`, `subjectType`, `subjectId`, `zipcode`, `value`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$addressPrimaryValue', '0', '$currentlyLoggedInUser->id', '$zipcode', '$address', '$createdOn', '');")) {
                                        $result = array_merge($result, array("success" => true, "message" => "Address added successfully"));
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Error while saving new address"));
                                    }
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        break;
                    }
                case "remove-address": {
                        $addressId = mysqli_real_escape_string($conn, $data->addressId);
                        if (empty($addressId) || !is_numeric($addressId) || strlen($addressId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Email identifier"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $addressObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `address` WHERE `id` = '$addressId' and `subjectType` = 0 LIMIT 1"));
                                if (!!$addressObject) {
                                    if ($addressObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($addressObject->isPrimary == 1) {
                                            $result = array_merge($result, array("success" => false, "message" => "This address is primary to your account and can not be removed"));
                                        } else {
                                            if ($addressObject->status == 1) {
                                                if (mysqli_query($conn, "UPDATE `address` SET `status` = '0', `updatedOn` = '$createdOn' WHERE `id` = '$addressObject->id';")) {
                                                    $result = array_merge($result, array("success" => true, "message" => "Successfully removed address"));
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Failed while updating address to reflect removal"));
                                                }
                                            } else if ($addressObject->status == 0) {
                                                $result = array_merge($result, array("success" => false, "message" => "The specified address has been removed from this account already"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "The specified address has an unidentified state"));
                                            }
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "The specified address wasn't added to this account"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Unable to find address with that identifier"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        break;
                    }

                case "make-primary-address": {
                        $addressId = mysqli_real_escape_string($conn, $data->addressId);
                        if (empty($addressId) || !is_numeric($addressId) || strlen($addressId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Email identifier"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $addressObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `address` WHERE `id` = '$addressId' and `subjectType` = 0 LIMIT 1"));
                                if (!!$addressObject) {
                                    if ($addressObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($addressObject->status == 1) {
                                            if ($addressObject->isPrimary == 1) {
                                                $result = array_merge($result, array("success" => false, "message" => "This address is already primary for your account"));
                                            } else {
                                                $userCurrentPrimaryAddressObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `address` WHERE `isPrimary` = 1 and `status` = 1 and `subjectId` = '$addressObject->subjectId' and `subjectType` = '$addressObject->subjectType'  LIMIT 1"));
                                                if (!!$userCurrentPrimaryAddressObject) {
                                                    if (mysqli_query($conn, "UPDATE `address` SET `isPrimary` = '1', `updatedOn` = '$createdOn'  WHERE `status` = 1 and `subjectType` = 0 and `id` = '$addressObject->id';")) {
                                                        if (mysqli_query($conn, "UPDATE `address` SET `isPrimary` = '0', `updatedOn` = '$createdOn'  WHERE `status` = 1 and `subjectType` = 0 and `id` = '$userCurrentPrimaryAddressObject->id';")) {
                                                            $result = array_merge($result, array("success" => true, "message" => "Successfully made address primary"));
                                                        } else {
                                                            $result = array_merge($result, array("success" => false, "message" => "Unable to remove previous primary adress"));
                                                        }
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Unable to make address primary"));
                                                    }
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "You do not have an existing primary address"));
                                                }
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "The specified address wasn't added to this account"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Can't to find address with that identifier"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Unable to find address with that identifier"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        break;
                    }
                case "edit-address": {
                        $addressId = mysqli_real_escape_string($conn, $data->addressId);
                        $address = mysqli_real_escape_string($conn, $data->address);
                        $zipcode = mysqli_real_escape_string($conn, $data->zipcode);
                        if (!(!empty($zipcode) && is_string($zipcode) && strlen($zipcode) >= 5)) {
                            $zipcode = "";
                        }
                        if (empty($addressId) || !is_numeric($addressId) || strlen($addressId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Email identifier"));
                        } else if (empty($address) || !is_string($address)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide contact address"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $addressObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `address` WHERE `id` = '$addressId' and `subjectType` = 0 LIMIT 1"));
                                if (!!$addressObject) {
                                    if ($addressObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($addressObject->status == 1) {
                                            if (($addressObject->value == $address) && ($addressObject->zipcode == $zipcode)) {
                                                $result = array_merge($result, array("success" => false, "message" => "Address seems to be unchanged"));
                                            } else {
                                                if (mysqli_query($conn, "UPDATE `address` SET `status` = '0', `updatedOn` = '$createdOn' WHERE `id` = '$addressObject->id';")) {
                                                    if (mysqli_query($conn, "INSERT INTO `address` (`id`, `status`, `isPrimary`, `subjectType`, `subjectId`, `zipcode`, `value`, `createdOn`, `updatedOn`) VALUES (NULL, '$addressObject->status', '$addressObject->isPrimary', '$addressObject->subjectType', '$addressObject->subjectId', '$zipcode', '$address', '$createdOn', '');")) {
                                                        $result = array_merge($result, array("success" => true, "message" => "Address updated successfully"));
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Error while saving new address"));
                                                    }
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Failed while updating address to reflect removal"));
                                                }
                                            }
                                        } else if ($addressObject->status == 0) {
                                            $result = array_merge($result, array("success" => false, "message" => "The specified address has been removed from this account already"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "The specified address has an unidentified state"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "The specified address wasn't added to this account"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Unable to find address with that identifier"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        break;
                    }
                case "verify-phone-number": {
                        //userId,userId,userId,userId,userId,userId,userId,userId
                        $phoneNumberId = mysqli_real_escape_string($conn, $data->phoneNumberId);
                        $verificationCode =  mysqli_real_escape_string($conn, $data->verificationCode);
                        if (empty($phoneNumberId) || !is_numeric($phoneNumberId)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please specify phone number to verify"));
                        } else if (empty($verificationCode) ||  strlen($verificationCode) != 6 || !is_numeric($verificationCode)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide valid verification code"));
                        } else {
                            $dataOne = substr("$verificationCode", 0, 3);
                            $dataTwo = substr("$verificationCode", 3, 3);
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $phoneNumberVerificationObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumberVerification` WHERE `status` = 2 and `phoneNumberId` = '$phoneNumberId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' LIMIT 1"));
                                if (!!$phoneNumberVerificationObject) {
                                    $phoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' and `id` = '$phoneNumberId' LIMIT 1"));
                                    if (!!$phoneNumberObject) {
                                        $primaryValue = 1;
                                        $userExistingPrimaryPhoneNumber = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `status` = 1 and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' and `isPrimary` = 1 LIMIT 1"));
                                        if (!!$userExistingPrimaryPhoneNumber) {
                                            $primaryValue = 0;
                                        }
                                        mysqli_query($conn, "UPDATE `phoneNumber` SET `status` = '0', `updatedOn` = '$createdOn' WHERE `subjectType` = 0 and `code` = '$phoneNumberObject->code' and `value` = '$phoneNumberObject->value' and `id` <> '$phoneNumberId';");
                                        if (mysqli_query($conn, "UPDATE `phoneNumber` SET `status` = '1',`isPrimary` = '$primaryValue', `updatedOn` = '$createdOn' WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' and `id` = '$phoneNumberId';")) {
                                            if (mysqli_query($conn, "UPDATE `phoneNumberVerification` SET `status` = '1', `updatedOn` = '$createdOn' WHERE `status` = 2 and `phoneNumberId` = '$phoneNumberId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo';")) {
                                                $result = array_merge($result, array("success" => true, "message" => "Successfully activated phone number"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Please try again the phone verification failed to update."));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Phone number failed to update  and reflect verification"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Unable to get phone number"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Invalid verification code"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        //userId,userId,userId,userId,userId,userId,userId,userId
                        break;
                    }

                case "add-phone-number": {
                        $phoneNumber = mysqli_real_escape_string($conn, $data->phoneNumber);
                        $countryCode =  mysqli_real_escape_string($conn, $data->countryCode);
                        if (empty($phoneNumber) || strlen($phoneNumber) < 10 || strlen($phoneNumber) > 14 || !getNumberFromString($phoneNumber)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide phone number and must not greater than 14 digits"));
                        } else if (empty($countryCode) ||  strlen($countryCode) > 6 || !is_numeric($countryCode)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide country code"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $existingPhoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `code` = '$countryCode' and `value` = '$phoneNumber' and `subjectType` = 0  LIMIT 1"));
                                if (!!$existingPhoneNumberObject) {
                                    if ($existingPhoneNumberObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($existingPhoneNumberObject->status == 0) {
                                            $result = array_merge($result, array("success" => false, "message" => "You have already deleted this phone number and cannot re-add it."));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "You have this phone number added to your account already"));
                                        }
                                    } else if ($existingPhoneNumberObject->status == 1) {
                                        $result = array_merge($result, array("success" => false, "message" => "Phone number is already added to and verified on another account"));
                                    } else {
                                        $result = doNumberInsertion($currentlyLoggedInUser->id, $countryCode, $phoneNumber, $createdOn, $result);
                                    }
                                } else {
                                    $result = doNumberInsertion($currentlyLoggedInUser->id, $countryCode, $phoneNumber, $createdOn, $result);
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        //email,email,email,newEmail,newEmail,phoneNumberObject,phoneNumberObject,phoneNumberObject
                        break;
                    }
                case "add-product": {
                        $pname = strtolower(mysqli_real_escape_string($conn, $data->pname));
                        $shortDescription = mysqli_real_escape_string($conn, $data->shortDescription);
                        $longDescription = mysqli_real_escape_string($conn, $data->longDescription);

                        if (empty($pname) || !is_string($pname) || strlen($pname) < 2) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input product name"));
                        } else if (empty($shortDescription) || !is_string($shortDescription) || strlen($shortDescription) < 10) {
                            $result = array_merge($result, array("success" => false, "message" => "Please short description name must less than ten characters"));
                        } else if (empty($longDescription) || !is_string($longDescription) || strlen($longDescription) < 20) {
                            $result = array_merge($result, array("success" => false, "message" => "Please long description name must not less than twenty characters"));
                        } else {
                            //status 0: eleted,1:active,2:disabled
                            $uniqueString = randomString(16);
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                if (mysqli_query($conn, "INSERT INTO `product` (`id`, `status`, `uniqueString`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL,  '2','$uniqueString','$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                    $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$uniqueString' and `createdOn` = '$createdOn' LIMIT 1"));
                                    if (!!$productObject) {
                                        $productId = $productObject->id;
                                        if (mysqli_query($conn, "INSERT INTO `productTitle` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$productId', '$pname', '$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                            if (mysqli_query($conn, "INSERT INTO `productShortDescription` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$productId', '$shortDescription', '$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                                if (mysqli_query($conn, "INSERT INTO `productLongDescription` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$productId', '$longDescription', '$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                                    $result = array_merge($result, array("success" => true, "message" => "Product created successfully", "redirectTo" => "edit-product.php?id=$productId"));
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Error while saving product long description name"));
                                                }
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Error while saving product short description name"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Error while saving product name"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Unable to find just inserted product"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Error while saving product"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please Login as admin before continue"));
                            }
                        }
                        break;
                    }
                case "add-to-cart": {
                        $productId = mysqli_real_escape_string($conn, $data->productId);
                        //$currentGuest
                        if (!$currentGuest) {
                            $result = array_merge($result, array("success" => false, "message" => "Current guest not available."));
                        } else if (!$productId) {
                            $result = array_merge($result, array("success" => false, "message" => "No Product identifier specified"));
                        } else {
                            $createdOn = time();
                            $cartObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `cartItem` WHERE `guestId` = '$currentGuest->id' and `status` > 0 and `productId`= '$productId' LIMIT 1"));
                            if (!!$cartObject) {
                                $newUnitCount = intval($cartObject->unitCount) + 1;
                                if (mysqli_query($conn, "UPDATE `cartItem` SET `unitCount` = '$newUnitCount',`updatedOn` = '$createdOn' WHERE `id` = '$cartObject->id';")) {
                                    $result = array_merge($result, array("success" => true, "message" => "Cart item updated"));
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Unable to update cart item"));
                                }
                            } else {
                                if (mysqli_query($conn, "INSERT INTO `cartItem` (`id`, `status`, `guestId`,`productId`,`productOfferSchemeId`,`unitCount`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$currentGuest->id', '$productId', '', '1', '$createdOn', '');")) {
                                    $result = array_merge($result, array("success" => true, "message" => "item inserted into cart"));
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Unable to insert item into cart"));
                                }
                            }
                        }
                        break;
                    }
                case "add-category": {
                        $manageCategory = mysqli_real_escape_string($conn, $data->manageCategory);
                        if (empty($manageCategory) || !is_string($manageCategory) || strlen($manageCategory) < 2) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input category name"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                if (mysqli_query($conn, "INSERT INTO `category` (`id`, `status`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL,  '1','$manageCategory','$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                    $result = array_merge($result, array("success" => true, "message" => "Category created successfully"));
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Error while saving category"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case  "add-size": {
                        $size = mysqli_real_escape_string($conn, $data->size);
                        if (empty($size) || !is_string($size) || strlen($size) < 2) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input category name"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                if (mysqli_query($conn, "INSERT INTO `size` (`id`, `status`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL,  '1','$size','$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                    $result = array_merge($result, array("success" => true, "message" => "size created successfully"));
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Error while saving size"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "add-brand": {
                        $brand = mysqli_real_escape_string($conn, $data->brand);
                        if (empty($brand) || !is_string($brand) || strlen($brand) < 2) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input brand"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                if (mysqli_query($conn, "INSERT INTO `brand` (`id`, `status`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL,  '1','$brand','$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                    $result = array_merge($result, array("success" => true, "message" => "Brand created successfully"));
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Error while saving Brand"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "add-color": {
                        $colorName = mysqli_real_escape_string($conn, $data->colorName);
                        $colorCode = mysqli_real_escape_string($conn, $data->colorCode);
                        if (empty($colorName) || !is_string($colorName) || strlen($colorName) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input color name"));
                        } else if (empty($colorCode) || !is_string($colorCode) || strlen($colorCode) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input color code"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                if (mysqli_query($conn, "INSERT INTO `color` (`id`, `status`, `colorCode`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL,  '1','$colorCode','$colorName','$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                    $result = array_merge($result, array("success" => true, "message" => "Color created successfully"));
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Error while insert color"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "edit-size": {
                        $size = mysqli_real_escape_string($conn, $data->size);
                        $sizeId = mysqli_real_escape_string($conn, $data->sizeId);
                        if (empty($size) || !is_string($size) || strlen($size) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input size name"));
                        } else if (!is_int(intval($sizeId)) || !strlen(strval($sizeId))) {
                            $result = array_merge($result, array("success" => false, "message" => "Please size id is not matched"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $sizeObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `size` WHERE `id` = '$sizeId' LIMIT 1"));
                                if (!!$sizeObject) {
                                    if ($sizeObject->status == 1) {
                                        if ($sizeObject->value == $size) {
                                            $result = array_merge($result, array("success" => false, "message" => "Size name unchanged"));
                                        } else {
                                            if (mysqli_query($conn, "UPDATE `size` SET `value` = '$size',`updatedOn` = '$createdOn' WHERE `id` = '$sizeObject->id';")) {
                                                $result = array_merge($result, array("success" => true, "message" => "Size succesfully updated"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Unable to update size"));
                                            }
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Size is no longer active"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Size with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "deleted-size": {
                        $sizeId = mysqli_real_escape_string($conn, $data->sizeId);
                        if (!is_int(intval($sizeId)) || !strlen(strval($sizeId))) {
                            $result = array_merge($result, array("success" => false, "message" => "Please size id is not matched"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $sizeObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `size` WHERE `id` = '$sizeId' LIMIT 1"));
                                if (!!$sizeObject) {
                                    if ($sizeObject->status = 1) {
                                        if (mysqli_query($conn, "UPDATE `size` SET `status` = 0,`updatedOn` = '$createdOn' WHERE `id` = '$sizeObject->id';")) {
                                            $result = array_merge($result, array("success" => true, "message" => "Size succesfully deleted"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Unable to delete size"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Size is already inactive"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Size with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "edit-color": {
                        $colorName = mysqli_real_escape_string($conn, $data->colorName);
                        $colorCode = mysqli_real_escape_string($conn, $data->colorCode);
                        $colorId = mysqli_real_escape_string($conn, $data->colorId);
                        if (empty($colorName) || !is_string($colorName) || strlen($colorName) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input color name"));
                        } else if (empty($colorCode) || !is_string($colorCode) || strlen($colorCode) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input color code"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $colorObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `color` WHERE `id` = '$colorId' LIMIT 1"));
                                if (!!$colorObject) {
                                    if ($colorObject->status == 1) {
                                        if (($colorObject->value == $colorName) && ($colorObject->colorCode == $colorCode)) {
                                            $result = array_merge($result, array("success" => false, "message" => "Color name unchanged"));
                                        } else {
                                            if (mysqli_query($conn, "UPDATE `color` SET `value` = '$colorName',`updatedOn` = '$createdOn' WHERE `id` = '$colorObject->id';")) {
                                                $result = array_merge($result, array("success" => true, "message" => "Color succesfully updated"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Unable to update color"));
                                            }
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Color is no longer active"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Color with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "deleted-color": {
                        $colorId = mysqli_real_escape_string($conn, $data->colorId);
                        if (!is_int(intval($colorId)) || !strlen(strval($colorId))) {
                            $result = array_merge($result, array("success" => false, "message" => "Please color id is not matched"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $colorObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `color` WHERE `id` = '$colorId' LIMIT 1"));
                                if (!!$colorObject) {
                                    if ($colorObject->status = 1) {
                                        if (mysqli_query($conn, "UPDATE `color` SET `status` = 0,`updatedOn` = '$createdOn' WHERE `id` = '$colorObject->id';")) {
                                            $result = array_merge($result, array("success" => true, "message" => "Color succesfully deleted"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Unable to delete color"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Color is already inactive"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Color with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "edit-brand": {
                        $brand = mysqli_real_escape_string($conn, $data->brand);
                        $brandId = mysqli_real_escape_string($conn, $data->brandId);
                        if (empty($brand) || !is_string($brand) || strlen($brand) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input brand name"));
                        } else if (!is_int(intval($brandId)) || !strlen(strval($brandId))) {
                            $result = array_merge($result, array("success" => false, "message" => "Please brand id is not matched"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $brandObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `brand` WHERE `id` = '$brandId' LIMIT 1"));
                                if (!!$brandObject) {
                                    if ($brandObject->status == 1) {
                                        if ($brandObject->value == $brand) {
                                            $result = array_merge($result, array("success" => false, "message" => "Brand name unchanged"));
                                        } else {
                                            if (mysqli_query($conn, "UPDATE `brand` SET `value` = '$brand',`updatedOn` = '$createdOn' WHERE `id` = '$brandObject->id';")) {
                                                $result = array_merge($result, array("success" => true, "message" => "Brand succesfully updated"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Unable to update brand"));
                                            }
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Brand is no longer active"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Brand with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "deleted-brand": {
                        $brandId = mysqli_real_escape_string($conn, $data->brandId);
                        if (!is_int(intval($brandId)) || !strlen(strval($brandId))) {
                            $result = array_merge($result, array("success" => false, "message" => "Please brand id is not matched"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $brandObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `brand` WHERE `id` = '$brandId' LIMIT 1"));
                                if (!!$brandObject) {
                                    if ($brandObject->status = 1) {
                                        if (mysqli_query($conn, "UPDATE `brand` SET `status` = 0,`updatedOn` = '$createdOn' WHERE `id` = '$brandObject->id';")) {
                                            $result = array_merge($result, array("success" => true, "message" => "Brand succesfully deleted"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Unable to delete brand"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Brand is already inactive"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Brand with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "edit-category": {
                        $manageCategory = mysqli_real_escape_string($conn, $data->manageCategory);
                        $manageCategoryId = mysqli_real_escape_string($conn, $data->manageCategoryId);
                        if (empty($manageCategory) || !is_string($manageCategory) || strlen($manageCategory) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Please input category name"));
                        } else if (!is_int(intval($manageCategoryId)) || !strlen(strval($manageCategoryId))) {
                            $result = array_merge($result, array("success" => false, "message" => "Please category id is not matched"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $manageCategoryObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `category` WHERE `id` = '$manageCategoryId' LIMIT 1"));
                                if (!!$manageCategoryObject) {
                                    if ($manageCategoryObject->status == 1) {
                                        if ($manageCategoryObject->value == $manageCategory) {
                                            $result = array_merge($result, array("success" => false, "message" => "Category name unchanged"));
                                        } else {
                                            if (mysqli_query($conn, "UPDATE `category` SET `value` = '$manageCategory',`updatedOn` = '$createdOn' WHERE `id` = '$manageCategoryObject->id';")) {
                                                $result = array_merge($result, array("success" => true, "message" => "Category succesfully updated"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Unable to update category"));
                                            }
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Category is no longer active"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Category with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "deleted-category": {
                        $manageCategoryId = mysqli_real_escape_string($conn, $data->manageCategoryId);
                        if (!is_int(intval($manageCategoryId)) || !strlen(strval($manageCategoryId))) {
                            $result = array_merge($result, array("success" => false, "message" => "Please category id is not matched"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInAdmin) {
                                $manageCategoryObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `category` WHERE `id` = '$manageCategoryId' LIMIT 1"));
                                if (!!$manageCategoryObject) {
                                    if ($manageCategoryObject->status = 1) {
                                        if (mysqli_query($conn, "UPDATE `category` SET `status` = 0,`updatedOn` = '$createdOn' WHERE `id` = '$manageCategoryObject->id';")) {
                                            $result = array_merge($result, array("success" => true, "message" => "Category succesfully deleted"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Unable to delete category"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Category is already inactive"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Category with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                            }
                        }
                        break;
                    }
                case "update-product-sizes": {

                        $createdOn = time();
                        if (!!$currentlyLoggedInAdmin) {
                            if (!isset($data->productId) || !is_numeric($data->productId)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product not specified"));
                            } else if (!isset($data->productUniqueString) || !is_string($data->productUniqueString) || !strlen($data->productUniqueString)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product verification not provided"));
                            } else if (!isset($data->checkedSizes) || !is_array($data->checkedSizes)) {
                                $result = array_merge($result, array("success" => false, "message" => "checked sizes not in appropriate form"));
                            } else {
                                $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$data->productUniqueString' and `id` = '$data->productId' LIMIT 1"));
                                if (!!$productObject) {
                                    if ($productObject->status == 0) {
                                        $result = array_merge($result, array("success" => false, "message" => "Product is already deleted"));
                                    } else if (($productObject->status == 1) || ($productObject->status == 2)) {
                                        $activeProductSizeIds = [];
                                        $queryResult = mysqli_query($conn, "SELECT * FROM `productSize` WHERE `status` = 1");
                                        if ($queryResult) {
                                            if (mysqli_num_rows($queryResult) > 0) {
                                                while ($row = mysqli_fetch_assoc($queryResult)) {
                                                    $activeProductSizeIds["`value` = '" . $row["value"] . "'"] = 1;
                                                }
                                            }
                                        }
                                        $hasSizetoAdd = false;
                                        $hasSizetoUpdate = false;
                                        $sizeAddingQuery = "INSERT INTO `productSize` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES ";

                                        foreach ($data->checkedSizes as $newSizeId) {
                                            if (isset($activeProductSizeIds["`value` = '$newSizeId'"])) {
                                                unset($activeProductSizeIds["`value` = '$newSizeId'"]);
                                            } else {
                                                $prefix = ",";
                                                if (!$hasSizetoAdd) {
                                                    $prefix = "";
                                                    $hasSizetoAdd = true;
                                                }
                                                $sizeAddingQuery = "$sizeAddingQuery$prefix(NULL,  '1','$data->productId','$newSizeId','$currentlyLoggedInAdmin->id', '$createdOn', '')";
                                            }
                                        }
                                        if (!$hasSizetoAdd || mysqli_query($conn, $sizeAddingQuery)) {
                                            $sizeUpdateQuery = "UPDATE `productSize` SET `status` = '0', `updatedOn` = '$createdOn'  WHERE `productId` = '$data->productId' and ";
                                            foreach ($activeProductSizeIds as $newSizeId => $itsValue) {
                                                $prefix = "OR ";
                                                if (!$hasSizetoUpdate) {
                                                    $prefix = "";
                                                    $hasSizetoUpdate = true;
                                                }
                                                $sizeUpdateQuery = "$sizeUpdateQuery $prefix $newSizeId";
                                            }
                                            if (!$hasSizetoUpdate || mysqli_query($conn, $sizeUpdateQuery)) {
                                                $result = array_merge($result, array("success" => true, "message" => "Successfully updated product sizes"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Error removing product sizes"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Error adding new product sizes"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Product status is invalid"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                        }
                        break;
                    }
                case "update-product-categories": {

                        $createdOn = time();
                        if (!!$currentlyLoggedInAdmin) {
                            if (!isset($data->productId) || !is_numeric($data->productId)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product not specified"));
                            } else if (!isset($data->productUniqueString) || !is_string($data->productUniqueString) || !strlen($data->productUniqueString)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product verification not provided"));
                            } else if (!isset($data->checkedCategory) || !is_array($data->checkedCategory)) {
                                $result = array_merge($result, array("success" => false, "message" => "checked categories not in appropriate form"));
                            } else {
                                $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$data->productUniqueString' and `id` = '$data->productId' LIMIT 1"));
                                if (!!$productObject) {
                                    if ($productObject->status == 0) {
                                        $result = array_merge($result, array("success" => false, "message" => "Product is already deleted"));
                                    } else if (($productObject->status == 1) || ($productObject->status == 2)) {
                                        $activeProductCategoryIds = [];
                                        $queryResult = mysqli_query($conn, "SELECT * FROM `productCategory` WHERE `status` = 1");
                                        if ($queryResult) {
                                            if (mysqli_num_rows($queryResult) > 0) {
                                                while ($row = mysqli_fetch_assoc($queryResult)) {
                                                    $activeProductCategoryIds["`value` = '" . $row["value"] . "'"] = 1;
                                                }
                                            }
                                        }
                                        $hasCategoriestoAdd = false;
                                        $hasCategorytoUpdate = false;
                                        $categoryAddingQuery = "INSERT INTO `productCategory` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES ";

                                        foreach ($data->checkedCategory as $newCategoryId) {
                                            if (isset($activeProductCategoryIds["`value` = '$newCategoryId'"])) {
                                                unset($activeProductCategoryIds["`value` = '$newCategoryId'"]);
                                            } else {
                                                $prefix = ",";
                                                if (!$hasCategoriestoAdd) {
                                                    $prefix = "";
                                                    $hasCategoriestoAdd = true;
                                                }
                                                $categoryAddingQuery = "$categoryAddingQuery $prefix(NULL,  '1','$data->productId','$newCategoryId','$currentlyLoggedInAdmin->id', '$createdOn', '')";
                                            }
                                        }
                                        if (!$hasCategoriestoAdd || mysqli_query($conn, $categoryAddingQuery)) {
                                            $categoryUpdateQuery = "UPDATE `productCategory` SET `status` = '0', `updatedOn` = '$createdOn'  WHERE `productId` = '$data->productId' and ";
                                            foreach ($activeProductCategoryIds as $newCategoryId => $itsValue) {
                                                $prefix = "OR ";
                                                if (!$hasCategorytoUpdate) {
                                                    $prefix = "";
                                                    $hasCategorytoUpdate = true;
                                                }
                                                $categoryUpdateQuery = "$categoryUpdateQuery $prefix $newCategoryId";
                                            }
                                            if (!$hasCategorytoUpdate || mysqli_query($conn, $categoryUpdateQuery)) {
                                                $result = array_merge($result, array("success" => true, "message" => " Successfully updated product categories"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Error removing product categories"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Error adding new product categories"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Product status is invalid"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                        }
                        break;
                    }
                case "update-product-brands": {

                        $createdOn = time();
                        if (!!$currentlyLoggedInAdmin) {
                            if (!isset($data->productId) || !is_numeric($data->productId)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product not specified"));
                            } else if (!isset($data->productUniqueString) || !is_string($data->productUniqueString) || !strlen($data->productUniqueString)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product verification not provided"));
                            } else if (!isset($data->checkedBrand) || !is_array($data->checkedBrand)) {
                                $result = array_merge($result, array("success" => false, "message" => "checked brand not in appropriate form"));
                            } else {
                                $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$data->productUniqueString' and `id` = '$data->productId' LIMIT 1"));
                                if (!!$productObject) {
                                    if ($productObject->status == 0) {
                                        $result = array_merge($result, array("success" => false, "message" => "Product is already deleted"));
                                    } else if (($productObject->status == 1) || ($productObject->status == 2)) {
                                        $activeProductbrandIds = [];
                                        $queryResult = mysqli_query($conn, "SELECT * FROM `productBrand` WHERE `status` = 1");
                                        if ($queryResult) {
                                            if (mysqli_num_rows($queryResult) > 0) {
                                                while ($row = mysqli_fetch_assoc($queryResult)) {
                                                    $activeProductbrandIds["`value` = '" . $row["value"] . "'"] = 1;
                                                }
                                            }
                                        }
                                        $hasBrandtoAdd = false;
                                        $hasBrandtoUpdate = false;
                                        $brandAddingQuery = "INSERT INTO `productBrand` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES ";

                                        foreach ($data->checkedBrand as $newBrandId) {
                                            if (isset($activeProductbrandIds["`value` = '$newBrandId'"])) {
                                                unset($activeProductbrandIds["`value` = '$newBrandId'"]);
                                            } else {
                                                $prefix = ",";
                                                if (!$hasBrandtoAdd) {
                                                    $prefix = "";
                                                    $hasBrandtoAdd = true;
                                                }
                                                $brandAddingQuery = "$brandAddingQuery $prefix(NULL,  '1','$data->productId','$newBrandId','$currentlyLoggedInAdmin->id', '$createdOn', '')";
                                            }
                                        }
                                        if (!$hasBrandtoAdd || mysqli_query($conn, $brandAddingQuery)) {
                                            $brandUpdateQuery = "UPDATE `productBrand` SET `status` = '0', `updatedOn` = '$createdOn'  WHERE `productId` = '$data->productId' and ";
                                            foreach ($activeProductbrandIds as $newBrandId => $itsValue) {
                                                $prefix = "OR ";
                                                if (!$hasBrandtoUpdate) {
                                                    $prefix = "";
                                                    $hasBrandtoUpdate = true;
                                                }
                                                $brandUpdateQuery = "$brandUpdateQuery $prefix $newBrandId";
                                            }
                                            if (!$hasBrandtoUpdate || mysqli_query($conn, $brandUpdateQuery)) {
                                                $result = array_merge($result, array("success" => true, "message" => " Successfully updated product brand"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Error removing product brands"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Error adding new product brands"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Product status is invalid"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                        }
                        break;
                    }
                case "update-product-colors": {

                        $createdOn = time();
                        if (!!$currentlyLoggedInAdmin) {
                            if (!isset($data->productId) || !is_numeric($data->productId)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product not specified"));
                            } else if (!isset($data->productUniqueString) || !is_string($data->productUniqueString) || !strlen($data->productUniqueString)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product verification not provided"));
                            } else if (!isset($data->checkedColor) || !is_array($data->checkedColor)) {
                                $result = array_merge($result, array("success" => false, "message" => "checked color not in appropriate form"));
                            } else {
                                $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$data->productUniqueString' and `id` = '$data->productId' LIMIT 1"));
                                if (!!$productObject) {
                                    if ($productObject->status == 0) {
                                        $result = array_merge($result, array("success" => false, "message" => "Product is already deleted"));
                                    } else if (($productObject->status == 1) || ($productObject->status == 2)) {
                                        $activeProductColorIds = [];
                                        $queryResult = mysqli_query($conn, "SELECT * FROM `productColor` WHERE `status` = 1");
                                        if ($queryResult) {
                                            if (mysqli_num_rows($queryResult) > 0) {
                                                while ($row = mysqli_fetch_assoc($queryResult)) {
                                                    $activeProductColorIds["`value` = '" . $row["value"] . "'"] = 1;
                                                }
                                            }
                                        }
                                        $hasColortoAdd = false;
                                        $hasColortoUpdate = false;
                                        $colorAddingQuery = "INSERT INTO `productColor` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES ";

                                        foreach ($data->checkedColor as $newColorId) {
                                            if (isset($activeProductColorIds["`value` = '$newColorId'"])) {
                                                unset($activeProductColorIds["`value` = '$newColorId'"]);
                                            } else {
                                                $prefix = ",";
                                                if (!$hasColortoAdd) {
                                                    $prefix = "";
                                                    $hasColortoAdd = true;
                                                }
                                                $colorAddingQuery = "$colorAddingQuery $prefix(NULL,  '1','$data->productId','$newColorId','$currentlyLoggedInAdmin->id', '$createdOn', '')";
                                            }
                                        }
                                        if (!$hasColortoAdd || mysqli_query($conn, $colorAddingQuery)) {
                                            $colorUpdateQuery = "UPDATE `productBrand` SET `status` = '0', `updatedOn` = '$createdOn'  WHERE `productId` = '$data->productId' and ";
                                            foreach ($activeProductColorIds as $newColorId => $itsValue) {
                                                $prefix = "OR ";
                                                if (!$hasColortoUpdate) {
                                                    $prefix = "";
                                                    $hasColortoUpdate = true;
                                                }
                                                $colorUpdateQuery = "$colorUpdateQuery $prefix $newColorId";
                                            }
                                            if (!$hasColortoUpdate || mysqli_query($conn, $colorUpdateQuery)) {
                                                $result = array_merge($result, array("success" => true, "message" => " Successfully updated product color"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Error removing product color"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Error adding new product color"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Product status is invalid"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                        }
                        break;
                    }
                case "change-name": {
                        if (!!$currentlyLoggedInUser) {
                            $firstName = mysqli_real_escape_string($conn, $data->firstName);
                            $lastName = mysqli_real_escape_string($conn, $data->lastName);
                            $createdOn = time();

                            if (empty($firstName)  || !is_string($firstName) || strlen($firstName) < 3) {
                                $result = array_merge($result, array("success" => false, "message" => "Please first name can not be empty and not less than three(3) characters"));
                            } else if (strlen($firstName) > 30) {
                                $result = array_merge($result, array("success" => false, "message" => "Please first name cannot be more than 30 characters"));
                            } else if (empty($lastName)  || !is_string($lastName) || strlen($lastName) < 3) {
                                $result = array_merge($result, array("success" => false, "message" => "Please last name can not be empty and not less than three(3) characters"));
                            } else if (strlen($lastName) > 30) {
                                $result = array_merge($result, array("success" => false, "message" => "Please last name cannot be more than 30 characters"));
                            } else {
                                $nameObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `name` WHERE `status` = 1  and `userId` = '$currentlyLoggedInUser->id'  LIMIT 1"));
                                if (!!$nameObject) {
                                    if (($nameObject->first == $firstName) && ($nameObject->last == $lastName)) {
                                        $result = array_merge($result, array("success" => false, "message" => "Name seems to be unchanged!"));
                                    } else {
                                        if (mysqli_query($conn, "INSERT INTO `name` (`id`, `status`, `userId`, `first`, `last`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$currentlyLoggedInUser->id', '$firstName','$lastName', '$createdOn', '');")) {
                                            mysqli_query($conn, "UPDATE `name` SET `status` = '0',`updatedOn` = '$createdOn' WHERE `id` = '$nameObject->id';");
                                            $result = array_merge($result, array("success" => true, "message" => "New name save successfully!"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Unable to insert new name!"));
                                        }
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Current name not found!"));
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login before continue"));
                        }
                        break;
                    }
                case "change-short-description": {
                        $createdOn = time();
                        if (!!$currentlyLoggedInAdmin) {
                            $shortDescription = mysqli_real_escape_string($conn, $data->shortDescription);
                            if (!isset($data->productId) || !is_numeric($data->productId)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product id not specified"));
                            } else if (!isset($data->productUniqueString) || !is_string($data->productUniqueString) || !strlen($data->productUniqueString)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product verification not provided"));
                            } else if (empty($shortDescription) || !is_string($shortDescription) || strlen($shortDescription) < 10) {
                                $result = array_merge($result, array("success" => false, "message" => "Please short description name must less than ten characters"));
                            } else {
                                $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$data->productUniqueString' and `id` = '$data->productId' LIMIT 1"));
                                if (!!$productObject) {
                                    if ($productObject->status == 0) {
                                        $result = array_merge($result, array("success" => false, "message" => "Product is already deleted"));
                                    } else if (($productObject->status == 1) || ($productObject->status == 2)) {
                                        $productShortDescriptionObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productShortDescription` WHERE `productId` = '$productObject->id' and `status` = 1 ORDER BY `id` DESC LIMIT 1"));
                                        if (!!$productShortDescriptionObject) {
                                            if ($productShortDescriptionObject->value == $shortDescription) {
                                                $result = array_merge($result, array("success" => false, "message" => "Product short description seems to be unchanged!"));
                                            } else {
                                                if (mysqli_query($conn, "INSERT INTO `productShortDescription` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$productObject->id', '$shortDescription', '$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                                    mysqli_query($conn, "UPDATE `productShortDescription` SET `status` = '0',`updatedOn` = '$createdOn' WHERE `id` = '$productShortDescriptionObject->id';");
                                                    $result = array_merge($result, array("success" => true, "message" => "New product short description save successfully!"));
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Unable to insert new product short description!"));
                                                }
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Current product short description not found!"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Product status is invalid"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                        }
                        break;
                    }
                case "change-long-description": {
                        $createdOn = time();
                        if (!!$currentlyLoggedInAdmin) {
                            $longDescription = mysqli_real_escape_string($conn, $data->longDescription);
                            $createdOn = time();
                            if (!isset($data->productId) || !is_numeric($data->productId)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product id not specified"));
                            } else if (!isset($data->productUniqueString) || !is_string($data->productUniqueString) || !strlen($data->productUniqueString)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product verification not provided"));
                            } else  if (empty($longDescription) || !is_string($longDescription) || strlen($longDescription) < 20) {
                                $result = array_merge($result, array("success" => false, "message" => "Please long description name must not less than twenty characters"));
                            } else {
                                $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$data->productUniqueString' and `id` = '$data->productId' LIMIT 1"));
                                if (!!$productObject) {
                                    if ($productObject->status == 0) {
                                        $result = array_merge($result, array("success" => false, "message" => "Product is already deleted"));
                                    } else if (($productObject->status == 1) || ($productObject->status == 2)) {
                                        $productLongDescriptionObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productLongDescription` WHERE `productId` = '$productObject->id' LIMIT 1"));
                                        if (!!$productLongDescriptionObject) {
                                            if ($productLongDescriptionObject->value == $longDescription) {
                                                $result = array_merge($result, array("success" => false, "message" => "Product long description seems to be unchanged!"));
                                            } else {
                                                if (mysqli_query($conn, "INSERT INTO `productLongDescription` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$productObject->id', '$longDescription', '$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                                    mysqli_query($conn, "UPDATE `productLongDescription` SET `status` = '0',`updatedOn` = '$createdOn' WHERE `id` = '$productLongDescriptionObject->id';");
                                                    $result = array_merge($result, array("success" => true, "message" => "New product long description save successfully!"));
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Unable to insert new product long description!"));
                                                }
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Current product long description not found!"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                                    }
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                        }
                        break;
                    }
                case "change-product-name": {
                        if (!!$currentlyLoggedInAdmin) {
                            $productName = mysqli_real_escape_string($conn, $data->productName);
                            $createdOn = time();
                            if (!isset($data->productId) || !is_numeric($data->productId)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product id not specified"));
                            } else if (!isset($data->productUniqueString) || !is_string($data->productUniqueString) || !strlen($data->productUniqueString)) {
                                $result = array_merge($result, array("success" => false, "message" => "Product verification not provided"));
                            } else  if (empty($productName) || !is_string($productName) || strlen($productName) < 2) {
                                $result = array_merge($result, array("success" => false, "message" => "Please input product name"));
                            } else {
                                $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `uniqueString` = '$data->productUniqueString' and `id` = '$data->productId' LIMIT 1"));
                                if (!!$productObject) {
                                    if ($productObject->status == 0) {
                                        $result = array_merge($result, array("success" => false, "message" => "Product is already deleted"));
                                    } else if (($productObject->status == 1) || ($productObject->status == 2)) {
                                        $productTitleObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productTitle` WHERE `productId` = '$productObject->id' LIMIT 1"));
                                        if (!!$productTitleObject) {
                                            if ($productTitleObject->value == $productName) {
                                                $result = array_merge($result, array("success" => false, "message" => "Product name seems to be unchanged!"));
                                            } else {
                                                if (mysqli_query($conn, "INSERT INTO `productTitle` (`id`, `status`, `productId`, `value`, `createdBy`, `createdOn`, `updatedOn`) VALUES (NULL, '1', '$productObject->id', '$productName', '$currentlyLoggedInAdmin->id', '$createdOn', '');")) {
                                                    mysqli_query($conn, "UPDATE `productTitle` SET `status` = '0',`updatedOn` = '$createdOn' WHERE `id` = '$productTitleObject->id';");
                                                    $result = array_merge($result, array("success" => true, "message" => "New product name save successfully!"));
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Unable to insert new product name!"));
                                                }
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Current product name not found!"));
                                        }
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                                }
                            }
                        } else {
                            $result = array_merge($result, array("success" => false, "message" => "Please login as an admin"));
                        }
                        break;
                    }
                case "make-primary-mail": {
                        $emailId = mysqli_real_escape_string($conn, $data->emailId);
                        if (empty($emailId) || !is_string($emailId) || strlen($emailId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Email identifier"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `subjectType` = 0 and `id` = '$emailId'  LIMIT 1"));
                                if (!!$emailObject) {
                                    if ($emailObject->status == 1) {
                                        if ($emailObject->isPrimary == 1) {
                                            $result = array_merge($result, array("success" => false, "message" => "This email is already primary for your account"));
                                        } else {
                                            $userCurrentPrimaryEmailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `isPrimary` = 1 and `status` = 1 and `subjectId` = '$emailObject->subjectId' and `subjectType` = '$emailObject->subjectType'  LIMIT 1"));
                                            if (!!$userCurrentPrimaryEmailObject) {
                                                if (mysqli_query($conn, "UPDATE `email` SET `isPrimary` = '1', `updatedOn` = '$createdOn'  WHERE `status` = 1 and `subjectType` = 0 and `id` = '$emailObject->id';")) {
                                                    if (mysqli_query($conn, "UPDATE `email` SET `isPrimary` = '0', `updatedOn` = '$createdOn'  WHERE `status` = 1 and `subjectType` = 0 and `id` = '$userCurrentPrimaryEmailObject->id';")) {
                                                        $result = array_merge($result, array("success" => true, "message" => "Successfully made email primary"));
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Unable to remove previous primary email"));
                                                    }
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Unable to make email primary"));
                                                }
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "You do not have an existing primary email"));
                                            }
                                        }
                                    } else if ($emailObject->status == 2) {
                                        $result = array_merge($result, array("success" => false, "message" => "Email is not yet verified"));
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Email is no longer active "));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Email with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        break;
                    }
                case "add-email": {
                        $newEmail = mysqli_real_escape_string($conn, $data->newEmail);
                        if (empty($newEmail) || !isValidEmail($newEmail)) {
                            $result = array_merge($result, array("success" => false, "message" => "Please provide valid email"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $existingEmailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$newEmail' and `subjectType` = 0  LIMIT 1"));
                                if (!!$existingEmailObject) {
                                    if ($existingEmailObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($existingEmailObject->status == 0) {
                                            $result = array_merge($result, array("success" => false, "message" => "You have already deleted this email and cannot re-add it."));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "You have this email added to your account already"));
                                        }
                                    } else if ($existingEmailObject->status == 1) {
                                        $result = array_merge($result, array("success" => false, "message" => "Email is already added to and verified on another account"));
                                    } else {
                                        if (mysqli_query($conn, "INSERT INTO `email` (`id`, `status`, `subjectType`, `subjectId`, `value`, `isPrimary`, `createdOn`, `updatedOn`) VALUES (NULL, '2', '0', '$currentlyLoggedInUser->id', '$newEmail', '0', '$createdOn', '');")) {
                                            $newEmailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$newEmail' and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' and `status` = 2 LIMIT 1"));
                                            if (!!$newEmailObject) {
                                                $possibleURL = emailVerify($newEmailObject);
                                                if (!!$possibleURL && is_string($possibleURL)) {
                                                    $result = array_merge($result, array("success" => true, "message" => "Verification email has been sent to $newEmail,check you mailbox to activate the mail for your account"));
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Failed to send verification link Please try again later!"));
                                                }
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Failed to find just inserted email Please try again later!"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Failed to insert new email to your account"));
                                        }
                                    }
                                } else {
                                    if (mysqli_query($conn, "INSERT INTO `email` (`id`, `status`, `subjectType`, `subjectId`, `value`, `isPrimary`, `createdOn`, `updatedOn`) VALUES (NULL, '2', '0', '$currentlyLoggedInUser->id', '$newEmail', '0', '$createdOn', '');")) {
                                        $newEmailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `value` = '$newEmail' and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' and `status` = 2 LIMIT 1"));
                                        if (!!$newEmailObject) {
                                            $possibleURL = emailVerify($newEmailObject);
                                            if (!!$possibleURL && is_string($possibleURL)) {
                                                $result = array_merge($result, array("success" => true, "message" => "Verification email has been sent to $newEmail,check you mailbox to activate the mail for your account"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Failed to send verification link Please try again later!"));
                                            }
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Failed to find just inserted email Please try again later!"));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Failed to insert new email to your account"));
                                    }
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login as before continue"));
                            }
                        }
                        break;
                    }
                case "remove-email": {
                        $emailId = mysqli_real_escape_string($conn, $data->emailId);
                        if (empty($emailId) || !is_string($emailId) || strlen($emailId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Email identifier"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `id` = '$emailId' and `subjectType` = 0 LIMIT 1"));
                                if (!!$emailObject) {
                                    if ($emailObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($emailObject->isPrimary == 1) {
                                            $result = array_merge($result, array("success" => false, "message" => "You cannot remove your account primary email"));
                                        } else if (($emailObject->status == 1) || ($emailObject->status == 2)) {
                                            if (mysqli_query($conn, "UPDATE `email` SET `status` = '0', `updatedOn` = '$createdOn' WHERE `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' and `id` = '$emailId';")) {
                                                $result = array_merge($result, array("success" => true, "message" => "Successfully removed email"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Failed to remove this email"));
                                            }
                                        } else if ($emailObject->status == 0) {
                                            $result = array_merge($result, array("success" => false, "message" => "Email is already deleted"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Email has unknown issues contact admin to rectify this."));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Email doesn't belong to you"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Email doesn't exist"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login to access this resource"));
                            }
                        }
                        break;
                    }
                case "resend-email-verification": {
                        $emailId = mysqli_real_escape_string($conn, $data->emailId);
                        if (empty($emailId) || !is_string($emailId) || strlen($emailId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Email identifier"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `id` = '$emailId' and `subjectType` = 0 LIMIT 1"));
                                if (!!$emailObject) {
                                    if ($emailObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($emailObject->status == 2) {
                                            $possibleURL = emailVerify($emailObject);
                                            if (!!$possibleURL && is_string($possibleURL)) {
                                                $result = array_merge($result, array("success" => true, "message" => "Email sent"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Email not sent"));
                                            }
                                        } else if ($emailObject->status == 1) {
                                            $result = array_merge($result, array("success" => false, "message" => "Email is already activated"));
                                        } else if ($emailObject->status == 0) {
                                            $result = array_merge($result, array("success" => false, "message" => "Email is already deleted"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "Email has unknown issues contact admin to rectify this."));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Email doesn't belong to you"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Email doesn't exist"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login to access this resource"));
                            }
                        }
                        break;
                    }
                case "make-primary-phone-number": {
                        //email,email,email
                        $phoneNumberId = mysqli_real_escape_string($conn, $data->phoneNumberId);
                        if (empty($phoneNumberId) || !is_string($phoneNumberId) || strlen($phoneNumberId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Phone number identifier"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $phoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `subjectType` = 0 and `id` = '$phoneNumberId'  LIMIT 1"));
                                if (!!$phoneNumberObject) {
                                    if ($phoneNumberObject->status == 1) {
                                        if ($phoneNumberObject->isPrimary == 1) {
                                            $result = array_merge($result, array("success" => false, "message" => "This phone number is already primary for your account"));
                                        } else {
                                            $userCurrentPrimaryphoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `isPrimary` = 1 and `status` = 1 and `subjectId` = '$phoneNumberObject->subjectId' and `subjectType` = '$phoneNumberObject->subjectType'  LIMIT 1"));
                                            if (!!$userCurrentPrimaryphoneNumberObject) {
                                                if (mysqli_query($conn, "UPDATE `phoneNumber` SET `isPrimary` = '1', `updatedOn` = '$createdOn'  WHERE `status` = 1 and `subjectType` = 0 and `id` = '$phoneNumberObject->id';")) {
                                                    if (mysqli_query($conn, "UPDATE `phoneNumber` SET `isPrimary` = '0', `updatedOn` = '$createdOn'  WHERE `status` = 1 and `subjectType` = 0 and `id` = '$userCurrentPrimaryphoneNumberObject->id';")) {
                                                        $result = array_merge($result, array("success" => true, "message" => "Successfully made phone number primary"));
                                                    } else {
                                                        $result = array_merge($result, array("success" => false, "message" => "Unable to remove previous primary phone number"));
                                                    }
                                                } else {
                                                    $result = array_merge($result, array("success" => false, "message" => "Unable to make phone number primary"));
                                                }
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "You do not have an existing primary phone number"));
                                            }
                                        }
                                    } else if ($phoneNumberObject->status == 2) {
                                        $result = array_merge($result, array("success" => false, "message" => "Phone Number is not yet verified"));
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Phone number is no longer active "));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Phone Number with this identifier never existed"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login before continue"));
                            }
                        }
                        //email,email,email
                        break;
                    }
                case "remove-phone-number": {
                        $phoneNumberId = mysqli_real_escape_string($conn, $data->phoneNumberId);
                        if (empty($phoneNumberId) || !is_string($phoneNumberId) || strlen($phoneNumberId) < 1) {
                            $result = array_merge($result, array("success" => false, "message" => "Invalid Phone number identifier"));
                        } else {
                            $createdOn = time();
                            if (!!$currentlyLoggedInUser) {
                                $phoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `id` = '$phoneNumberId' AND `subjectType` = 0  LIMIT 1"));
                                if (!!$phoneNumberObject) {
                                    if ($phoneNumberObject->subjectId == $currentlyLoggedInUser->id) {
                                        if ($phoneNumberObject->isPrimary == 1) {
                                            $result = array_merge($result, array("success" => false, "message" => "You cannot remove your account primary phone number"));
                                        } else if (($phoneNumberObject->status == 1) || ($phoneNumberObject->status == 2)) {
                                            if (mysqli_query($conn, "UPDATE `phoneNumber` SET `status` = '0', `updatedOn` = '$createdOn' WHERE `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id' and `id` = '$phoneNumberId';")) {
                                                $result = array_merge($result, array("success" => true, "message" => "Successfully removed phone number"));
                                            } else {
                                                $result = array_merge($result, array("success" => false, "message" => "Failed to remove this phone number"));
                                            }
                                        } else if ($phoneNumberObject->status == 0) {
                                            $result = array_merge($result, array("success" => false, "message" => "Phone number is already deleted"));
                                        } else {
                                            $result = array_merge($result, array("success" => false, "message" => "phone number has unknown issues contact admin to rectify this."));
                                        }
                                    } else {
                                        $result = array_merge($result, array("success" => false, "message" => "Phone number doesn't belong to you"));
                                    }
                                } else {
                                    $result = array_merge($result, array("success" => false, "message" => "Phone number doesn't exist"));
                                }
                            } else {
                                $result = array_merge($result, array("success" => false, "message" => "Please login to access this resource"));
                            }
                        }
                        break;
                    }
            }
        }
    }
    echo json_encode($result);
}
