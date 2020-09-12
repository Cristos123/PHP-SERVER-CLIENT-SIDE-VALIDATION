<?php
include_once "connection.php";
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HaneysBeauty</title>
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

<body class="template-index index-demo1">
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
                            <img src="assets/images/avon-logo.svg" alt="Avone Multipurpose Html Template"
                                title="Avone Multipurpose Html Template" />
                        </a>
                    </div>
                    <!--End Desktop Logo-->
                    <div class="col-1 col-sm-1 col-md-1 col-lg-8 align-self-center d-menu-col">
                        <!--Desktop Menu-->
                        <nav class="grid__item" id="AccessibleNav">
                            <ul id="siteNav" class="site-nav medium center hidearrow">
                                <li class="lvl1 parent megamenu mdropdown"><a href="#;">Home <i
                                            class="anm anm-angle-down-l"></i></a>
                                    <div class="megamenu style1">
                                        <ul class="grid mmWrapper">
                                            <li class="grid__item large-up--one-whole">
                                                <ul class="grid">
                                                    <li class="grid__item lvl-1 col-md-6 col-lg-6">
                                                        <a href="#" class="site-nav lvl-1 menu-title">Homepages</a>
                                                        <ul class="subLinks">
                                                            <li class="lvl-2"><a href="index-medical-demo.html"
                                                                    class="site-nav lvl-2">Medical <span
                                                                        class="lbl nm_label1">New</span></a></li>
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
                                                        <input id="search" type="text" name="q" value=""
                                                            placeholder="Search for products, brands..."
                                                            class="input-text">
                                                        <button type="submit" title="Search" class="action search"
                                                            disabled=""><i class="icon anm anm-search-l"></i></button>
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

                                <?php
								if (!isset($currentlyLoggedInUser) || !$currentlyLoggedInUser) {
									echo '<p><a href="login.php" class="btn">Login</a></p>
											<p class="text-center">New User? <a href="signup.php" class="register">Create an Account</a></p>
											';
								} else {
									echo '<p><a href="logout.php" class="btn">Logout</a></p>
											<p class="text-center">Customize? <a href="my-account.php" class="register">View Account</a></p>
											<p class="text-center">Default welcome msg!</p>
											';
								}
								?>
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
                            <a href="#" class="site-header__cart btn-minicart" data-toggle="modal"
                                data-target="#minicart-drawer">
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
            <!--Home slider-->
            <div class="slideshow slideshow-wrapper">
                <div class="home-slideshow">
                    <div class="slide">
                        <div class="blur-up lazyload">
                            <img class="blur-up lazyload" data-src="assets/images/slideshow-banner/dome1-banner1.jpg"
                                src="assets/images/slideshow-banner/dome1-banner1.jpg"
                                alt=" Start Selling Online Successfully" title=" Start Selling Online Successfully" />
                            <div class="slideshow__text-wrap slideshow__overlay left">
                                <div class="slideshow__text-content">
                                    <div class="wrap-caption anim-tru left style1">
                                        <p class="mega-small-title">ARE YOU READY?</p>
                                        <h2 class="h1 mega-title slideshow__title">Start Selling Online Successfully
                                        </h2>
                                        <span class="mega-subtitle slideshow__subtitle">Creative, Flexible and High
                                            Performance Html Template!</span>
                                        <span class="btn">Shop now</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide">
                        <div class="blur-up lazyload">
                            <img class="blur-up lazyload" data-src="assets/images/slideshow-banner/dome1-banner2.jpg"
                                src="assets/images/slideshow-banner/dome1-banner2.jpg"
                                alt="The Powerful Theme You can Trust" title="The Powerful Theme You can Trust" />
                            <div class="slideshow__text-wrap slideshow__overlay right">
                                <div class="slideshow__text-content">
                                    <div class="wrap-caption anim-tru style1">
                                        <h2 class="h1 mega-title slideshow__title">The Powerful Template You can Trust
                                        </h2>
                                        <span class="mega-subtitle slideshow__subtitle">High Performance
                                            Delivered</span>
                                        <span class="btn">Shop now</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Home slider-->

            <!--Body Container-->
            <div class="container">
                <!-- Banner Masonary-->
                <div class="collection-banners style1">
                    <div class="grid-masonary banner-grid">
                        <div class="grid-sizer"></div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 banner-item">
                                <div class="collection-grid-item">
                                    <div class="img">
                                        <img class="blur-up lazyload"
                                            data-src="assets/images/collection-banner/womens-top.jpg"
                                            src="assets/images/collection-banner/womens-top.jpg" alt="" title=" " />
                                    </div>
                                    <div class="details center">
                                        <div class="inner">
                                            <h3 class="title">Women Tops</h3>
                                            <p>From world's top designer</p>
                                            <a href="#;" class="btn">Discover Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 banner-item">
                                <div class="collection-grid-item">
                                    <div class="img">
                                        <img class="blur-up lazyload"
                                            data-src="assets/images/collection-banner/men-clothing.jpg"
                                            src="assets/images/collection-banner/men-clothing.jpg" alt="" title=" " />
                                    </div>
                                    <div class="details center">
                                        <div class="inner">
                                            <h3 class="title">Men Shirts</h3>
                                            <p>Up to 70% off on selected item</p>
                                            <a href="#;" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 banner-item">
                                <div class="collection-grid-item">
                                    <div class="img">
                                        <img class="blur-up lazyload"
                                            data-src="assets/images/collection-banner/denim.jpg"
                                            src="assets/images/collection-banner/denim.jpg" alt="" title=" " />
                                    </div>
                                    <div class="details center">
                                        <div class="inner">
                                            <h3 class="title">Denim</h3>
                                            <p>Find your perfect outfit</p>
                                            <a href="#;" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 banner-item">
                                <div class="collection-grid-item">
                                    <div class="img">
                                        <img class="blur-up lazyload"
                                            data-src="assets/images/collection-banner/accesories.jpg"
                                            src="assets/images/collection-banner/accesories.jpg" alt="" title=" " />
                                    </div>
                                    <div class="details center">
                                        <div class="inner">
                                            <h3 class="title">Accessories</h3>
                                            <p>add finishing touch to your outfit</p>
                                            <a href="#;" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Banner Masonary-->

                <!--New Arrivals-->
                <div class="section product-slider">
                    <div class="section-header">
                        <h2>New Arrivals</h2>
                        <p>Shop our new arrivals from established brands</p>
                    </div>
                    <div class="productSlider grid-products">
                        
						<?php
	
	
	$result = mysqli_query($conn, "SELECT * FROM `product` LIMIT 10");
	if ($result) {
		$count = 1;
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$productId = $row["id"];
				$productTitleObject = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM `productTitle` WHERE `productId` = '$productId' LIMIT 1"));
				$productName = (isset($productTitleObject)&&
				!!$productTitleObject)?
				((isset($productTitleObject->value)&&!!$productTitleObject->value)?
				$productTitleObject->value:"No name"):"No name";
				//add-to-cart-action,product-item data-product-id
				echo '<div class="col-12 item product-item" data-product-id="'.$productId.'">
				<!-- start product image -->
				<div class="product-image">
					<!-- start product image -->
					<a href="product-layout1.php?id='.$productId.'" class="product-img">
						<!-- image -->
						<img class="primary blur-up lazyload"
							data-src="assets/images/product-images/product1.jpg"
							src="assets/images/product-images/product1.jpg" alt="" title="">
						<!-- End image -->
						<!-- Hover image -->
						<img class="hover blur-up lazyload"
							data-src="assets/images/product-images/product1-1.jpg"
							src="assets/images/product-images/product1-1.jpg" alt="" title="">
						<!-- End hover image -->
						<!-- product label -->
						<div class="product-labels"><span class="lbl on-sale">Sale</span></div>
						<!-- End product label -->
					</a>
					<!-- end product image -->

					<!--Product Button-->
					<div class="button-set style1">
						<ul>
							<li>
								<!--Cart Button-->
								<button class="btn-icon btn btn-addto-cart add-to-cart-action" type="button" tabindex="0">
										<i class="icon anm anm-cart-l"></i>
										<span class="tooltip-label">Add to Cart</span>
								</button>
								<!--end Cart Button-->
							</li>
							<li>
								<!--Quick View Button-->
								<a href="javascript:void(0)" title="Quick View"
									class="btn-icon quick-view-popup quick-view" data-toggle="modal"
									data-target="#content_quickview">
									<i class="icon anm anm-search-plus-l"></i>
									<span class="tooltip-label">Quick View</span>
								</a>
								<!--End Quick View Button-->
							</li>
							<li>
								<!--Wishlist Button-->
								<div class="wishlist-btn">
									<a class="btn-icon wishlist add-to-wishlist" href="my-wishlist.html">
										<i class="icon anm anm-heart-l"></i>
										<span class="tooltip-label">Add To Wishlist</span>
									</a>
								</div>
								<!--End Wishlist Button-->
							</li>
							<li>
								<!--Compare Button-->
								<div class="compare-btn">
									<a class="btn-icon compare add-to-compare" href="compare-style2.html"
										title="Add to Compare">
										<i class="icon icon-reload"></i>
										<span class="tooltip-label">Add to Compare</span>
									</a>
								</div>
								<!--End Compare Button-->
							</li>
						</ul>
					</div>
					<!--End Product Button-->
				</div>
				<!-- end product image -->
				<!--start product details -->
				<div class="product-details text-center">
					<!-- product name -->
					<div class="product-name">
						<a  href="product-layout1.php?id='.$productId.'">'.$productName.'</a>
					</div>
					<!-- End product name -->
					<!-- product price -->
					<div class="product-price">
						<span class="price">$399.01</span>
					</div>
					<!-- End product price -->
					<!--Product Review-->
					<div class="product-review">
						<i class="font-13 fa fa-star"></i>
						<i class="font-13 fa fa-star"></i>
						<i class="font-13 fa fa-star"></i>
						<i class="font-13 fa fa-star"></i>
						<i class="font-13 fa fa-star-o"></i>
					</div>
					<!--End Product Review-->
					<!--Color Variant -->
					<ul class="swatches">
						<li class="swatch small rounded navy"><span class="tooltip-label">Navy</span></li>
						<li class="swatch small rounded green"><span class="tooltip-label">Green</span></li>
						<li class="swatch small rounded gray"><span class="tooltip-label">Gray</span></li>
						<li class="swatch small rounded aqua"><span class="tooltip-label">Aqua</span></li>
						<li class="swatch small rounded orange"><span class="tooltip-label">Orange</span>
						</li>
					</ul>
					<!-- End Variant -->
				</div>
				<!-- End product details -->
			</div>';
			}
		}
	}
						?>
                        <div class="col-12 item">
                            <!-- start product image -->
                            <div class="product-image">
                                <!-- start product image -->
                                <a href="product-layout1.html" class="product-img">
                                    <!-- image -->
                                    <img class="primary blur-up lazyload"
                                        data-src="assets/images/product-images/product8-1.jpg"
                                        src="assets/images/product-images/product8-1.jpg" alt="" title="">
                                    <!-- End image -->
                                    <!-- Hover image -->
                                    <img class="hover blur-up lazyload"
                                        data-src="assets/images/product-images/product8.jpg"
                                        src="assets/images/product-images/product8.jpg" alt="" title="">
                                    <!-- End hover image -->
                                    <span class="sold-out"><span>Sold out</span></span>
                                </a>
                                <!-- end product image -->
                            </div>
                            <!-- end product image -->
                            <!--start product details -->
                            <div class="product-details text-center">
                                <!-- product name -->
                                <div class="product-name">
                                    <a href="product-layout1.html">Sunset Sleep Scarf Top</a>
                                </div>
                                <!-- End product name -->
                                <!-- product price -->
                                <div class="product-price">
                                    <span class="price">$99.01</span>
                                </div>
                                <!-- End product price -->
                                <!--Product Review-->
                                <div class="product-review">
                                    <i class="font-13 fa fa-star-o"></i>
                                    <i class="font-13 fa fa-star-o"></i>
                                    <i class="font-13 fa fa-star-o"></i>
                                    <i class="font-13 fa fa-star-o"></i>
                                    <i class="font-13 fa fa-star-o"></i>
                                </div>
                                <!--End Product Review-->
                                <!-- Color Variant -->
                                <ul class="swatches">
                                    <li class="swatch small rounded black"><span class="tooltip-label">black</span></li>
                                    <li class="swatch small rounded navy"><span class="tooltip-label">navy</span></li>
                                    <li class="swatch small rounded darkgreen"><span
                                            class="tooltip-label">darkgreen</span></li>
                                </ul>
                                <!-- End Variant -->
                            </div>
                            <!-- End product details -->
                        </div>

                    </div>
                </div>
            </div>
            <!--End New Arrivals-->

            <!--Collection Box slider-->
            <div class="collection-banners style1 section no-pt-section">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 banner-item">
                        <div class="imgBanner-grid-item">
                            <div class="img">
                                <a href="collection-page.html" class="collection-grid-item__link">
                                    <img data-src="assets/images/collection-banner/demo1-banr1.jpg"
                                        src="assets/images/collection-banner/demo1-banr1.jpg" alt="Fashion"
                                        class="blur-up lazyload" />
                                </a>
                            </div>
                            <div class="details center w-50">
                                <div class="inner">
                                    <h3 class="title">FIND THE BEST COLLECTION AROUND THE WORLD</h3>
                                    <a href="#;" class="btn">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 banner-item">
                        <div class="imgBanner-grid-item">
                            <div class="img">
                                <a href="collection-page.html" class="collection-grid-item__link">
                                    <img class="blur-up lazyload"
                                        data-src="assets/images/collection-banner/demo1-banr2.jpg"
                                        src="assets/images/collection-banner/demo1-banr1.jpg" alt="Cosmetic" />
                                </a>
                            </div>
                            <div class="details center w-50">
                                <div class="inner">
                                    <h3 class="title">AWESOME T-SHIRTS, CROP TOPS AND MORE...</h3>
                                    <a href="#;" class="btn">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Collection Box slider-->

        <!--Brand Logo Slider-->
        <div class="section logo-section no-pt-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="logo-bar">
                            <div class="logo-bar__item">
                                <a href="#;"><img src="assets/images/logo/brandlogo1.png" alt="" title="" /></a>
                            </div>
                            <div class="logo-bar__item">
                                <a href="#;"><img src="assets/images/logo/brandlogo2.png" alt="" title="" /></a>
                            </div>
                            <div class="logo-bar__item">
                                <a href="#;"><img src="assets/images/logo/brandlogo3.png" alt="" title="" /></a>
                            </div>
                            <div class="logo-bar__item">
                                <a href="#;"><img src="assets/images/logo/brandlogo4.png" alt="" title="" /></a>
                            </div>
                            <div class="logo-bar__item">
                                <a href="#;"><img src="assets/images/logo/brandlogo5.png" alt="" title="" /></a>
                            </div>
                            <div class="logo-bar__item">
                                <a href="#;"><img src="assets/images/logo/brandlogo6.png" alt="" title="" /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Brand Logo Slider-->

    </div>
    <!--End Body Container-->

    <!--Blog Post-->
    <div class="section home-blog-post">
        <div class="container">
            <div class="section-header">
                <h2>Fresh From Our Blog</h2>
                <p>You are going to love this amazing shopify theme.</p>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="blog-post-slider">
                        <div class="blogpost-item">
                            <a href="#;" class="post-thumb">
                                <img src="assets/images/blog/post-img1.jpg" alt="" title="" />
                            </a>
                            <div class="post-detail">
                                <h3 class="post-title"><a href="#;">Our development is your success</a></h3>
                                <ul class="publish-detail">
                                    <li><span class="article__date">March 06, 2019</span></li>
                                    <li><i class="anm anm-comments-l"></i> <a href="#;" class="btn-link">1 comment</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="blogpost-item">
                            <a href="#;" class="post-thumb">
                                <img src="assets/images/blog/post-img2.jpg" alt="" title="" />
                            </a>
                            <div class="post-detail">
                                <h3 class="post-title"><a href="#;">Ensuring Customer Success</a></h3>
                                <ul class="publish-detail">
                                    <li><span class="article__date">February 11, 2019</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="blogpost-item">
                            <a href="#;" class="post-thumb">
                                <img src="assets/images/blog/post-img3.jpg" alt="" title="" />
                            </a>
                            <div class="post-detail">
                                <h3 class="post-title"><a href="#;">We can make your business shine!</a></h3>
                                <ul class="publish-detail">
                                    <li><span class="article__date">February 19, 2019</span></li>
                                    <li><i class="anm anm-comments-l"></i> <a href="#;" class="btn-link">2 comments</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Blog Post-->

    <!--Store Feature-->
    <div class="store-features">
        <div class="container">
            <div class="row store-info">
                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <i class="anm anm-free-delivery" aria-hidden="true"></i>
                    <h5>Free Shipping &amp; Return</h5>
                    <p class="sub-text">Free shipping on all US orders</p>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <i class="anm anm-money" aria-hidden="true"></i>
                    <h5>Money Guarantee</h5>
                    <p class="sub-text">30 days money back guarantee</p>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <i class="anm anm-phone-24" aria-hidden="true"></i>
                    <h5>Online Support</h5>
                    <p class="sub-text">We support online 24/7 on day</p>
                </div>
            </div>
        </div>
    </div>
    <!--End Store Feature-->
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
                        <p><b>Email</b>: <a
                                href="/cdn-cgi/l/email-protection#7102101d140231081e04021805145f121e1c"><span
                                    class="__cf_email__"
                                    data-cfemail="a7d4c6cbc2d4e7dec8d2d4ced3c289c4c8ca">[email&#160;protected]</span></a>
                        </p>
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

                            <?php
							if (!isset($currentlyLoggedInUser) || !$currentlyLoggedInUser) {
								echo '<li><a href="login.php">Login</a></li>';
							} else {
								echo '<li><a href="logout.php">Logout</a></li>';
							}
							?>
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
                                        <input type="email" class="input-group__field newsletter-input" name="EMAIL"
                                            value="" placeholder="Email address" required>
                                        <span class="input-group__btn">
                                            <button type="submit" class="btn newsletter__submit" name="commit"
                                                id="Subscribe"><span
                                                    class="newsletter__submit-text--large">Subscribe</span></button>
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
                    <a href="javascript:void(0);" class="close-cart" data-dismiss="modal" aria-label="Close"><i
                            class="anm anm-times-r"></i></a>
                    <h4>Your cart (2 Items)</h4>
                    <div class="minicart-content">
                        <ul class="clearfix">
                            <li class="item clearfix">
                                <a class="product-image" href="#">
                                    <img src="assets/images/product-images/cart-page-img2.jpg" alt="" title="">
                                </a>
                                <div class="product-details">
                                    <a href="#" class="remove"><i class="anm anm-times-sql" aria-hidden="true"></i></a>
                                    <a href="#" class="edit-i remove"><i class="icon icon-pencil"
                                            aria-hidden="true"></i></a>
                                    <a class="product-title" href="cart-style1.html">Backpack With Contrast Bow</a>
                                    <div class="variant-cart">Black / XL</div>
                                    <div class="wrapQtyBtn">
                                        <div class="qtyField">
                                            <a class="qtyBtn minus" href="javascript:void(0);"><i
                                                    class="anm anm-minus-r" aria-hidden="true"></i></a>
                                            <input type="text" name="quantity" value="1" class="qty">
                                            <a class="qtyBtn plus" href="javascript:void(0);"><i class="anm anm-plus-r"
                                                    aria-hidden="true"></i></a>
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
                                    <a href="#" class="edit-i remove"><i class="icon icon-pencil"
                                            aria-hidden="true"></i></a>
                                    <a class="product-title" href="cart-style1.html">Innerbloom Puffer</a>
                                    <div class="variant-cart">Red / S</div>
                                    <div class="wrapQtyBtn">
                                        <div class="qtyField">
                                            <a class="qtyBtn minus" href="javascript:void(0);"><i
                                                    class="anm anm-minus-r" aria-hidden="true"></i></a>
                                            <input type="text" name="quantity" value="1" class="qty">
                                            <a class="qtyBtn plus" href="javascript:void(0);"><i class="anm anm-plus-r"
                                                    aria-hidden="true"></i></a>
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

    <!--Quickview Popup-->
    <div class="loadingBox">
        <div class="anm-spin"><i class="anm anm-spinner4"></i></div>
    </div>
    <div class="modalOverly"></div>
    <div id="quickView-modal" class="mfp-with-anim mfp-hide">
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <div id="slider">
                    <!-- model thumbnail -->
                    <div id="myCarousel" class="carousel slide">
                        <!-- image slide carousel items -->
                        <div class="carousel-inner">
                            <!-- slide 1 -->
                            <div class="item carousel-item active" data-slide-number="0">
                                <img data-src="assets/images/product-images/product2.jpg"
                                    src="assets/images/product-images/product2.jpg" alt="" title="">
                            </div>
                            <!-- End slide 1 -->
                            <!-- slide 2 -->
                            <div class="item carousel-item" data-slide-number="1">
                                <img data-src="assets/images/product-images/product2-1.jpg"
                                    src="assets/images/product-images/product2-1.jpg" alt="" title="">
                            </div>
                            <!-- End slide 3 -->
                            <!-- slide 2 -->
                            <div class="item carousel-item" data-slide-number="2">
                                <img data-src="assets/images/product-images/product2-2.jpg"
                                    src="assets/images/product-images/product2-2.jpg" alt="" title="">
                            </div>
                            <!-- End slide 3 -->
                            <!-- slide 4 -->
                            <div class="item carousel-item" data-slide-number="3">
                                <img data-src="assets/images/product-images/product2-3.jpg"
                                    src="assets/images/product-images/product2-3.jpg" alt="" title="">
                            </div>
                            <!-- End slide 4 -->
                            <!-- slide 5 -->
                            <div class="item carousel-item" data-slide-number="4">
                                <img data-src="assets/images/product-images/product2-4.jpg"
                                    src="assets/images/product-images/product2-4.jpg" alt="" title="">
                            </div>
                            <!-- End slide 4 -->
                        </div>
                        <!-- End image slide carousel items -->
                        <!-- model thumbnail image -->
                        <div class="model-thumbnail-img">
                            <!-- model thumbnail slide -->
                            <ul class="carousel-indicators list-inline">
                                <!-- slide 1 -->
                                <li class="list-inline-item active">
                                    <a id="carousel-selector-0" class="selected" data-slide-to="0"
                                        data-target="#myCarousel">
                                        <img data-src="assets/images/product-images/product2.jpg"
                                            src="assets/images/product-images/product2.jpg" alt="" title="">
                                    </a>
                                </li>
                                <!-- End slide 1 -->
                                <!-- slide 2 -->
                                <li class="list-inline-item">
                                    <a id="carousel-selector-1" data-slide-to="1" data-target="#myCarousel">
                                        <img data-src="assets/images/product-images/product2-1.jpg"
                                            src="assets/images/product-images/product2-1.jpg" alt="" title="">
                                    </a>
                                </li>
                                <!-- End slide 2 -->
                                <!-- slide 3 -->
                                <li class="list-inline-item">
                                    <a id="carousel-selector-2" class="selected" dataslide-to="2"
                                        data-target="#myCarousel">
                                        <img data-src="assets/images/product-images/product2-2.jpg"
                                            src="assets/images/product-images/product2-2.jpg" alt="" title="">
                                    </a>
                                </li>
                                <!-- End slide 3 -->
                                <!-- slide 4 -->
                                <li class="list-inline-item">
                                    <a id="carousel-selector-3" data-slide-to="3" data-target="#myCarousel">
                                        <img data-src="assets/images/product-images/product2-3.jpg"
                                            src="assets/images/product-images/product2-3.jpg" alt="" title="">
                                    </a>
                                </li>
                                <!-- End slide 4 -->
                                <!-- slide 5 -->
                                <li class="list-inline-item">
                                    <a id="carousel-selector-4" data-slide-to="4" data-target="#myCarousel">
                                        <img data-src="assets/images/product-images/product2-4.jpg"
                                            src="assets/images/product-images/product2-4.jpg" alt="" title="">
                                    </a>
                                </li>
                                <!-- End slide 5 -->
                            </ul>
                            <!-- End model thumbnail slide -->
                            <!-- arrow button -->
                            <a class="carousel-control left" href="#myCarousel" data-slide="prev"><i
                                    class="fa fa-chevron-left"></i></a>
                            <a class="carousel-control right" href="#myCarousel" data-slide="next"><i
                                    class="fa fa-chevron-right"></i></a>
                            <!-- End arrow button -->
                        </div>
                        <!-- End model thumbnail image -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <div class="product-brand"><a href="#">Charcoal</a></div>
                <h2 class="product-title">Product Quick View Popup</h2>
                <div class="product-review">
                    <div class="rating">
                        <i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i
                            class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i
                            class="font-13 fa fa-star"></i>
                    </div>
                    <div class="reviews"><a href="#">5 Reviews</a></div>
                </div>
                <div class="product-info">
                    <div class="product-stock"> <span class="instock">In Stock</span> <span
                            class="outstock hide">Unavailable</span> </div>
                    <div class="product-sku">SKU: <span class="variant-sku">19115-rdxs</span></div>
                </div>
                <div class="pricebox">
                    <span class="price old-price">$900.00</span>
                    <span class="price">$800.00</span>
                </div>
                <div class="sort-description">Avone Multipurpose Bootstrap 4 Html Template that will give you and your
                    customers a smooth shopping experience which can be used for various kinds of stores such as
                    fashion.. </div>
                <form method="post" action="#" id="product_form--option" class="product-form">
                    <div class="product-options">
                        <div class="swatch clearfix swatch-0 option1">
                            <div class="product-form__item">
                                <label class="label">Color:<span class="required">*</span> <span
                                        class="slVariant">Red</span></label>
                                <div class="swatch-element color">
                                    <input class="swatchInput" id="swatch-black" type="checkbox" name="option-0"
                                        value="Black">
                                    <label class="swatchLbl small black" for="swatch-black" title="Black"></label>
                                </div>
                                <div class="swatch-element color">
                                    <input class="swatchInput" id="swatch-blue" type="checkbox" name="option-0"
                                        value="blue">
                                    <label class="swatchLbl small blue" for="swatch-blue" title="Blue"></label>
                                </div>
                                <div class="swatch-element color">
                                    <input class="swatchInput" id="swatch-red" type="radio" name="option-0"
                                        value="Blue">
                                    <label class="swatchLbl small red" for="swatch-red" title="Red"></label>
                                </div>
                                <div class="swatch-element color">
                                    <input class="swatchInput" id="swatch-pink" type="radio" name="option-0"
                                        value="Pink">
                                    <label class="swatchLbl color small pink" for="swatch-pink" title="Pink"></label>
                                </div>
                                <div class="swatch-element color">
                                    <input class="swatchInput" id="swatch-orange" type="radio" name="option-0"
                                        value="Orange">
                                    <label class="swatchLbl color small orange" for="swatch-orange"
                                        title="Orange"></label>
                                </div>
                                <div class="swatch-element color">
                                    <input class="swatchInput" id="swatch-yellow" type="radio" name="option-0"
                                        value="Yellow">
                                    <label class="swatchLbl color small yellow" for="swatch-yellow"
                                        title="Yellow"></label>
                                </div>
                            </div>
                        </div>
                        <div class="swatch clearfix swatch-1 option2">
                            <div class="product-form__item">
                                <label class="label">Size:<span class="required">*</span> <span
                                        class="slVariant">XS</span></label>
                                <div class="swatch-element xs">
                                    <input class="swatchInput" id="swatch-1-xs" type="radio" name="option-1" value="XS">
                                    <label class="swatchLbl medium" for="swatch-1-xs" title="XS">XS</label>
                                </div>
                                <div class="swatch-element s">
                                    <input class="swatchInput" id="swatch-1-s" type="radio" name="option-1" value="S">
                                    <label class="swatchLbl medium" for="swatch-1-s" title="S">S</label>
                                </div>
                                <div class="swatch-element m">
                                    <input class="swatchInput" id="swatch-1-m" type="radio" name="option-1" value="M">
                                    <label class="swatchLbl medium" for="swatch-1-m" title="M">M</label>
                                </div>
                                <div class="swatch-element l">
                                    <input class="swatchInput" id="swatch-1-l" type="radio" name="option-1" value="L">
                                    <label class="swatchLbl medium" for="swatch-1-l" title="L">L</label>
                                </div>
                            </div>
                        </div>
                        <div class="product-action clearfix">
                            <div class="quantity">
                                <div class="wrapQtyBtn">
                                    <div class="qtyField">
                                        <a class="qtyBtn minus" href="javascript:void(0);"><i class="fa anm anm-minus-r"
                                                aria-hidden="true"></i></a>
                                        <input type="text" id="Quantity" name="quantity" value="1"
                                            class="product-form__input qty">
                                        <a class="qtyBtn plus" href="javascript:void(0);"><i class="fa anm anm-plus-r"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <button type="button" class="btn button-cart">
                                    <span>Add to cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="wishlist-btn">
                    <a class="wishlist add-to-wishlist" href="#" title="Add to Wishlist"><i class="icon anm anm-heart-l"
                            aria-hidden="true"></i> <span>Add to Wishlist</span></a>
                </div>
                <div class="share-icon">
                    <span>Share:</span>
                    <ul class="list--inline social-icons">
                        <li><a href="#" target="_blank"><i class="icon icon-facebook"></i></a></li>
                        <li><a href="#" target="_blank"><i class="icon icon-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="icon icon-pinterest"></i></a></li>
                        <li><a href="#" target="_blank"><i class="icon icon-instagram"></i></a></li>
                        <li><a href="#" target="_blank"><i class="icon icon-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--End Quickview Popup-->

    <!--Newsletter Popup-->
    <div id="newsletter-modal" class="style2 mfp-with-anim mfp-hide">
        <div class="newsltr-tbl">
            <div class="newsltr-img small--hide"><img src="assets/images/newsletter/newsletter_540.jpg" alt=""></div>
            <div class="newsltr-text text-center">
                <div class="wraptext">
                    <h2>Join Our Mailing List</h2>
                    <p class="sub-text">Stay Informed! Monthly Tips, Tracks and Discount. </p>
                    <form action="#" class="mcNewsletter" method="post">
                        <div class="input-group">
                            <input type="email" class="newsletter__input" name="EMAIL" value=""
                                placeholder="Email address" required>
                            <span class="">
                                <button type="submit" class="btn mcNsBtn" name="commit"><span>Subscribe</span></button>
                            </span>
                        </div>
                    </form>
                    <ul class="list--inline social-icons">
                        <li><a class="si-link" href="#" title="Facebook" target="_blank"><i class="anm anm-facebook-f"
                                    aria-hidden="true"></i></a></li>
                        <li><a class="si-link" href="#" title="Twitter" target="_blank"><i class="anm anm-twitter"
                                    aria-hidden="true"></i></a></li>
                        <li><a class="si-link" href="#" title="Pinterest" target="_blank"><i class="anm anm-pinterest-p"
                                    aria-hidden="true"></i></a></li>
                        <li><a class="si-link" href="#" title="Instagram" target="_blank"><i class="anm anm-instagram"
                                    aria-hidden="true"></i></a></li>
                    </ul>
                    <p class="checkboxlink">
                        <input type="checkbox" id="dontshow">
                        <label for="dontshow">Don't show this popup again</label>
                    </p>
                </div>
            </div>
        </div>
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </div>
    <!--End Newsletter Popup-->

    <!--Product Promotion Popup-->
    <div class="product-notification" id="dismiss">
        <span class="close" aria-hidden="true"><i class="anm anm-times-r"></i></span>
        <div class="media">
            <img class="mr-2" src="assets/images/product-images/product8.jpg" alt="Generic placeholder image" />
            <div class="media-body">
                <h5 class="mt-0 mb-1">Someone purchsed a</h5>
                <p class="pname">Lorem ipsum dolor sit amet</p>
                <p class="detail">14 Minutes ago from New York, USA</p>
            </div>
        </div>
    </div>
    <!--End Product Promotion Popup-->

    <!-- Including Jquery -->
    <script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="assets/js/vendor/js.cookie.js"></script>
    <!--Including Javascript-->
    <script src="assets/js/plugins.js"></script>
	<script src="assets/js/main.js"></script>
	<script>
		//add-to-cart-action,product-item data-product-id
		console.log("entered script");
		$(document).ready(()=>{
		console.log("document ready");
			$(document).on("click",".add-to-cart-action",(event)=>{
				event.preventDefault();
				const productId = $(event.target).parents(".product-item").data("product-id");
				if(Number.isInteger(Number(productId))){
					let data = {
						productId,
						action: "add-to-cart"

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
                            } else {
                                alert(json.message || "Failure to update cart");
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