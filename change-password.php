<?php
include_once "connection.php";
$passworRecoveryObject;
$userObject;
$userId;
$dataOne;
$dataTwo;
if (!isset($_GET) || !isset($_GET['userId']) || !isset($_GET['dataOne']) || !isset($_GET['dataTwo'])) {
    header("Location:index.php");
}else{
    $userId = $_GET['userId'];
    $dataOne = $_GET['dataOne'];
    $dataTwo = $_GET['dataTwo'];
    $passworRecoveryObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `passwordRecovery` WHERE `status` = 2 and `subjectType` = 0 and `subjectId` = '$userId' and `dataOne` = '$dataOne' and `dataTwo` = '$dataTwo' LIMIT 1"));
    if (!!$passworRecoveryObject) {
        $userObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `user` WHERE `status` > 0 and `id` = '$passworRecoveryObject->subjectId' LIMIT 1"));
    }else {
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="node_modules/font-awesome/css/font-awesome.min.css">
    <title>Change Password</title>
</head>

<body class="bg-success">

    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header bg-info text-center">
                <h3>Verify Password</h3>
            </div>

            <div class="card-body">
                <p class=" text-center">Input your new pasword.</p>

                <form>
                   <div class="form-group row">
                       <label for="newpassId" class="col-sm-2 col-form-label">Enter new password</label>
                       <div class="col-sm-8">
                           <input type="password" id="newpassId" class="form-control" name="password" placeholder="Password">
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="newpassId2" class="col-sm-2 col-form-label">Confirm new password</label>
                       <div class="col-sm-8">
                           <input type="password" id="newpassId2" class="form-control" name="confirmPassword" placeholder="Confirm Passsword">
                       </div>
                   </div>

                    <div class="row">
                        <div class="offset-sm-2 col-sm-8">
                            <button id="newPass" type="submit" class="btn btn-primary btn-block">Submit new password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="text-center">
                    <p class="mt-3 mb-1">
                        <a href="login.php">Login</a>
                    </p>
                    <p class="mb-0">
                        <a href="signup.php" class="text-center">Register as new membership</a>
                    </p>
                </div>

            </div>
        </div>
    </div>


    <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
            
        $(document).ready(() => {
            
            $(document).on("click","#newPass",(event) =>{
                event.preventDefault();
                let password =$('#newpassId').val();
                let confirmPassword =$('#newpassId2').val();

                 if (!password || typeof password != "string" || password.length < 8) {
                    alert("Please Password must be at least eight character long");
                } else if (!confirmPassword || typeof confirmPassword != "string" || confirmPassword.length < 8) {
                    alert("Confirm Password must be at least eight character long");
                } else if (password != confirmPassword) {
                    alert("Confirm Password must match password field");
                }else{
                    let data = {
                        password,
                        confirmPassword,
                        userId:<?php echo "'$userId'";?>,
                        passwordRecoveryId:<?php echo "'$passworRecoveryObject->id'";?>,
                        dataOne:<?php echo "'$dataOne'";?>,
                        dataTwo:<?php echo "'$dataTwo'";?>,
                        action: "change-password"
                    };
                    fetch("userserver.php", {
                            method: 'POST', // *GET, POST, PUT, DELETE, etc.
                            mode: 'cors', // no-cors, *cors, same-origin
                            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                            credentials: 'same-origin', // include, *same-origin, omit
                            headers: {
                                'Content-Type': 'application/json'
                                //'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            redirect: 'follow', // manual, *follow, error
                            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                            body: JSON.stringify(data), // body data type must match "Content-Type" header
                            //body
                        })
                        .then((res) => res.json())
                        .then((json) => {
                            if (json.success) {
                                alert(json.message);
                                window.location.href = "index.php"
                            } else {
                                alert(json.message || "Error resgister user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            })
        })
    </script>
    
</body>
</html>