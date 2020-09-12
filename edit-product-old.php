<?php
include_once "connection.php";
$productObject;
$productTitleObject;
$productShortDescriptionObject;
$productLongDescriptionObject;

if (!isset($currentlyLoggedInAdmin) || !$currentlyLoggedInAdmin || !isset($currentlyLoggedInUser) || !$currentlyLoggedInUser) {
    header("Location:index.php");
    exit();
} elseif (!isset($_GET) || !isset($_GET['id'])) {
    header("Location:products.php");
    exit();
} else {
    $productId = $_GET['id'];
    $productObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `product` WHERE `id` = '$productId' LIMIT 1"));
    if (!!$productObject) {
        $productTitleObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productTitle` WHERE `productId` = '$productObject->id' LIMIT 1"));
        $productShortDescriptionObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productShortDescription` WHERE `productId` = '$productObject->id' LIMIT 1"));
        $productLongDescriptionObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productShortDescription` WHERE `productId` = '$productObject->id' LIMIT 1"));
    } else {
        header("Location:products.php");
        exit();
    }
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
    <title>Add Product</title>
</head>

<body>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::Form-->
                        <form>
                            <!--end::Symbol-->
                    </div>
                    <!--end::Product images-->
                    <!--begin::Product info-->
                    <div class="mt-6">
                        <div class="text-muted mb-4 font-weight-bolder font-size-lg">Product
                            Info</div>
                        <!--begin::Input-->
                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">PRODUCT Name</label>

                            <input type="text" name="name" value="<?php echo $productTitleObject->value ?>"
                                placeholder="Enter product name" class="form-control form-control-solid form-control-lg"
                                required />
                            <!-- </div>
                                <div class="form-group mb-8">
                                    <label class="font-weight-bolder">Category</label>
                                    <select class="form-control form-control-solid form-control-lg">
                                        <option></option>
                                        <option>Mens</option>
                                        <option>Womens</option>
                                        <option>Accessories</option>
                                        <option>Technology</option>
                                        <option>Appliances</option>
                                    </select>
                                </div>
                                <div class="form-group mb-8">
                                    <label class="font-weight-bolder">Size</label>
                                    <select class="form-control form-control-solid form-control-lg">
                                        <option></option>
                                        <option>XS</option>
                                        <option>S</option>
                                        <option>M</option>
                                        <option>L</option>
                                        <option>XL</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="categories" class=" form-control-label font-weight-bolder">MRP</label>
                                    <input type="text" name="qty" placeholder="Enter qty"
                                        class="form-control form-control-solid form-control-lg" required>
                                </div>
                                <div class="form-group">
                                    <label for="categories" class=" form-control-label font-weight-bolder">Qty</label>
                                    <input type="text" name="qty" placeholder="Enter qty"
                                        class="form-control form-control-solid form-control-lg" required>
                                </div> -->
                            <div class="form-group mb-3">
                                <div class="d-flex mb-8 justify-content-between pt-5">
                                    <img src="profile-picture.php" id="profileDisplay" width="100px;">

                                    <label class=" form-control-label font-weight-bolder">Product Image</label>
                                    <input type="file" name="profilePicture" id="profileImage" class="form-control-file"
                                        style="display: none;">
                                    <div class="symbol symbol-70 flex-shrink-0">
                                        <button type="submit" id="uploadButton" name="save_profile"
                                            class="h-70px w-70px btn btn-primary d-flex flex-column flex-center font-weight-bolder p-0">
                                            UPLOAD</button>
                                    </div>
                                    <!--end::Symbol-->
                                </div>
                                <!--end::Product images-->
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="categories" class=" form-control-label font-weight-bolder">Short
                                Description</label>
                            <textarea name="short_desc" placeholder="Enter product short description"
                                class="form-control form-control-solid form-control-lg"
                                required><?php echo $productShortDescriptionObject->value ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="categories" class=" form-control-label font-weight-bolder">Long
                                Description</label>
                            <textarea name="description" placeholder="Enter product description"
                                class="form-control form-control-solid form-control-lg"
                                required><?php echo $productLongDescriptionObject->value ?></textarea>
                        </div>

                        <!-- <div class="form-group">
                                <label for="categories" class=" form-control-label font-weight-bolder">Meta
                                    Title</label>
                                <textarea name="meta_title" placeholder="Enter product meta title"
                                    class="form-control form-control-solid form-control-lg"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="categories" class=" form-control-label font-weight-bolder">Meta
                                    Description</label>
                                <textarea class="form-control form-control-solid form-control-lg" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="categories" class=" form-control-label font-weight-bolder">Meta
                                    Keyword</label>
                                <textarea name="meta_keyword" placeholder="Enter product meta keyword"
                                    class="form-control form-control-solid form-control-lg"></textarea>
                            </div>
                            <div class="form-group mb-8">
                                <label for="exampleTextarea" class="font-weight-bolder">Description</label>
                                <textarea class="form-control form-control-solid form-control-lg" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bolder">Price (Euro)</label>
                                <input type="text" class="form-control form-control-solid form-control-lg"
                                    placeholder="" />
                            </div> -->
                        <button type="submit" class="btn btn-primary font-weight-bolder mr-2 px-8">Save</button>
                        <button type="reset" class="btn btn-clear font-weight-bolder text-muted px-8">Discard</button>
                    </div>
                    <!--end::Input-->

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
        function completeUpload(success, fileName) {
            if (success == 1) {
                $('#profileDisplay').attr("src", "");
                $('#profileDisplay').attr("src", fileName);
                $('#profileDisplay').attr("value", fileName);
            }
            return true;
        }
        $(document).ready(() => {
            $(document).on('click', '#uploadButton', (event) => {
                event.preventDefault();
                $("#profileImage:hidden").trigger('click');
            });
            $("#profileImage").on('change', (event) => {
                if (!event.target.files || !event.target.files[0] || typeof event.target.files[0].type != "string" || event.target.files[0].type.indexOf("image/") < 0) {
                    alert("Please upload only image file.");
                } else {
                    let formData = new FormData();
                    formData.append("action", 9);
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
                                //$('#profileDisplay').attr("src", `profile-picture.php?v=${Date.now()}`);
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