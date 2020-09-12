<?php
include_once "connection.php";
$phoneNumberObject;
$nameObject;
$emailObject;
if (!isset($currentlyLoggedInUser) || !$currentlyLoggedInUser) {
    header("Location:index.php");
    exit();
} else {
    $subjectId = $currentlyLoggedInUser->id;
    $userId = $currentlyLoggedInUser->id;
    $subjectId = $currentlyLoggedInUser->id;
    $phoneNumberObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `status` = 1 and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id'  LIMIT 1"));
    $nameObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `name` WHERE `status` = 1  and `userId` = '$currentlyLoggedInUser->id'  LIMIT 1"));
    $emailObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `email` WHERE `status` = 1 and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id'  LIMIT 1"));
    $addressObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `address` WHERE `status` = 1 and `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id'  LIMIT 1"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Profile Page</title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Porto - Bootstrap eCommerce Template">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets3/images/icons/favicon.ico">


    <script type="text/javascript">
        WebFontConfig = {
            google: {
                families: ['Open+Sans:300,400,600,700,800', 'Poppins:300,400,500,600,700', 'Shadows+Into+Light:400']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = 'assets3/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets3/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets3/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="assets3/vendor/fontawesome-free/css/all.min.css">
</head>

<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left d-none d-sm-block">
                        <p class="top-message text-uppercase">FREE Returns. Standard Shipping Orders $99+</p>
                    </div><!-- End .header-left -->

                    <div class="header-right header-dropdowns ml-0 ml-sm-auto w-sm-100">
                        <div class="header-dropdown dropdown-expanded d-none d-lg-block">
                            <a href="#">Links</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="my-account.html">Track Order </a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="category.html">Our Stores</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="#">Help &amp; FAQs</a></li>
                                </ul>
                            </div><!-- End .header-menu -->
                        </div><!-- End .header-dropown -->

                        <span class="separator"></span>

                        <div class="header-dropdown ">
                            <a href="#">USD</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="#">EUR</a></li>
                                    <li><a href="#">USD</a></li>
                                </ul>
                            </div><!-- End .header-menu -->
                        </div><!-- End .header-dropown -->

                        <div class="header-dropdown mr-auto mr-sm-3 mr-md-0">
                            <a href="#"><img src="assets3/images/flags/en.png" alt="England flag">ENG</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="#"><img src="assets3/images/flags/en.png" alt="England flag">ENG</a>
                                    </li>
                                    <li><a href="#"><img src="assets3/images/flags/fr.png" alt="France flag">FRA</a>
                                    </li>
                                </ul>
                            </div><!-- End .header-menu -->
                        </div><!-- End .header-dropown -->

                        <span class="separator"></span>

                        <div class="social-icons">
                            <a href="#" class="social-icon social-instagram icon-instagram" target="_blank"></a>
                            <a href="#" class="social-icon social-twitter icon-twitter" target="_blank"></a>
                            <a href="#" class="social-icon social-facebook icon-facebook" target="_blank"></a>
                        </div><!-- End .social-icons -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left col-lg-2 w-auto pl-0">
                        <button class="mobile-menu-toggler text-primary mr-2" type="button">
                            <i class="icon-menu"></i>
                        </button>
                        <a href="index.html" class="logo">
                            <img src="assets3/images/logo.png" alt="Porto Logo">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-right w-lg-max">
                        <div class="header-icon header-icon header-search header-search-inline header-search-category w-lg-max text-right">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search...">
                                    <div class="select-custom">
                                        <select id="cat" name="cat">
                                            <option value="">All Categories</option>
                                            <option value="4">Fashion</option>
                                            <option value="12">- Women</option>
                                            <option value="13">- Men</option>
                                            <option value="66">- Jewellery</option>
                                            <option value="67">- Kids Fashion</option>
                                            <option value="5">Electronics</option>
                                            <option value="21">- Smart TVs</option>
                                            <option value="22">- Cameras</option>
                                            <option value="63">- Games</option>
                                            <option value="7">Home &amp; Garden</option>
                                            <option value="11">Motors</option>
                                            <option value="31">- Cars and Trucks</option>
                                            <option value="32">- Motorcycles &amp; Powersports</option>
                                            <option value="33">- Parts &amp; Accessories</option>
                                            <option value="34">- Boats</option>
                                            <option value="57">- Auto Tools &amp; Supplies</option>
                                        </select>
                                    </div><!-- End .select-custom -->
                                    <button class="btn icon-search-3 p-0" type="submit"></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->

                        <div class="header-contact d-none d-lg-flex pl-4 ml-3 mr-xl-5 pr-4">
                            <img alt="phone" src="assets3/images/phone.png" width="30" height="30" class="pb-1">
                            <h6>Call us now<a href="tel:#" class="text-dark font1">+123 5678 890</a></h6>
                        </div>

                        <a href="login.html" class="header-icon login-link"><i class="icon-user-2"></i></a>

                        <a href="#" class="header-icon"><i class="icon-wishlist-2"></i></a>

                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle dropdown-arrow" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count badge-circle">2</span>
                            </a>

                            <div class="dropdown-menu">
                                <div class="dropdownmenu-wrapper">
                                    <div class="dropdown-cart-header">
                                        <span>2 Items</span>

                                        <a href="cart.html" class="float-right">View Cart</a>
                                    </div><!-- End .dropdown-cart-header -->

                                    <div class="dropdown-cart-products">
                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <a href="product.html">Woman Ring</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">1</span>
                                                    x $99.00
                                                </span>
                                            </div><!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets3/images/products/cart/product-1.jpg" alt="product" width="80" height="80">
                                                </a>
                                                <a href="#" class="btn-remove icon-cancel" title="Remove Product"></a>
                                            </figure>
                                        </div><!-- End .product -->

                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <a href="product.html">Woman Necklace</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">1</span>
                                                    x $35.00
                                                </span>
                                            </div><!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets3/images/products/cart/product-2.jpg" alt="product" width="80" height="80">
                                                </a>
                                                <a href="#" class="btn-remove icon-cancel" title="Remove Product"></a>
                                            </figure>
                                        </div><!-- End .product -->
                                    </div><!-- End .cart-product -->

                                    <div class="dropdown-cart-total">
                                        <span>Total</span>

                                        <span class="cart-total-price float-right">$134.00</span>
                                    </div><!-- End .dropdown-cart-total -->

                                    <div class="dropdown-cart-action">
                                        <a href="checkout-shipping.html" class="btn btn-dark btn-block">Checkout</a>
                                    </div><!-- End .dropdown-cart-total -->
                                </div><!-- End .dropdownmenu-wrapper -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->

            <div class="header-bottom sticky-header d-none d-lg-block">
                <div class="container">
                    <nav class="main-nav w-100">
                        <ul class="menu">
                            <li class="active">
                                <a href="index.html">Home</a>
                            </li>
                            <li>
                                <a href="category.html">Categories</a>
                                <div class="megamenu megamenu-fixed-width megamenu-3cols">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <a href="#" class="nolink">VARIATION 1</a>
                                            <ul class="submenu">
                                                <li><a href="category.html">Fullwidth Banner</a></li>
                                                <li><a href="category-banner-boxed-slider.html">Boxed Slider Banner</a>
                                                </li>
                                                <li><a href="category-banner-boxed-image.html">Boxed Image Banner</a>
                                                </li>
                                                <li><a href="category.html">Left Sidebar</a></li>
                                                <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                                                <li><a href="category-flex-grid.html">Product Flex Grid</a></li>
                                                <li><a href="category-horizontal-filter1.html">Horizontal Filter1</a>
                                                </li>
                                                <li><a href="category-horizontal-filter2.html">Horizontal Filter2</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#" class="nolink">VARIATION 2</a>
                                            <ul class="submenu">
                                                <li><a href="category-list.html">List Types</a></li>
                                                <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll</a>
                                                </li>
                                                <li><a href="category.html">3 Columns Products</a></li>
                                                <li><a href="category-4col.html">4 Columns Products</a></li>
                                                <li><a href="category-5col.html">5 Columns Products</a></li>
                                                <li><a href="category-6col.html">6 Columns Products</a></li>
                                                <li><a href="category-7col.html">7 Columns Products</a></li>
                                                <li><a href="category-8col.html">8 Columns Products</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4 p-0">
                                            <img src="assets3/images/menu-banner.jpg" alt="Menu banner">
                                        </div>
                                    </div>
                                </div><!-- End .megamenu -->
                            </li>
                            <li>
                                <a href="product.html">Products</a>
                                <div class="megamenu megamenu-fixed-width">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <a href="#" class="nolink">Variations 1</a>
                                            <ul class="submenu">
                                                <li><a href="product.html">Horizontal Thumbs</a></li>
                                                <li><a href="product-full-width.html">Vertical Thumbnails</a></li>
                                                <li><a href="product.html">Inner Zoom</a></li>
                                                <li><a href="product-addcart-sticky.html">Addtocart Sticky</a></li>
                                                <li><a href="product-sidebar-left.html">Accordion Tabs</a></li>
                                            </ul>
                                        </div><!-- End .col-lg-4 -->
                                        <div class="col-lg-3">
                                            <a href="#" class="nolink">Variations 2</a>
                                            <ul class="submenu">
                                                <li><a href="product-sticky-tab.html">Sticky Tabs</a></li>
                                                <li><a href="product-simple.html">Simple Product</a></li>
                                                <li><a href="product-sidebar-left.html">With Left Sidebar</a></li>
                                            </ul>
                                        </div><!-- End .col-lg-4 -->
                                        <div class="col-lg-3">
                                            <a href="#" class="nolink">Product Layout Types</a>
                                            <ul class="submenu">
                                                <li><a href="product.html">Default Layout</a></li>
                                                <li><a href="product-extended-layout.html">Extended Layout</a></li>
                                                <li><a href="product-full-width.html">Full Width Layout</a></li>
                                                <li><a href="product-grid-layout.html">Grid Images Layout</a></li>
                                                <li><a href="product-sticky-both.html">Sticky Both Side Info</a></li>
                                                <li><a href="product-sticky-info.html">Sticky Right Side Info</a></li>
                                            </ul>
                                        </div><!-- End .col-lg-4 -->

                                        <div class="col-lg-3 p-0">
                                            <img src="assets3/images/menu-bg.png" alt="Menu banner" class="product-promo">
                                        </div><!-- End .col-lg-4 -->
                                    </div><!-- End .row -->
                                </div><!-- End .megamenu -->
                            </li>
                            <li>
                                <a href="#">Pages</a>
                                <ul>
                                    <li><a href="cart.html">Shopping Cart</a></li>
                                    <li><a href="#">Checkout</a>
                                        <ul>
                                            <li><a href="checkout-shipping.html">Checkout Shipping</a></li>
                                            <li><a href="checkout-shipping-2.html">Checkout Shipping 2</a></li>
                                            <li><a href="checkout-review.html">Checkout Review</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Dashboard</a>
                                        <ul>
                                            <li><a href="dashboard.html">Dashboard</a></li>
                                            <li><a href="my-account.html">My Account</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="#">Blog</a>
                                        <ul>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="single.html">Blog Post</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                    <li><a href="#" class="login-link">Login</a></li>
                                    <li><a href="forgot-password.html">Forgot Password</a></li>
                                </ul>
                            </li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li class="float-right"><a href="https://1.envato.market/DdLk5" class="px-4" target="_blank">Buy Porto!<span class="tip tip-new tip-top">New</span></a></li>
                            <li class="float-right mr-0"><a href="#" class="px-4">Special Offer!</a></li>
                        </ul>
                    </nav>
                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile Page</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-9 order-lg-last dashboard-content">
                        <h2>Profile Account Information</h2>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h4>Account Information</h4>
                                    </div>
                                    <form>
                                        <div class="card-body card-block">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group" style="position: relative;">
                                                        <span class="img-div">
                                                            <img src="profile-picture.php" id="profileDisplay" style="height:200px; width:auto" ;>
                                                        </span>
                                                        <input type="file" name="profilePicture" id="profileImage" class="form-control-file" style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <button id="submit" name="save_profile" class="btn btn-primary ">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body card-block">
                                            <div class="col-sm-11">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group-field">
                                                            <label for="acc-name">First Name</label>
                                                            <input type="text" class="form-control" id="acc-firstname" value="<?php echo (isset($nameObject) && isset($nameObject->first)) ? $nameObject->first : ""; ?>" name="acc-name">
                                                        </div><!-- End .form-group -->
                                                    </div><!-- End .col-md-4 -->

                                                    <div class="col-md-6">
                                                        <div class="form-group-field">
                                                            <label for="acc-lastname">Last Name</label>
                                                            <input type="text" class="form-control" id="acc-lastname" value="<?php echo (isset($nameObject) && isset($nameObject->last)) ? $nameObject->last : ""; ?>" name="acc-lastname">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button class="btn btn-primary" id="name-save-button">Save</button>
                                                    </div>
                                                </div><!-- End .row -->
                                            </div>
                                        </div>

                                        <div class="card-body card-block">
                                            <div class="form-group-field">
                                                <div class="row">
                                                    <?php
                                                    $emailObjects = [];
                                                    $queryResult = mysqli_query($conn, "SELECT * FROM `email` WHERE `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id'");
                                                    if ($queryResult) {
                                                        if (mysqli_num_rows($queryResult) > 0) {
                                                            while ($row = mysqli_fetch_assoc($queryResult)) {
                                                                array_push($emailObjects, (object)$row);
                                                            }
                                                        }
                                                    }
                                                    $activeEmailHTML = "";
                                                    for ($emailIndex = 0; $emailIndex < count($emailObjects); $emailIndex++) {
                                                        if (isset($emailObjects[$emailIndex]) && isset($emailObjects[$emailIndex]->status) && $emailObjects[$emailIndex]->status == 1) {
                                                            $conditionalPart = '
                                            <div class="col-sm-3">
                                            <button class="btn btn-primary make-email-primary">Make Primary</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary remove-email">Remove</button>
                                        </div>';
                                                            if (isset($emailObjects[$emailIndex]) && isset($emailObjects[$emailIndex]->isPrimary) && $emailObjects[$emailIndex]->isPrimary == 1) {
                                                                $conditionalPart = '
                                            <div class="col-sm-2">
                                            <a class="btn"><span class="badge badge-info">Primary</span></a>
                                            </div>';
                                                            }
                                                            $activeEmailHTML .= '<div class="row mb-2 each-email" data-id="' . $emailObjects[$emailIndex]->id . '">
                                            <div class="col-sm-6">
                                                <input disabled type="email" class="form-control" value="' . $emailObjects[$emailIndex]->value . '" name="acc-name">
                                            </div>
                                            ' . $conditionalPart . '
                                        </div>';
                                                        } else if (isset($emailObjects[$emailIndex]) && isset($emailObjects[$emailIndex]->status) && $emailObjects[$emailIndex]->status == 2) {
                                                            $conditionalPart = '
                                            <div class="col-sm-4">
                                            <button class="btn btn-primary resend-verification-email">Resend Verification</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary remove-email">Remove</button>
                                        </div>';
                                                            $activeEmailHTML .= '<div class="row mb-2 each-email" data-id="' . $emailObjects[$emailIndex]->id . '">
                                            <div class="col-sm-3">
                                                <input disabled type="email" class="form-control" value="' . $emailObjects[$emailIndex]->value . '" name="EMAIL">
                                            </div>
                                            ' . $conditionalPart . '
                                        </div>';
                                                        }
                                                    }
                                                    if (count($emailObjects)) {
                                                        echo '
                                            <div class="card-body card-block">
                                                <div class="form-group-field">
                                                    <label for="acc-email">Email</label>
                                                    ' . $activeEmailHTML . '
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" value="" id="acc-email" name="acc-name" placeholder="New email">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button class="btn btn-primary" id="acc-email-add">Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body card-block">
                                            <div class="form-group-field">
                                                <div class="row">
                                                    <?php
                                                    $phoneNumberObjects = [];
                                                    $queryResult = mysqli_query($conn, "SELECT * FROM `phoneNumber` WHERE `subjectType` = 0 and `subjectId` = '$currentlyLoggedInUser->id'");
                                                    if ($queryResult) {
                                                        if (mysqli_num_rows($queryResult) > 0) {
                                                            while ($row = mysqli_fetch_assoc($queryResult)) {
                                                                array_push($phoneNumberObjects, (object)$row);
                                                            }
                                                        }
                                                    }
                                                    $activePhoneNumberHTML = "";
                                                    for ($phoneNumberIndex = 0; $phoneNumberIndex < count($phoneNumberObjects); $phoneNumberIndex++) {
                                                        if (isset($phoneNumberObjects[$phoneNumberIndex]) && isset($phoneNumberObjects[$phoneNumberIndex]->status) && $phoneNumberObjects[$phoneNumberIndex]->status == 1) {
                                                            $conditionalPart = '
                                                        <div class="col-sm-3">
                                                            <button class="btn btn-primary make-phone-number-primary" >Make Primary</button> 
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button class="btn btn-primary remove-phone-number" >Remove</button>
                                                        </div>';
                                                            if (isset($phoneNumberObjects[$phoneNumberIndex]) && isset($phoneNumberObjects[$phoneNumberIndex]->isPrimary) && $phoneNumberObjects[$phoneNumberIndex]->isPrimary == 1) {
                                                                $conditionalPart = '
                                                    <div class="col-sm-2">
                                                    <a class="btn"><span class="badge badge-info">Primary</span></a>
                                                    </div>';
                                                            }
                                                            $activePhoneNumberHTML .= ' <div class="row mb-2 each-phone-number" data-id="' . $phoneNumberObjects[$phoneNumberIndex]->id . '">
                                                            <div class="col-sm-2">
                                                                <input disabled type="tel" class="form-control" value="' . $phoneNumberObjects[$phoneNumberIndex]->code . '" name="acc-name" placeholder="+234">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <input disabled type="tel" class="form-control" name="acc-name" value="' . $phoneNumberObjects[$phoneNumberIndex]->value . '" placeholder="phone number">
                                                            </div>
                                                            ' . $conditionalPart . '
                                                            </div>';
                                                        } else if (isset($phoneNumberObjects[$phoneNumberIndex]) && isset($phoneNumberObjects[$phoneNumberIndex]->status) && $phoneNumberObjects[$phoneNumberIndex]->status == 2) {

                                                            $activePhoneNumberHTML .= ' <div class="row mb-2 each-phone-number" data-id="' . $phoneNumberObjects[$phoneNumberIndex]->id . '">
                                                    <div class="col-sm-2">
                                                        <input disabled type="tel" class="form-control" value="' . $phoneNumberObjects[$phoneNumberIndex]->code . '" name="acc-name" placeholder="+234">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input disabled type="tel" class="form-control" name="acc-name" value="' . $phoneNumberObjects[$phoneNumberIndex]->value . '" placeholder="phone number">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary request-phone-number-verification">Verify</button>
                                                    </div>
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary remove-phone-number">Remove</button>
                                                    </div>
                                        </div>';
                                                        }
                                                    }
                                                    echo '
                                            <div class="card-body card-block">
                                                <div class="form-group-field">
                                                <label for="acc-phonenumber">Phone Number</label>';
                                                    if (count($phoneNumberObjects)) {
                                                        echo $activePhoneNumberHTML;
                                                    }
                                                    echo '<div class="row">
                                                    <div class="col-sm-2">
                                                        <input type="tel" class="form-control" id="phone-number-code-add" value=""
                                        name="acc-name" placeholder="+234">
                                </div>
                                <div class="col-sm-6">
                                    <input type="tel" class="form-control" id="phone-number-add" placeholder="New phone number" name="acc-name"
                                        value=""
                                       >
                                </div>
                                <button class="btn btn-primary" id="phone-save-number">Add</button>
                            </div>';
                                                    echo '
                            </div>
                                                        </div>';
                                                    ?>
                                                </div>

                                            </div>


                                        </div>
                                        <div class="card-body card-block">
                                            <label>Contact Address</label>
                                            <?php
                                            $addressObjects = [];
                                            $queryResult = mysqli_query($conn, "SELECT * FROM `address` WHERE `subjectType` = 0 and `status` = 1 and `subjectId` = '$currentlyLoggedInUser->id'");
                                            if ($queryResult) {
                                                if (mysqli_num_rows($queryResult) > 0) {
                                                    while ($row = mysqli_fetch_assoc($queryResult)) {
                                                        array_push($addressObjects, (object)$row);
                                                    }
                                                }
                                            }
                                            for ($addressIndex = 0; $addressIndex < count($addressObjects); $addressIndex++) {
                                                if (isset($addressObjects[$addressIndex]) && isset($addressObjects[$addressIndex]->isPrimary)) {
                                                    $addressId = $addressObjects[$addressIndex]->id;
                                                    $addressValue = $addressObjects[$addressIndex]->value;
                                                    $zipcode = $addressObjects[$addressIndex]->zipcode;
                                                    if ($addressObjects[$addressIndex]->isPrimary == 1) {
                                                        echo '
                                                        <div class="form-group-field each-address" data-id="' . $addressId . '">
                                                            <div class="row">
                                                                <div class="col-sm-8">
                                                                    <textarea disabled name="description" placeholder="Enter contact address" class="form-control form-control-solid form-control-lg">' . $addressValue . '</textarea>
                                                                </div>
                                                                <div class="col-sm-4 row">
                                                                    <div class="col-sm-12 mb-1">
                                                                        <input type="tel" class="form-control" disabled value="' . $zipcode . '" placeholder="zip code">
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <button class="btn btn-primary edit-address">Edit</button>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <a class="btn">
                                                                            <span class="badge badge-info">
                                                                                Is Primary
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                    } else {
                                                        echo '
                                                        <div class="form-group-field each-address" data-id="' . $addressId . '">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <textarea disabled name="description" placeholder="Enter contact address" class="form-control form-control-solid form-control-lg">' . $addressValue . '</textarea>
                                                            </div>
                                                            <div class="col-sm-7 row">
                                                                <div class="col-sm-8 mb-1">
                                                                    <input type="tel" class="form-control" disabled value="' . $zipcode . '" placeholder="zip code">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <button class="btn btn-primary edit-address">Edit</button>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <button class="btn btn-primary remove-address">Remove</button>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <button class="btn btn-primary make-primary-address">Make
                                                                        Primary</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                    }
                                                }
                                            }
                                            echo '
                                                    <div class="form-group-field">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <textarea name="description" placeholder="Enter contact address" class="form-control form-control-solid form-control-lg" id="contact-address-input"></textarea>
                                                            </div>
                                                            <div class="col-sm-4 row">
                                                                <div class="col-sm-12 mb-1">
                                                                    <input type="text" class="form-control" value="" id="zip-code-input" placeholder="zip code">
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <button class="btn btn-primary" id="contact-address-add">Add</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                            ?>
                                        </div>
                                    </form>
                                    <div class="card-footer">
                                    </div>
                                </div>

                            </div><!-- End .row -->
                        </div>

                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar col-lg-3">
                        <div class="widget widget-dashboard">
                            <h3 class="widget-title">My Account</h3>

                            <ul class="list">
                                <li class="active"><a href="#">Account Dashboard</a></li>
                                <li><a href="#">Account Information</a></li>
                                <li><a href="#">Address Book</a></li>
                                <li><a href="#">My Orders</a></li>
                                <li><a href="#">Billing Agreements</a></li>
                                <li><a href="#">Recurring Profiles</a></li>
                                <li><a href="#">My Product Reviews</a></li>
                                <li><a href="#">My Tags</a></li>
                                <li><a href="#">My Wishlist</a></li>
                                <li><a href="#">My Applications</a></li>
                                <li><a href="#">Newsletter Subscriptions</a></li>
                                <li><a href="#">My Downloadable Products</a></li>
                            </ul>
                        </div><!-- End .widget -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
                <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="primaryModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="primaryModalLabel">Primary Email</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <b>make <span id="primaryEmailModal"></span> the primary
                                        email?</b> .</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="primary-email-button" type="button" data-dismiss="modal">Make
                                    Primary</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="addEmailModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Add Email</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <b>add <span id="addEmailModalId"></span> to your
                                        account?</b> .
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="add-email-button" type="button" data-dismiss="modal">Add
                                    Email</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="removeModalLabel">Remove Email</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <b>remove <span id="removeEmailModal"></span> primary
                                        mail?</b>
                                    .</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="remove-email-button" type="button" data-dismiss="modal">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="removeAddressModalId" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="removeModalLabel">Remove Address</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <b>remove <span id="removeAddressModal"></span> with <span id="removeAddresszipcodeModal"></span>?</b>
                                    .</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="remove-address-button" type="button" data-dismiss="modal">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="make-Address-Primary-Modal" tabindex="-1" role="dialog" aria-labelledby="primaryModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="primaryModalLabel">Primary Address</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <b>make <span id="MakePrimaryAddressModalInput"></span> with <span id="MakePrimaryAddresszipcodeModal"></span> as
                                        primary
                                        address?</b> .</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="make-primary-address-button" type="button" data-dismiss="modal">Make
                                    Primary</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editAddressModalId" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Edit Address</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group-field each-address">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <textarea name="description" placeholder="Enter contact address" id="editAddressModal" class="form-control form-control-solid form-control-lg"></textarea>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="" id="zipcodeAddressModal" placeholder="zip code">

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-danger" id="edit-address-button" type="button" data-dismiss="modal">Edit Address</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- phone number modal -->
                <div class="modal fade" id="primaryPhoneNumberModal" tabindex="-1" role="dialog" aria-labelledby="primaryPhoneNumberModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="primaryPhoneNumberModalLabel">Primary phone
                                    number</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <b>make <span id="phoneNumberModal"></span>
                                        <span id="phoneNumberModal2"></span> primary
                                        email?</b> .</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="primary-phone-number-button" type="button" data-dismiss="modal">Make
                                    Primary</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addPhoneNumberModal" tabindex="-1" role="dialog" aria-labelledby="phoneNumberModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="phoneNumberModalLabel">Add Phone Number</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to add <b><span id="phoneNumberModalId"></span><span id="phoneNumberModalId2"></span> to your account?</b> .</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="add-phone-number-button" type="button" data-dismiss="modal">Add
                                    Phone Number</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="removePhoneNumberModal" tabindex="-1" role="dialog" aria-labelledby="removePhoneNumberModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="removePhoneNumberModalLabel">Remove Phone Number
                                </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <b>remove <span id="RemoveNumberModal"></span><span id="RemoveNumberModal2"></span> primary Phone number?</b> .</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="remove-phone-number-button" type="button" data-dismiss="modal">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="requestPhoneNumberverificationModal" tabindex="-1" role="dialog" aria-labelledby="requestPhoneNumberverificationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="requestPhoneNumberverificationModalLabel">Verify
                                </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="phone-number-code-verify" value="" name="acc-name" placeholder="">
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="verify-phone-number-button" type="button" data-dismiss="modal">Verify</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End .container -->

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->

        <footer class="footer bg-dark">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">Contact Info</h4>
                                <ul class="contact-info">
                                    <li>
                                        <span class="contact-info-label">Address</span>123 Street Name, City, England
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Phone</span>Toll Free <a href="tel:">(123)
                                            456-7890</a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Email</span> <a href="mailto:mail@example.com">mail@example.com</a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Working Days/Hours</span>
                                        Mon - Sun / 9:00AM - 8:00 PM
                                    </li>
                                </ul>
                                <div class="social-icons">
                                    <a href="#" class="social-icon social-instagram icon-instagram" target="_blank" title="Instagram"></a>
                                    <a href="#" class="social-icon social-twitter icon-twitter" target="_blank" title="Twitter"></a>
                                    <a href="#" class="social-icon social-facebook icon-facebook" target="_blank" title="Facebook"></a>
                                </div><!-- End .social-icons -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-3 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">Customer Service</h4>

                                <ul class="links">
                                    <li><a href="#">Help & FAQs</a></li>
                                    <li><a href="#">Order Tracking</a></li>
                                    <li><a href="#">Shipping & Delivery</a></li>
                                    <li><a href="#">Orders History</a></li>
                                    <li><a href="#">Advanced Search</a></li>
                                    <li><a href="my-account.html">My Account</a></li>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="#">Careers</a></li>
                                    <li><a href="#">Corporate Sales</a></li>
                                    <li><a href="#">Privacy</a></li>
                                </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-3 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">Popular Tags</h4>

                                <div class="tagcloud">
                                    <a href="#">Bag</a>
                                    <a href="#">Black</a>
                                    <a href="#">Blue</a>
                                    <a href="#">Clothes</a>
                                    <a href="#">Hub</a>
                                    <a href="#">Shirt</a>
                                    <a href="#">Shoes</a>
                                    <a href="#">Skirt</a>
                                    <a href="#">Sports</a>
                                    <a href="#">Sweater</a>
                                </div>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-3 col-sm-6">
                            <div class="widget widget-newsletter">
                                <h4 class="widget-title">Subscribe newsletter</h4>
                                <p>Get all the latest information on events, sales and offers. Sign up for newsletter:
                                </p>
                                <form action="#" class="mb-0">
                                    <input type="email" class="form-control m-b-3" placeholder="Email address">

                                    <input class="btn btn-primary shadow-none" value="Subscribe">
                                </form>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="container">
                <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap">
                    <p class="footer-copyright py-3 pr-4 mb-0">&copy; Porto eCommerce. 2020. All Rights Reserved</p>

                    <img src="assets3/images/payments.png" alt="payment methods" class="footer-payments py-3">
                </div><!-- End .footer-bottom -->
            </div><!-- End .container -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li><a href="index.html">Home</a></li>
                    <li>
                        <a href="category.html">Categories</a>
                        <ul>
                            <li><a href="category-banner-full-width.html">Full Width Banner</a></li>
                            <li><a href="category-banner-boxed-slider.html">Boxed Slider Banner</a></li>
                            <li><a href="category-banner-boxed-image.html">Boxed Image Banner</a></li>
                            <li><a href="category-sidebar-left.html">Left Sidebar</a></li>
                            <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                            <li><a href="category-flex-grid.html">Product Flex Grid</a></li>
                            <li><a href="category-horizontal-filter1.html">Horizontal Filter 1</a></li>
                            <li><a href="category-horizontal-filter2.html">Horizontal Filter 2</a></li>
                            <li><a href="#">List Types</a></li>
                            <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll<span class="tip tip-new">New</span></a></li>
                            <li><a href="category.html">3 Columns Products</a></li>
                            <li><a href="category-4col.html">4 Columns Products</a></li>
                            <li><a href="category-5col.html">5 Columns Products</a></li>
                            <li><a href="category-6col.html">6 Columns Products</a></li>
                            <li><a href="category-7col.html">7 Columns Products</a></li>
                            <li><a href="category-8col.html">8 Columns Products</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="product.html">Products</a>
                        <ul>
                            <li>
                                <a href="#">Variations</a>
                                <ul>
                                    <li><a href="product.html">Horizontal Thumbs</a></li>
                                    <li><a href="product-full-width.html">Vertical Thumbnails<span class="tip tip-hot">Hot!</span></a></li>
                                    <li><a href="product.html">Inner Zoom</a></li>
                                    <li><a href="product-addcart-sticky.html">Addtocart Sticky</a></li>
                                    <li><a href="product-sidebar-left.html">Accordion Tabs</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Variations</a>
                                <ul>
                                    <li><a href="product-sticky-tab.html">Sticky Tabs</a></li>
                                    <li><a href="product-simple.html">Simple Product</a></li>
                                    <li><a href="product-sidebar-left.html">With Left Sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Product Layout Types</a>
                                <ul>
                                    <li><a href="product.html">Default Layout</a></li>
                                    <li><a href="product-extended-layout.html">Extended Layout</a></li>
                                    <li><a href="product-full-width.html">Full Width Layout</a></li>
                                    <li><a href="product-grid-layout.html">Grid Images Layout</a></li>
                                    <li><a href="product-sticky-both.html">Sticky Both Side Info<span class="tip tip-hot">Hot!</span></a></li>
                                    <li><a href="product-sticky-info.html">Sticky Right Side Info</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Pages<span class="tip tip-hot">Hot!</span></a>
                        <ul>
                            <li><a href="cart.html">Shopping Cart</a></li>
                            <li>
                                <a href="#">Checkout</a>
                                <ul>
                                    <li><a href="checkout-shipping.html">Checkout Shipping</a></li>
                                    <li><a href="checkout-shipping-2.html">Checkout Shipping 2</a></li>
                                    <li><a href="checkout-review.html">Checkout Review</a></li>
                                </ul>
                            </li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="#" class="login-link">Login</a></li>
                            <li><a href="forgot-password.html">Forgot Password</a></li>
                        </ul>
                    </li>
                    <li><a href="blog.html">Blog</a>
                        <ul>
                            <li><a href="single.html">Blog Post</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="#">Special Offer!<span class="tip tip-hot">Hot!</span></a></li>
                    <li><a href="https://1.envato.market/DdLk5" target="_blank">Buy Porto!<span class="tip tip-new">New</span></a></li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Add Cart Modal -->
    <div class="modal fade" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body add-cart-box text-center">
                    <p>You've just added this product to the<br>cart:</p>
                    <h4 id="productTitle"></h4>
                    <img src="#" id="productImage" width="100" height="100" alt="adding cart image">
                    <div class="btn-actions">
                        <a href="cart.html"><button class="btn-primary">Go to cart page</button></a>
                        <a href="#"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
    <script src="assets3/js/jquery.min.js"></script>
    <script src="assets3/js/bootstrap.bundle.min.js"></script>
    <script src="assets3/js/plugins.min.js"></script>

    <!-- Main JS File -->
    <script src="assets3/js/main.min.js"></script>
    <script>
        function isValidEmail(email) {
            var re =
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
        $(document).ready(() => {
            let activelySelectedEmail;
            let activelySelectedPhoneNumber;
            let activelySelectedAddress;

            $(document).on('click', ".make-phone-number-primary", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-phone-number");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedPhoneNumber = id;
                    $("#phoneNumberModal").text(currentRow.find("input:nth(0)").val());
                    $("#phoneNumberModal2").text(currentRow.find("input:nth(1)").val());
                    $("#primaryPhoneNumberModal").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', ".remove-phone-number", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(".each-phone-number");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedPhoneNumber = id;
                    $("#RemoveNumberModal").text(currentRow.find("input:nth(0)").val());
                    $("#RemoveNumberModal2").text(currentRow.find("input:nth(1)").val());
                    $("#removePhoneNumberModal").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', ".request-phone-number-verification", (
                event
            ) => { // requestPhoneNumberverificationModal verify-phone-number-button phone-number-code-verify
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-phone-number");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedPhoneNumber = id;
                    $("#requestPhoneNumberverificationModal").modal();
                }
            });

            $(document).on('click', "#phone-save-number", (event) => {
                event.preventDefault();
                let phoneNumber = $("#phone-number-add").val();
                let countryCode = $("#phone-number-code-add").val();

                if (!Number.isInteger(Number(countryCode)) || !countryCode.toString()
                    .length) {
                    alert("Please invalid  country code identifier");

                } else if (!phoneNumber || phoneNumber.length > 16) {
                    alert('Phone number must be 11 digits');
                } else {
                    $("#phoneNumberModalId").text(countryCode);
                    $("#phoneNumberModalId2").text(phoneNumber);
                    $("#addPhoneNumberModal").modal();
                }
            });
            $(document).on('click', "#verify-phone-number-button", (
                event
            ) => {
                event.preventDefault();
                let verificationCode = $('#phone-number-code-verify').val();
                if (!verificationCode || verificationCode.length > 7) {
                    alert('Please input verification');
                } else {
                    let data = {
                        phoneNumberId: activelySelectedPhoneNumber,
                        verificationCode,
                        action: "verify-phone-number"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error requesting phone verification");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', ".remove-address", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-address");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedAddress = id;
                    let theZipcode = currentRow.find("input").val();
                    $("#removeAddressModal").text(currentRow.find("textarea").val());
                    $("#removeAddresszipcodeModal").text(!!theZipcode ? `Zipcode: ${theZipcode}` : `No Zipcode`);
                    $("#removeAddressModalId").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', ".make-primary-address", (event) => { // MakePrimaryAddresszipcodeModalInput make-primary-address-button  
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-address");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedAddress = id;
                    let theZipcode = currentRow.find("input").val();
                    $("#MakePrimaryAddressModalInput").text(currentRow.find("textarea").val());
                    $("#MakePrimaryAddresszipcodeModal").text(currentRow.find("input").val());
                    $("#make-Address-Primary-Modal").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', ".edit-address", (event) => { //  .edit-address editAddressModalId edit-address-button zipcodeAddressModal editAddressModal
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-address");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedAddress = id;
                    $("#editAddressModal").val(currentRow.find("textarea").val());
                    $("#zipcodeAddressModal").val(currentRow.find("input").val());
                    $("#editAddressModalId").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', "#add-phone-number-button", (
                event
            ) => { //.make-phone-number-primary primaryPhoneNumberModal  phoneNumberModal primary-phone-number-button
                event.preventDefault();
                let phoneNumber = $("#phone-number-add").val();
                let countryCode = $("#phone-number-code-add").val();

                if (!phoneNumber || phoneNumber.length > 16) {
                    alert('Phone number must be 11 digits');
                } else if (!Number.isInteger(Number(countryCode)) || !countryCode.toString().length) {
                    alert("Please invalid  country code identifier");
                } else {
                    let data = {
                        phoneNumber,
                        countryCode,
                        action: "add-phone-number"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Unable to add phone number");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', "#remove-phone-number-button", (
                event
            ) => {
                event.preventDefault();
                let phoneNumberId = activelySelectedPhoneNumber;
                if (!Number.isInteger(Number(phoneNumberId)) || !phoneNumberId.toString()
                    .length) {
                    alert("Please invalid  country code identifier");
                } else {
                    let data = {
                        phoneNumberId,
                        action: "remove-phone-number"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', "#primary-phone-number-button", (
                event
            ) => {
                event.preventDefault();
                let phoneNumberId = activelySelectedPhoneNumber;
                if (!Number.isInteger(Number(phoneNumberId)) || !phoneNumberId.toString()
                    .length) {
                    alert("Please invalid  country code identifier");
                } else {
                    let data = {
                        phoneNumberId,
                        action: "make-primary-phone-number"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', "#contact-address-add", (event) => { // 
                event.preventDefault();
                let address = $("#contact-address-input").val();
                let zipcode = $("#zip-code-input").val();
                if (!(!!zipcode && typeof zipcode == "string" && zipcode.length >= 5)) {
                    zipcode = "";
                }
                if (!address || typeof address != "string") {
                    alert('Please provide your contact address');
                } else {
                    let data = {
                        address,
                        zipcode,
                        action: "add-address"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', "#edit-address-button", (event) => { // 
                event.preventDefault();
                let address = $("#editAddressModal").val();
                let zipcode = $("#zipcodeAddressModal").val();
                if (!(!!zipcode && typeof zipcode == "string" && zipcode.length >= 5)) {
                    zipcode = "";
                }
                if (!address || typeof address != "string") {
                    alert('Please provide your contact address');
                } else {
                    let data = {
                        address,
                        addressId: activelySelectedAddress,
                        zipcode,
                        action: "edit-address"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', "#remove-address-button", (event) => { //  remove-address-button
                event.preventDefault();
                let addressId = activelySelectedAddress;
                if (!Number.isInteger(Number(addressId)) || !addressId.toString().length) {
                    alert("Please invalid identifier");
                } else {
                    let data = {
                        addressId,
                        action: "remove-address"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', "#make-primary-address-button ", (event) => {
                event.preventDefault();
                let addressId = activelySelectedAddress;
                if (!Number.isInteger(Number(addressId)) || !addressId.toString().length) {
                    alert("Please invalid identifier");
                } else {
                    let data = {
                        addressId,
                        action: "make-primary-address"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });

                }
            });
            $(document).on('click', ".make-email-primary", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-email"); //primaryModal primary-color-button primaryEmailModal
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedEmail = id;
                    $("#primaryEmailModal").text(currentRow.find("input").val());
                    $("#primaryModal").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', ".remove-email", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-email"); //removeModal removeEmailModal remove-email-button
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedEmail = id;
                    $("#removeEmailModal").text(currentRow.find("input").val());
                    $("#removeModal").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', ".resend-verification-email", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(
                    ".each-email"); //removeModal removeEmailModal remove-email-button
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
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
                                emailId: id,
                                action: "resend-email-verification"
                            }), // body data type must match "Content-Type" header
                            //body
                        })
                        .then((res) => res.json())
                        .then((json) => {
                            if (json.success) {
                                alert(json.message);
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                } else {
                    alert("identifier not found");
                }
            });

            $(document).on('click', "#acc-email-add", (event) => {
                event.preventDefault();
                let newEmail = $("#acc-email").val();
                if (!newEmail || !isValidEmail(newEmail)) {
                    alert("Please provide valid email address");
                } else {
                    $("#addEmailModalId").text(newEmail);
                    $("#addEmailModal").modal();
                    console.log(addEmail);

                }
            });
            $(document).on('click', "#primary-email-button", (event) => {
                event.preventDefault();
                let emailId = activelySelectedEmail;
                if (!Number.isInteger(Number(emailId)) || !emailId.toString().length) {
                    alert("Please invalid identifier");
                } else {
                    let data = {
                        emailId,
                        action: "make-primary-mail"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
            $(document).on('click', "#remove-email-button", (event) => {
                event.preventDefault();
                let emailId = activelySelectedEmail;
                if (!Number.isInteger(Number(emailId)) || !emailId.toString().length) {
                    alert("Please invalid identifier");
                } else {
                    let data = {
                        emailId,
                        action: "remove-email"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
            $(document).on('click', "#add-email-button", (event) => { //acc-email-add acc-email
                event.preventDefault();
                let newEmail = $("#acc-email").val();
                if (!newEmail || !isValidEmail(newEmail)) {
                    alert("Please provide valid email address");
                } else {
                    let data = {
                        newEmail,
                        action: "add-email"
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
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
            $(document).on('click', '#submit', (event) => {
                event.preventDefault();
                $("#profileImage:hidden").trigger('click');
            });
            $("#profileImage").on('change', (event) => {
                if (!event.target.files || !event.target.files[0] || typeof event.target.files[0].type !=
                    "string" || event.target.files[0].type.indexOf("image/") < 0) {
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
                            if (json.success) {
                                $('#profileDisplay').attr("src", `profile-picture.php?v=${Date.now()}`);
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
            $(document).on('click', "#name-save-button", (event) => {
                event.preventDefault();
                let firstName = $("#acc-firstname").val();
                let lastName = $("#acc-lastname").val();

                if (!firstName || typeof firstName != 'string' || firstName.length < 3 || !/^[a-zA-Z]{3,}$/
                    .test(firstName)) {
                    alert("first name is");
                } else if (!lastName || typeof lastName != 'string' || lastName.length < 3 || !
                    /^[a-zA-Z]{3,}$/.test(lastName)) {
                    alert("Please name is");
                } else {
                    let data = {
                        firstName,
                        lastName,
                        action: "change-name"
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
                                window.location.href = window.location.href;
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