<?php
include_once "connection.php";
require('top.inc.php');
if (!isset($currentlyLoggedInAdmin) || !$currentlyLoggedInAdmin || !isset($currentlyLoggedInUser) || !$currentlyLoggedInUser) {
    header("Location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.css?v=7.0.7" rel="stylesheet"
        type="text/css" />
    <link href="/metronic/theme/html/demo2/dist/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.7"
        rel="stylesheet" type="text/css" />
    <link href="/metronic/theme/html/demo2/dist/assets/css/style.bundle.css?v=7.0.7" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="/metronic/theme/html/demo2/dist/assets/media/logos/favicon.ico" />
    <title>Add Categories</title>
</head>

<body>

    <div class="content pb-0">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Add Category</h4>
                        </div>
                        <form>
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="categories" class=" form-control-label">Add Category</label>
                                    <input type="text" name="categories" id="manageCategoryInput"
                                        placeholder="Enter categories name" class="form-control" required />
                                </div>
                                <button id="manageCategoryButton" name="submit" type="submit"
                                    class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Submit</span>
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.js?v=7.0.7"></script>
    <script src="/metronic/theme/html/demo2/dist/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.7">
    </script>
    <script src="/metronic/theme/html/demo2/dist/assets/js/scripts.bundle.js?v=7.0.7"></script>
    <script>
    $(document).ready(() => {
        $(document).on('click', "#manageCategoryButton", (event) => {
            event.preventDefault();
            let manageCategory = $("#manageCategoryInput").val();

            if (!manageCategory || typeof manageCategory != "string" || manageCategory.length < 2) {
                alert("Please input category name");
            } else {
                // let data = new FormData();
                // data.append("pname", pname);
                // data.append("price",price);
                // data.append("pcat",pcat);
                // data.append("pdetails",pdetails);
                // data.append("reg_bp", "");

                //let body = Object.keys(data).map(key=>`${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`).join("&");

                let data = {
                    manageCategory,
                    action: "add-category"
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
                        body: JSON.stringify(
                        data), // body data type must match "Content-Type" header
                        //body
                    })
                    .then((res) => res.json())
                    .then((json) => {
                        if (json.success) {
                            alert(json.message);
                            //window.location.href = json.redirectTo || window.location.href;
                        } else {
                            alert(json.message || "Error adding product user");
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
<?php
require('footer.inc.php');
?>