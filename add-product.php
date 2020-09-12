<?php
include_once "connection.php";
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
    <link href="/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.css?v=7.0.7" rel="stylesheet" type="text/css" />
    <link href="/metronic/theme/html/demo2/dist/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.7" rel="stylesheet" type="text/css" />
    <link href="/metronic/theme/html/demo2/dist/assets/css/style.bundle.css?v=7.0.7" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="/metronic/theme/html/demo2/dist/assets/media/logos/favicon.ico" />
    <title>Add Product</title>
</head>

<body>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Page Layout-->


                <!--begin::Forms Widget 13-->
                <div class="card card-custom gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column mb-3">
                            <span class="card-label font-size-h3 font-weight-bolder text-dark">Add
                                New Product</span>
                            <span class="text-muted mt-5 font-weight-bolder font-size-lg">
                                Pending Image
                            </span>
                        </h3>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::Form-->
                        <form>
                            <!--begin::Product info-->
                            <div class="mt-6">
                                <div class="text-muted mb-4 font-weight-bolder font-size-lg">Product
                                    Info</div>
                                <!--begin::Input-->
                                <div class="form-group mb-8">
                                    <label class="font-weight-bolder">Name</label>
                                    <input type="text" id="productname-input" class="form-control form-control-solid form-control-lg" placeholder="" />
                                </div>

                                <div class="form-group mb-8">
                                    <label for="exampleTextarea" class="font-weight-bolder">Short Description</label>
                                    <textarea id="short-input" class="form-control form-control-solid form-control-lg" rows="3"></textarea>
                                </div>
                                <div class="form-group mb-8">
                                    <label for="exampleTextarea" class="font-weight-bolder">Long Description</label>
                                    <textarea id="long-input" class="form-control form-control-solid form-control-lg" rows="3"></textarea>
                                </div>


                            </div>
                            <!--end::Color-->
                            <button type="submit" id="reg_bp" class="btn btn-primary font-weight-bolder mr-2 px-8">Save</button>
                            <button type="reset" class="btn btn-clear font-weight-bolder text-muted px-8">Discard</button>
                            <!--end::Input-->
                    </div>
                    <!--end::Product info-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Body-->

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
            $(document).on('click', "#reg_bp", (event) => {
                event.preventDefault();
                let pname = $("#productname-input").val();
                let shortDescription = $("#short-input").val();
                let longDescription = $("#long-input").val();

                if (!pname || typeof pname != "string" || pname.length < 2) {
                    alert("Product name must be greater than five");
                } else if (!shortDescription || typeof shortDescription != "string" || shortDescription.length < 10) {
                    alert("Please short description name  must not less than ten characters");
                } else if (!longDescription || typeof longDescription != "string" || longDescription.length < 20) {
                    alert("Product details must not less than 20 words");
                } else {
                    // let data = new FormData();
                    // data.append("pname", pname);
                    // data.append("price",price);
                    // data.append("pcat",pcat);
                    // data.append("pdetails",pdetails);
                    // data.append("reg_bp", "");

                    //let body = Object.keys(data).map(key=>`${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`).join("&");

                    let data = {
                        pname,
                        shortDescription,
                        longDescription,
                        action: "add-product"
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
                                window.location.href = json.redirectTo || window.location.href;
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