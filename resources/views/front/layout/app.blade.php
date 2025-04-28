
<!DOCTYPE html>
<html class="no-js" lang="en_AU">
<head>

    <meta charset="UTF-8">
    <title> NỘI THẤT ĐÀ NẴNG</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />

	<meta property="og:locale" content="en_AU" />
	<meta property="og:type" content="website" />
	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="" />
	<meta property="og:site_name" content="" />
	<meta property="og:title" content="" />
	<meta property="og:description" content="" />
	<meta property="og:url" content="" />
	<meta property="og:image" content="" />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="" />
	<meta property="og:image:height" content="" />
	<meta property="og:image:alt" content="" />

	<meta name="twitter:title" content="" />
	<meta name="twitter:site" content="" />
	<meta name="twitter:description" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:image:alt" content="" />
	<meta name="twitter:card" content="summary_large_image" />

	<link rel="stylesheet" type="text/css" href="user_ass/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="user_ass/css/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="user_ass/css/video-js.css" />
    <link rel="stylesheet" type="text/css" href="user_ass/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">

<div class="bg-light top-header">        
	<div class="container">
		<div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
			<div class="col-lg-4 logo">
				<a href="{{ route('front.home')}}" class="text-decoration-none">
					<span class="h1 text-uppercase text-primary bg-dark px-2">Nội Thất</span>
					<span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Đà Nẵng</span>
				</a>
			</div>
			<div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
				<a href="account.php" class="nav-link text-dark">My Account</a>
				<form action="">					
					<div class="input-group">
						<input type="text" placeholder="Search For Products" class="form-control" aria-label="Amount (to the nearest dollar)">
						<span class="input-group-text">
							<i class="fa fa-search"></i>
					  	</span>
					</div>
				</form>
			</div>		
		</div>
	</div>
</div>

<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-xl" id="navbar">
            <a href="{{ route('front.home')}}" class="text-decoration-none mobile-logo">
                <span class="h2 text-uppercase text-primary bg-dark">Nội Thất</span>
                <span class="h2 text-uppercase text-white px-2">Đà Nẵng</span>
            </a>
            <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Lặp qua danh mục -->
                    @foreach($categories as $category)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown{{ $category->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $category->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown{{ $category->id }}">
                            <!-- Lặp qua subcategory -->
                            @foreach($subcategories as $subcategory)
                                @if($subcategory->category_id == $category->id)
                                    <li>
                                        <a class="dropdown-item subcategory-link" href="#" data-id="{{ $subcategory->id }}">
                                            {{ $subcategory->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</header>

<main>
@yield('content')
</main>


<footer class="bg-dark mt-5">
	<div class="container pb-5 pt-3">
		<div class="row">
			<div class="col-md-4">
				<div class="footer-card">
					<h3>Get In Touch</h3>
					<p>No dolore ipsum accusam no lorem. <br>
					123 Street, New York, USA <br>
					exampl@example.com <br>
					000 000 0000</p>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>Important Links</h3>
					<ul>
						<li><a href="about-us.php" title="About">About</a></li>
						<li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>						
						<li><a href="#" title="Privacy">Privacy</a></li>
						<li><a href="#" title="Privacy">Terms & Conditions</a></li>
						<li><a href="#" title="Privacy">Refund Policy</a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>My Account</h3>
					<ul>
						<li><a href="#" title="Sell">Login</a></li>
						<li><a href="#" title="Advertise">Register</a></li>
						<li><a href="#" title="Contact Us">My Orders</a></li>						
					</ul>
				</div>
			</div>			
		</div>
	</div>
	<div class="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="copy-right text-center">
						<p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<script src="user_ass/js/jquery-3.6.0.min.js"></script>
<script src="user_ass/js/bootstrap.bundle.5.1.3.min.js"></script>
<script src="user_ass/js/instantpages.5.1.0.min.js"></script>
<script src="user_ass/js/lazyload.17.6.0.min.js"></script>
<script src="user_ass/js/slick.min.js"></script>
<script src="user_ass/js/custom.js"></script>
<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>

<script>
    $(document).ready(function() {
        $('.subcategory-link').click(function(e) {
            e.preventDefault(); // Không cho nó chuyển trang
    
            var subcategoryId = $(this).data('id'); // Lấy ID subcategory
    
            $.ajax({
                url: '/subcategory-products/' + subcategoryId, // URL route để lấy sản phẩm
                type: 'GET',
                success: function(response) {
                    // Clear sản phẩm cũ
                    $('.section-4 .row.pb-3').html('');
    
                    // Thêm sản phẩm mới
                    response.products.forEach(function(product) {
                        var productHtml = `
                        <div class="col-md-3">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="#" class="product-img">
                                        <img class="card-img-top" src="/uploads/product/${product.image}" alt="${product.name}">
                                    </a>
                                    <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                                    <div class="product-action">
                                        <a class="btn btn-dark" href="#">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="#">${product.name}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>${product.price} VND</strong></span>
                                        ${product.old_price ? `<span class="h6 text-underline"><del>${product.old_price} VND</del></span>` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
    
                        $('.section-4 .row.pb-3').append(productHtml);
                    });
                },
                error: function() {
                    alert('Không thể tải sản phẩm.');
                }
            });
        });
    });
    </script>
    
</body>
</html>