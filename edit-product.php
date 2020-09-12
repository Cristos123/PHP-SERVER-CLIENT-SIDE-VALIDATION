<?php
include_once "connection.php";
require('top.inc.php');
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
        $productTitleObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productTitle` WHERE `productId` = '$productObject->id' and `status` = 1 ORDER BY `id` DESC LIMIT 1"));
        $productShortDescriptionObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productShortDescription` WHERE `productId` = '$productObject->id' and `status` = 1 ORDER BY `id` DESC LIMIT 1"));
        $productLongDescriptionObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productLongDescription` WHERE `productId` = '$productObject->id' and `status` = 1 ORDER BY `id` DESC LIMIT 1"));
    } else {
        header("Location:products.php");
        exit();
    }
}
?>
<div class="content pb-0">

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

                    <input type="text" name="name" id="product-name-input" value="<?php echo (isset($productTitleObject)&&isset($productTitleObject->value))?$productTitleObject->value:""; ?>"
                        placeholder="Enter product name" class="form-control form-control-solid form-control-lg"
                        required />
                </div>
                <button type="submit" class="btn btn-primary font-weight-bolder mb-3 px-8"
                    id="product-name-button">Save</button>
                <div class="form-group mb-8">
                    <label class=" form-control-label font-weight-bolder">Product Image</label>
                    <input type="file" name="profilePicture" id="profileImage" class="form-control-file"
                        style="display: none;">
                    <div class="symbol symbol-70 flex-shrink-0">
                        <button type="submit" id="uploadButton" name="save_profile"
                            class="h-70px w-70px btn btn-primary d-flex flex-column flex-center font-weight-bolder p-0">
                            UPLOAD</button>
                    <style>
                        .the-over-thing {
                            overflow-x: scroll;
                        }
                    </style>
                    <div class="row flex-nowrap the-over-thing my-3">
                        <?php
                        for ($kolo = 0; $kolo < 6; $kolo++) {
                            echo '
                            <div class="col-sm-12 col-md-6 col-lg-4 col-12 mr-1">
                                <div class="card" style="max-width: 20rem;">
                                    <img src="assets/images/product-images/footear-1-1.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                    </div>
                <div class="form-group" id="category-container">
                    <p class="font-weight-bolder">Categories</p>
                    <?php
                    $activeProductCategoryIds = [];
                    $queryResult = mysqli_query($conn, "SELECT * FROM `productCategory` WHERE `status` = 1");
                    if ($queryResult) {
                        if (mysqli_num_rows($queryResult) > 0) {
                            while ($row = mysqli_fetch_assoc($queryResult)) {
                                $activeProductCategoryIds[$row["value"]] = 1;
                            }
                        }
                    }
                    $result = mysqli_query($conn, "SELECT * FROM `category` WHERE `status` = 1");
                    if ($result) {
                        $count = 1;
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="form-check form-check-inline">
                                                <label class="form-check-label general-check-category-label">All Categories</label>
                                                <input class="form-check-input ml-3 general-check-category" type="checkbox">
                                            </div>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $currentCheckedValue = isset($activeProductCategoryIds[$row["id"]]) && ($activeProductCategoryIds[$row["id"]] == 1) ? ' checked="true"' : "";
                                echo '
                                                <div class="form-check form-check-inline">
                                                <label class="form-check-label">' . $row["value"] . '</label>
                                                <input ' . $currentCheckedValue . ' class="form-check-input real-check-category ml-3" type="checkbox" value="' . $row["id"] . '">
                                            </div>';
                                $count += 1;
                            }
                        }
                    }
                    ?>
                    <button class="btn btn-lg btn-info">
                        Update
                    </button>
                </div>
                <div class="form-group" id="brand-container">
                    <p class="font-weight-bolder">Brands</p>

                    <?php

                    $activeProductBrandIds = [];
                    $queryResult = mysqli_query($conn, "SELECT * FROM `productBrand` WHERE `status` = 1");
                    if ($queryResult) {
                        if (mysqli_num_rows($queryResult) > 0) {
                            while ($row = mysqli_fetch_assoc($queryResult)) {
                                $activeProductBrandIds[$row["value"]] = 1;
                            }
                        }
                    }
                    $result = mysqli_query($conn, "SELECT * FROM `brand` WHERE `status` = 1");
                    if ($result) {
                        $count = 1;
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="form-check form-check-inline">
                                                <label class="form-check-label general-check-brand-label">All Brands</label>
                                                <input class="form-check-input ml-3 general-check-brand" type="checkbox">
                                            </div>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $currentCheckedValue = isset($activeProductBrandIds[$row["id"]]) && ($activeProductBrandIds[$row["id"]] == 1) ? ' checked="true"' : "";
                                echo '
                                                <div class="form-check form-check-inline">
                                                <label class="form-check-label">' . $row["value"] . '</label>
                                                <input ' . $currentCheckedValue . ' class="form-check-input ml-3 real-check-brand" type="checkbox" value="' . $row["id"] . '">
                                            </div>';
                                $count += 1;
                            }
                        }
                    }

                    ?>
                    <button class="btn btn-lg btn-info">
                        Update
                    </button>
                </div>
                <div class="form-group" id="color-container">
                    <p class="font-weight-bolder">Colors</p>
                    <?php
                    $activeProductCategoryIds = [];
                    $queryResult = mysqli_query($conn, "SELECT * FROM `productColor` WHERE `status` = 1");
                    if ($queryResult) {
                        if (mysqli_num_rows($queryResult) > 0) {
                            while ($row = mysqli_fetch_assoc($queryResult)) {
                                $activeProductCategoryIds[$row["value"]] = 1;
                            }
                        }
                    }
                    $result = mysqli_query($conn, "SELECT * FROM `color` WHERE `status` = 1");
                    if ($result) {
                        $count = 1;
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="form-check form-check-inline">
                                                <label class="form-check-label general-check-color-label">All Colors</label>
                                                <input class="form-check-input ml-3 general-check-color" type="checkbox">
                                            </div>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $currentCheckedValue = isset($activeProductCategoryIds[$row["id"]]) && ($activeProductCategoryIds[$row["id"]] == 1) ? ' checked="true"' : "";
                                $typeId = $row["id"];
                                $status = $row["status"];
                                $colorCode = $row["colorCode"];
                                $ColorName = $row["value"];
                                // <span class="badge badge-complete">Active</span>
                                // <span class="badge badge-delete">Deleted</span>
                                echo '
                                                <div class="form-check form-check-inline">
                                                <label style="color:' . $colorCode . ';" class="form-check-label">' . $ColorName . '</label>
                                                <input ' . $currentCheckedValue . ' class="form-check-input ml-3 real-check-color" type="checkbox" value="' . $typeId . '">
                                            </div>';
                                $count += 1;
                            }
                        }
                    }
                    ?>
                    <button class="btn btn-lg btn-info">
                        Update
                    </button>
                </div>
                <div class="form-group" id="size-container">
                    <p class="font-weight-bolder">Sizes</p>
                    <?php
                    $activeProductSizeIds = [];
                    $queryResult = mysqli_query($conn, "SELECT * FROM `productSize` WHERE `status` = 1");
                    if ($queryResult) {
                        if (mysqli_num_rows($queryResult) > 0) {
                            while ($row = mysqli_fetch_assoc($queryResult)) {
                                $activeProductSizeIds[$row["value"]] = 1;
                            }
                        }
                    }
                    $result = mysqli_query($conn, "SELECT * FROM `size` WHERE `status` = 1");
                    if ($result) {
                        $count = 1;
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="form-check form-check-inline">
                                                <label class="form-check-label general-check-label">All Sizes</label>
                                                <input class="form-check-input ml-3 general-check" type="checkbox">
                                            </div>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $currentCheckedValue = isset($activeProductSizeIds[$row["id"]]) && ($activeProductSizeIds[$row["id"]] == 1) ? ' checked="true"' : "";
                                echo '<div class="form-check form-check-inline">
                                                <label class="form-check-label">' . $row["value"] . '</label>
                                                <input' . $currentCheckedValue . ' class="form-check-input ml-3 real-check" type="checkbox" value="' . $row["id"] . '">
                                            </div>';
                                $count += 1;
                            }
                        }
                    }
                    ?>
                    <button class="btn btn-lg btn-info">
                        Update
                    </button>
                </div>

                <div class="form-group">
                    <label for="categories" class=" form-control-label font-weight-bolder">Short
                        Description</label>
                    <textarea name="short_desc" id="product-short-desc" placeholder="Enter product short description"
                        class="form-control form-control-solid form-control-lg"
                        required><?php echo (isset($productShortDescriptionObject)&&isset($productShortDescriptionObject->value))?$productShortDescriptionObject->value:""; ?></textarea>
                </div>
                <button type="submit" id="short-desc-button"
                    class="btn btn-primary font-weight-bolder mb-3 px-8">Save</button>
                <div></div>
                <div class="form-group">
                    <label for="categories" class=" form-control-label font-weight-bolder">Long
                        Description</label>
                    <textarea name="description" id="product-long-desc" placeholder="Enter product description"
                        class="form-control form-control-solid form-control-lg"
                        required><?php echo (isset($productLongDescriptionObject)&&isset($productLongDescriptionObject->value))?$productLongDescriptionObject->value:""; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary font-weight-bolder mb-3 px-8"
                    id="long-desc-button">Save</button>
                <div class="form-group">
                    <label class="font-weight-bolder">Price (Euro)</label>
                    <input type="text" class="form-control form-control-solid form-control-lg" placeholder="" />
                </div>
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

<?php
require('footer.inc.php');
?>
<script>
let product;
 <?php echo "product = ".json_encode($productObject).";"; ?>

jQuery(document).ready(($) => {
    $(document).on('change', "#size-container input.general-check", (event) => {
        event.preventDefault();
        //general-check-label">All Sizes available
        Array.from(document.querySelectorAll("#size-container input.real-check")).forEach((element) => {

            if (event.target.checked) {
                element.setAttribute("checked", true);
            } else {
                element.removeAttribute("checked");
            }
        });
    });
    $(document).on('click', "#size-container button", (event) => {
        event.preventDefault();
        let checkedSizes = [];
        $("#size-container input.real-check:checked").each((index, {
            value
        }) => {
            checkedSizes.push(value);
        });
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
                body: JSON.stringify({
                    checkedSizes,
                    productId: product.id,
                    productUniqueString: product.uniqueString,
                    action: "update-product-sizes"
                }), // body data type must match "Content-Type" header
                //body
            })
            .then((res) => res.json())
            .then((json) => {
                if (json.success) {
                    alert(json.message);
                    //window.location.href = window.location.href;
                } else {
                    alert(json.message || "Error processing request");
                }
            }).catch((error) => {
                console.log("error", error);
            });
    });
    $(document).on('change', "#category-container input.general-check-category", (event) => {
        event.preventDefault();
        //general-check-label">All Sizes available
        Array.from(document.querySelectorAll("#category-container input.real-check-category")).forEach((
            element) => {

            if (event.target.checked) {
                element.setAttribute("checked", true);
            } else {
                element.removeAttribute("checked");
            }
        });
    });
    $(document).on('click', "#category-container button", (event) => {
        event.preventDefault();
        let checkedCategory = [];
        $("#category-container input.real-check-category:checked").each((index, {
            value
        }) => {
            checkedCategory.push(value);
        });
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
                body: JSON.stringify({
                    checkedCategory,
                    productId: product.id,
                    productUniqueString: product.uniqueString,
                    action: "update-product-categories"
                }), // body data type must match "Content-Type" header
                //body
            })
            .then((res) => res.json())
            .then((json) => {
                if (json.success) {
                    alert(json.message);
                    //window.location.href = window.location.href;
                } else {
                    alert(json.message || "Error processing request");
                }
            }).catch((error) => {
                console.log("error", error);
            });
    });
    $(document).on('change', "#brand-container input.general-check-brand", (event) => {
        event.preventDefault(); //type-container real-check-type general-check-type
        //general-check-label">All Sizes available
        Array.from(document.querySelectorAll("#brand-container input.real-check-brand")).forEach((
            element) => {

            if (event.target.checked) {
                element.setAttribute("checked", true);
            } else {
                element.removeAttribute("checked");
            }
        });
    });
    $(document).on('click', "#brand-container  button", (event) => {
        event.preventDefault();
        let checkedBrand = [];
        $("#brand-container input.real-check-brand:checked").each((index, {
            value
        }) => {
            checkedBrand.push(value);
        });
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
                body: JSON.stringify({
                    checkedBrand,
                    productId: product.id,
                    productUniqueString: product.uniqueString,
                    action: "update-product-brands"
                }), // body data type must match "Content-Type" header
                //body
            })
            .then((res) => res.json())
            .then((json) => {
                if (json.success) {
                    alert(json.message);
                    window.location.href = window.location.href;
                } else {
                    alert(json.message || "Error processing request");
                }
            }).catch((error) => {
                console.log("error", error);
            });
    });
    $(document).on('change', "#color-container input.general-check-color", (event) => {
        event.preventDefault(); //color-container real-check-color
        //general-check-label">All Sizes available
        Array.from(document.querySelectorAll("#color-container input.real-check-color")).forEach((
            element) => {

            if (event.target.checked) {
                element.setAttribute("checked", true);
            } else {
                element.removeAttribute("checked");
            }
        });
    });
    $(document).on('click', "#color-container button", (event) => {
        event.preventDefault();
        let checkedColor = [];
        $("#color-container input.real-check-color:checked").each((index, {
            value
        }) => {
            checkedColor.push(value);
        });
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
                body: JSON.stringify({
                    checkedColor,
                    productId: product.id,
                    productUniqueString: product.uniqueString,
                    action: "update-product-colors"
                }), // body data type must match "Content-Type" header
                //body
            })
            .then((res) => res.json())
            .then((json) => {
                if (json.success) {
                    alert(json.message);
                    //window.location.href = window.location.href;
                } else {
                    alert(json.message || "Error processing request");
                }
            }).catch((error) => {
                console.log("error", error);
            });
    });
    $(document).on('click', "#short-desc-button", (event) => {
        event.preventDefault();
        let shortDescription = $("#product-short-desc").val();
        if (!shortDescription || typeof shortDescription != "string" || shortDescription.length < 10) {
            alert("Please short description should contain at least ten (10) characters");
        } else {

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
                    body: JSON.stringify({
                        shortDescription,
                        productId: product.id,
                    productUniqueString: product.uniqueString,
                        action: "change-short-description"
                    }), // body data type must match "Content-Type" header
                    //body
                })
                .then((res) => res.json())
                .then((json) => {
                    if (json.success) {
                        alert(json.message);
                        window.location.href = window.location.href;
                    } else {
                        alert(json.message || "Error processing request");
                    }
                }).catch((error) => {
                    console.log("error", error);
                });
        }
    });
    $(document).on('click', "#long-desc-button", (event) => {
        event.preventDefault();
        let longDescription = $("#product-long-desc").val();
        if (!longDescription || typeof longDescription != "string" || longDescription.length < 20) {
            alert("Please short description should contain at least twentry (20) characters");
        } else {

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
                    body: JSON.stringify({
                        longDescription,
                        productId: product.id,
                    productUniqueString: product.uniqueString,
                        action: "change-long-description"
                    }), // body data type must match "Content-Type" header
                    //body
                })
                .then((res) => res.json())
                .then((json) => {
                    if (json.success) {
                        alert(json.message);
                        window.location.href = window.location.href;
                    } else {
                        alert(json.message || "Error processing request");
                    }
                }).catch((error) => {
                    console.log("error", error);
                });
        }
    });
    $(document).on('click', "#product-name-button", (event) => {//product-name product-name-button
        event.preventDefault();
        let productName = $("#product-name-input").val();
        if (!productName || typeof productName != "string" || productName.length < 2) {
            alert("Please product name cannot be empty");
        } else {

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
                    body: JSON.stringify({
                        productName,
                        productId: product.id,
                    productUniqueString: product.uniqueString,
                        action: "change-product-name"
                    }), // body data type must match "Content-Type" header
                    //body
                })
                .then((res) => res.json())
                .then((json) => {
                    if (json.success) {
                        alert(json.message);
                        window.location.href = window.location.href;
                    } else {
                        alert(json.message || "Error processing request");
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