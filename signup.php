<?php
include_once "connection.php";
if (isset($currentlyLoggedInUser) && !!$currentlyLoggedInUser) {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Create An Account - HaneysBeauty</title>
    <meta name="description" content="description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body class="register-page">
    <div id="pre-loader">
        <img src="assets/images/loader.gif" alt="Loading..." />
    </div>
    <div class="page-wrapper">
        <!--Header-->
        <header class="header animated d-flex align-items-center header-1">
            <div class="container">
                <div class="row">
                    <!--Mobile Icons-->
                    <div class="col-4 col-sm-4 col-md-4 d-block d-lg-none mobile-icons">
                        <!--Mobile Toggle-->
                        <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open">
                            <i class="icon anm anm-times-l"></i>
                            <i class="anm anm-bars-r"></i>
                        </button>
                        <!--End Mobile Toggle-->
                        <!--Search-->
                        <div class="site-search iconset">
                            <i class="icon anm anm-search-l"></i>
                        </div>
                        <!--End Search-->
                    </div>
                    <!--Mobile Icons-->
                    <!--Desktop Logo-->
                    <div class="logo col-4 col-sm-4 col-md-4 col-lg-2 align-self-center">
                        <a href="/">
                            <img src="assets/images/avon-logo.svg" alt="Avone Multipurpose Html Template" title="Avone Multipurpose Html Template" />
                        </a>
                    </div>
                    <!--End Desktop Logo-->
                    <div class="col-1 col-sm-1 col-md-1 col-lg-8 align-self-center d-menu-col">
                        <!--Desktop Menu-->
                        <nav class="grid__item" id="AccessibleNav">
							<ul id="siteNav" class="site-nav medium center hidearrow">
								<li class="lvl1 parent megamenu mdropdown"><a href="#;">Home <i class="anm anm-angle-down-l"></i></a>
									<div class="megamenu style1">
										<ul class="grid mmWrapper">
											<li class="grid__item large-up--one-whole">
												<ul class="grid">
													<li class="grid__item lvl-1 col-md-6 col-lg-6">
														<a href="#" class="site-nav lvl-1 menu-title">Homepages</a>
														<ul class="subLinks">
															<li class="lvl-2"><a href="index-medical-demo.html" class="site-nav lvl-2">Medical <span class="lbl nm_label1">New</span></a></li>
														</ul>
													</li>
												</ul>
											</li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
                        <!--End Desktop Menu-->
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-2 align-self-center icons-col text-right">
                        <!--Search-->
                        <div class="site-search iconset">
                            <i class="icon anm anm-search-l"></i>
                        </div>
                        <div class="search-drawer">
                            <div class="container">
                                <span class="closeSearch anm anm-times-l"></span>
                                <h3 class="title">What are you looking for?</h3>
                                <div class="block block-search">
                                    <div class="block block-content">
                                        <form class="form minisearch" id="header-search" action="#" method="get">
                                            <label for="search" class="label"><span>Search</span></label>
                                            <div class="control">
                                                <div class="searchField">
                                                    <div class="search-category">
                                                        <select id="rgsearch-category">
                                                            <option value="0">All Categories</option>
                                                            <option value="4">Shop</option>
                                                            <option value="6">- All</option>
                                                            <option value="8">- Men</option>
                                                            <option value="10">- Women</option>
                                                            <option value="12">- Shoes</option>
                                                            <option value="14">- Blouses</option>
                                                            <option value="16">- Pullovers</option>
                                                            <option value="18">- Bags</option>
                                                            <option value="20">- Accessories</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-box">
                                                        <input id="search" type="text" name="q" value="" placeholder="Search for products, brands..." class="input-text">
                                                        <button type="submit" title="Search" class="action search" disabled=""><i class="icon anm anm-search-l"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Search-->
                        <!--Setting Dropdown-->
                        <div class="setting-link iconset">
                            <i class="icon icon-settings"></i>
                        </div>
                        <div id="settingsBox">
                            <div class="customer-links">
                                <p><a href="login.php" class="btn">Login</a></p>
                                <p class="text-center">New User? <a href="signup.php" class="register">Create an Account</a></p>
                                <p class="text-center">Default welcome msg!</p>
                            </div>
                            <div class="currency-picker">
                                <span class="ttl">Select Currency</span>
                                <ul id="currencies" class="cnrLangList">
                                    <li class="selected"><a href="#;">INR</a></li>
                                    <li><a href="#;">GBP</a></li>
                                    <li><a href="#;">CAD</a></li>
                                    <li><a href="#;">USD</a></li>
                                    <li><a href="#;">AUD</a></li>
                                    <li><a href="#;">EUR</a></li>
                                    <li><a href="#;">JPY</a></li>
                                </ul>
                            </div>
                            <div class="language-picker">
                                <span class="ttl">SELECT LANGUAGE</span>
                                <ul id="language" class="cnrLangList">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a>German</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Setting Dropdown-->
                        <!--Wishlist-->
                        <div class="wishlist-link iconset">
                            <i class="icon anm anm-heart-l"></i>
                            <span class="wishlist-count">0</span>
                        </div>
                        <!--End Wishlist-->
                        <!--Minicart Dropdown-->
                        <div class="header-cart iconset">
                            <a href="#" class="site-header__cart btn-minicart" data-toggle="modal" data-target="#minicart-drawer">
                                <i class="icon anm anm-bag-l"></i>
                                <span class="site-cart-count">2</span>
                            </a>
                        </div>
                        <!--End Minicart Dropdown-->
                    </div>
                </div>
            </div>
        </header>
        <!--End Header-->
        <!--Mobile Menu-->
        <div class="mobile-nav-wrapper" role="navigation">
			<div class="closemobileMenu"><i class="icon anm anm-times-l pull-right"></i> Close Menu</div>
			<ul id="MobileNav" class="mobile-nav">
				<li class="lvl1 parent megamenu"><a href="/">Home <i class="anm anm-plus-l"></i></a>
					<ul>
						<li><a href="#" class="site-nav">Homepages<i class="anm anm-plus-l"></i></a>
							<ul>
								<li><a href="index-medical-demo.html" class="site-nav">Medical</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
        <!--End Mobile Menu-->

        <div id="page-content">
            <!--Body Container-->
            <!--Breadcrumbs-->
            <div class="breadcrumbs-wrapper">
                <div class="container">
                    <div class="breadcrumbs"><a href="/" title="Back to the home page">Home</a> <span aria-hidden="true">|</span> <span>Create An Account</span></div>
                </div>
            </div>
            <!--End Breadcrumbs-->
            <!--Page Title with Image-->
            <div class="page-title">
                <h1>Create An Account</h1>
            </div>
            <!--End Page Title with Image-->
            <div class="container">
                <!--Main Content-->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 box">
                        <div class="mb-4">
                            <h3>Personal Information</h3>
                            <form method="post" action="" accept-charset="UTF-8" class="contact-form">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="CustomerFirstName">First Name <span class="required">*</span></label>
                                            <input id="CustomerFirstName" type="text" placeholder="" class="" autocorrect="off" autocapitalize="off" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="CustomerLastName">Last Name <span class="required">*</span></label>
                                            <input id="CustomerLastName" type="text" placeholder="" class="" autocorrect="off" autocapitalize="off" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="CustomerEmail">Email Address <span class="required">*</span></label>
                                            <input id="CustomerEmail" type="email" placeholder="" class="" autocorrect="off" autocapitalize="off" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="CustomerUsername">Username <span class="required">*</span></label>
                                            <input id="CustomerUsername" type="text" placeholder="" class="" autocorrect="off" autocapitalize="off" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group form-check col-12 col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-check-label padding-15px-left">
                                            <input id="terms" type="checkbox" class="form-check-box" value=""> &nbsp;Agree to terms
                                        </label>
                                    </div>
                                </div>
                                <h3>Login Information</h3>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="CustomerPassword">Password <span class="required">*</span></label>
                                            <input id="CustomerPassword" type="password" name="customer[Password]" placeholder="" class="" autocorrect="off" autocapitalize="off" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="CustomerConfirmPassword">Confirm Password <span class="required">*</span></label>
                                            <input id="CustomerConfirmPassword" type="Password" name="customer[ConfirmPassword]" placeholder="" class="" autocorrect="off" autocapitalize="off" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-left col-12 col-sm-12 col-md-6 col-lg-6">
                                        <input id="send_button" type="submit" class="btn mb-3" value="Submit">
                                    </div>
                                    <div class="text-right col-12 col-sm-12 col-md-6 col-lg-6">
                                        <a href="login.php">« Back To Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Main Content-->
            </div>
            <!--End Body Container-->

        </div>
        <!--End Page Wrapper-->

        <!--Footer-->
        <div class="footer footer-1">
            <div class="footer-top clearfix">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 about-us-col">
                            <img src="assets/images/footer-logo.png" alt="Avone" />
                            <p>55 Gallaxy Enque,<br>2568 steet, 23568 NY</p>
                            <p><b>Phone</b>: (440) 000 000 0000</p>
                            <p><b>Email</b>: <a href="/cdn-cgi/l/email-protection#5221333e3721122b3d27213b26377c313d3f"><span class="__cf_email__" data-cfemail="97e4f6fbf2e4d7eef8e2e4fee3f2b9f4f8fa">[email&#160;protected]</span></a></p>
                            <ul class="list--inline social-icons">
                                <li><a href="#" target="_blank"><i class="icon icon-facebook"></i></a></li>
                                <li><a href="#" target="_blank"><i class="icon icon-twitter"></i></a></li>
                                <li><a href="#" target="_blank"><i class="icon icon-pinterest"></i></a></li>
                                <li><a href="#" target="_blank"><i class="icon icon-instagram"></i></a></li>
                                <li><a href="#" target="_blank"><i class="icon icon-youtube"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 footer-links">
                            <h4 class="h4">Quick Shop</h4>
                            <ul>
                                <li><a href="#">Women</a></li>
                                <li><a href="#">Men</a></li>
                                <li><a href="#">Kids</a></li>
                                <li><a href="#">Sportswear</a></li>
                                <li><a href="#">Sale</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 footer-links">
                            <h4 class="h4">Informations</h4>
                            <ul>
                                <li><a href="aboutus-style1.html">About us</a></li>
                                <li><a href="login.php">Login</a></li>
                                <li><a href="#">Privacy policy</a></li>
                                <li><a href="#">Terms &amp; condition</a></li>
                                <li><a href="my-account.html">My Account</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 footer-links">
                            <h4 class="h4">Customer Services</h4>
                            <ul>
                                <li><a href="#">Request Personal Data</a></li>
                                <li><a href="faqs-style1.html">FAQ's</a></li>
                                <li><a href="contact-style1.html">Contact Us</a></li>
                                <li><a href="#">Orders and Returns</a></li>
                                <li><a href="#">Support Center</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 newsletter-col">
                            <div class="display-table">
                                <div class="display-table-cell footer-newsletter">
                                    <form action="#" method="post">
                                        <label class="h4">Newsletter</label>
                                        <p>Enter your email to receive daily news and get 20% off coupon for all items.</p>
                                        <div class="input-group">
                                            <input type="email" class="input-group__field newsletter-input" name="EMAIL" value="" placeholder="Email address" required>
                                            <span class="input-group__btn">
                                                <button type="submit" class="btn newsletter__submit" name="commit" id="Subscribe"><span class="newsletter__submit-text--large">Subscribe</span></button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom clearfix">
                <div class="container">
                    <ul class="payment-icons list--inline">
                        <li><i class="anm anm-cc-visa" aria-hidden="true"></i></li>
                        <li><i class="anm anm-cc-mastercard" aria-hidden="true"></i></li>
                        <li><i class="anm anm-cc-amex" aria-hidden="true"></i></li>
                        <li><i class="anm anm-cc-paypal" aria-hidden="true"></i></li>
                        <li><i class="anm anm-cc-discover" aria-hidden="true"></i></li>
                        <li><i class="anm anm-cc-stripe" aria-hidden="true"></i></li>
                        <li><i class="anm anm-cc-jcb" aria-hidden="true"></i></li>
                    </ul>
                    <div class="copytext">
                        &copy; 2020 Avone. All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
        <!--End Footer-->

        <!--Scoll Top-->
        <span id="site-scroll"><i class="icon anm anm-arw-up"></i></span>
        <!--End Scoll Top-->

        <!--MiniCart Drawer-->
        <div class="minicart-right-drawer modal right fade" id="minicart-drawer">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="cart-drawer" class="block block-cart">
                        <a href="javascript:void(0);" class="close-cart" data-dismiss="modal" aria-label="Close"><i class="anm anm-times-r"></i></a>
                        <h4>Your cart (2 Items)</h4>
                        <div class="minicart-content">
                            <ul class="clearfix">
                                <li class="item clearfix">
                                    <a class="product-image" href="#">
                                        <img src="assets/images/product-images/cart-page-img2.jpg" alt="" title="">
                                    </a>
                                    <div class="product-details">
                                        <a href="#" class="remove"><i class="anm anm-times-sql" aria-hidden="true"></i></a>
                                        <a href="#" class="edit-i remove"><i class="icon icon-pencil" aria-hidden="true"></i></a>
                                        <a class="product-title" href="cart-style1.html">Backpack With Contrast Bow</a>
                                        <div class="variant-cart">Black / XL</div>
                                        <div class="wrapQtyBtn">
                                            <div class="qtyField">
                                                <a class="qtyBtn minus" href="javascript:void(0);"><i class="anm anm-minus-r" aria-hidden="true"></i></a>
                                                <input type="text" name="quantity" value="1" class="qty">
                                                <a class="qtyBtn plus" href="javascript:void(0);"><i class="anm anm-plus-r" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <div class="priceRow">
                                            <div class="product-price">
                                                <span class="money">$59.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item clearfix">
                                    <a class="product-image" href="#">
                                        <img src="assets/images/product-images/cart-page-img1.jpg" alt="" title="">
                                    </a>
                                    <div class="product-details">
                                        <a href="#" class="remove"><i class="anm anm-times-sql" aria-hidden="true"></i></a>
                                        <a href="#" class="edit-i remove"><i class="icon icon-pencil" aria-hidden="true"></i></a>
                                        <a class="product-title" href="cart-style1.html">Innerbloom Puffer</a>
                                        <div class="variant-cart">Red / S</div>
                                        <div class="wrapQtyBtn">
                                            <div class="qtyField">
                                                <a class="qtyBtn minus" href="javascript:void(0);"><i class="anm anm-minus-r" aria-hidden="true"></i></a>
                                                <input type="text" name="quantity" value="1" class="qty">
                                                <a class="qtyBtn plus" href="javascript:void(0);"><i class="anm anm-plus-r" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <div class="priceRow">
                                            <div class="product-price">
                                                <span class="money">$89.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="minicart-bottom">
                            <div class="subtotal list">
                                <span>Shipping:</span>
                                <span class="product-price">$10.00</span>
                            </div>
                            <div class="subtotal list">
                                <span>Tax:</span>
                                <span class="product-price">$05.00</span>
                            </div>
                            <div class="subtotal">
                                <span>Total:</span>
                                <span class="product-price">$93.13</span>
                            </div>
                            <button type="button" class="btn proceed-to-checkout">Proceed to Checkout</button>
                            <button type="button" class="btn btn-secondary cart-btn">View Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End MiniCart Drawer-->

        <!-- Including Jquery -->
        <script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
        <script src="assets/js/vendor/js.cookie.js"></script>
        <!-- Including Javascript -->
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>
        <script>
            function isValidEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }

            $(document).ready(() => {
                $(document).on("click", "#terms", (event) => {
                    let checkbox = $('#terms').prop("checked");
                    //console.log("checkbox", checkbox);
                    $('#send_button').prop("disabled", !checkbox);
                });
                $(document).on("click", "#send_button", (event) => {
                    event.preventDefault();
                    let firstname = $('#CustomerFirstName').val();
                    let lastname = $('#CustomerLastName').val();
                    let email = $('#CustomerEmail').val();
                    let username = $('#CustomerUsername').val();
                    let password = $('#CustomerPassword').val();
                    let confirmPassword = $('#CustomerConfirmPassword').val();
                    let checkbox = $('#terms').prop("checked");
                    //let submit = $('#send_button').prop("checked");

                    if (!firstname || typeof firstname != 'string' || firstname.length < 3 || !/^[a-zA-Z]{3,}$/.test(firstname)) {
                        alert("first name is required");
                    } else if (!lastname || typeof lastname != 'string' || lastname.length < 3 || !/^[a-zA-Z]{3,}$/.test(lastname)) {
                        alert("Please name is required");
                    } else if (!email || !isValidEmail(email)) {
                        alert("Please provide valid email address");
                    } else if (!username || typeof username != 'string' || username.length < 3 || !/^[a-zA-Z0-9]{3,}$/.test(username)) {
                        alert("Please provide username");
                    } else if (!password || typeof password != "string" || password.length < 8) {
                        alert("Please Password must be at least eight character long");
                    } else if (!confirmPassword || typeof confirmPassword != "string" || confirmPassword.length < 8) {
                        alert("Confirm Password must be at least eight character long");
                    } else if (password != confirmPassword) {
                        alert("Confirm Password must match password field");
                    } else if (!checkbox) {
                        alert("Please accept terms and condition");
                    } else {

                        let data = {
                            username,
                            password,
                            firstname,
                            lastname,
                            email,
                            confirmPassword,
                            checkbox,
                            action: "register"
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
                                const {
                                    success,
                                    message,
                                    redirectTo
                                } = json || {};
                                if (success) {
                                    alert(message);
                                    window.location.href = redirectTo || "index.php"
                                } else {
                                    alert(message || "Error resgister user");
                                }
                            }).catch((error) => {
                                console.log("error", error);
                            });
                    }
                });
            });
        </script>

    </div>
</body>

</html>