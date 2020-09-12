<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="node_modules/font-awesome/css/font-awesome.min.css">
    <title>Upload Profile picture</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-4 offset-md-4 form-div">

                <form>
                    <h2 class="text-center mb-3 mt-3">Update profile</h2>
                    <p>Please upload your profile picture by clicking on the upload</p>

                    <div class="form-group text-center" style="position: relative;">
                        <span class="img-div">
                            <div class="text-center">
                                <h4>Update image</h4>
                            </div>
                            <img src="profile-picture.php" id="profileDisplay">
                        </span>
                        <input type="file" name="profilePicture" id="profileImage" class="form-control-file" style="display: none;">
                        <label>Profile Image</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit" name="save_profile" class="btn btn-primary btn-block">Upload</button>
                    </div>
                </form>
            </div>
            <!-- <iframe src="#" frameborder="5"></iframe> -->
        </div>


    </div>




    <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        function completeUpload(success, fileName) {
            if (success == 1) {
                $('#profileDisplay').attr("src", "");
                $('#profileDisplay').attr("src", fileName);
                $('#profileDisplay').attr("value", fileName);
            }
            return true;
        }
        $(document).ready(() => {
            $(document).on('click', '#submit', (event) => {
                event.preventDefault();
                $("#profileImage:hidden").trigger('click');
            });
            $("#profileImage").on('change', (event) => {
                if (!event.target.files || !event.target.files[0] || typeof event.target.files[0].type != "string" || event.target.files[0].type.indexOf("image/") < 0) {
                    alert("Please upload only image file.");
                } else {
                    let formData = new FormData();
                    formData.append("action", "profile-upload");
                    formData.append("profilePicture", event.target.files[0]);

                    fetch("userserver.php", {
                            method: 'POST', // *GET, POST, PUT, DELETE, etc.
                            // mode: 'cors', // no-cors, *cors, same-origin
                            // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                            // credentials: 'same-origin', // include, *same-origin, omit
                            // headers: {
                            //     'Content-Type': 'multipart/json'
                            //     //'Content-Type': 'application/x-www-form-urlencoded',
                            // },
                            // redirect: 'follow', // manual, *follow, error
                            // referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                            body: formData // body data type must match "Content-Type" header
                            //body
                        })
                        .then((res) => res.json())
                        .then((json) => {
                            console.log("json", json);
                            if(json.success){
                                $('#profileDisplay').attr("src", `profile-picture.php?v=${Date.now()}`);
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
        });
    </script>
</body>

</html>