<?php
session_start(); // Start the session

require('connect.php'); // Include your database connection file

if (isset($_GET['prd_id'])) {
    
    $decodedString = base64_decode($_GET['prd_id']);
    $parts = explode('-', $decodedString);
    $prd_id = $parts[0]; // Extract the actual product ID

    // Query to retrieve the main tourist place information from the 'tourist' table
    $sql = "SELECT * FROM product WHERE prd_id = $prd_id";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prd_name = $row['prd_name'];
        $prd_desc = $row['prd_desc'];
        $prd_price = $row['prd_price'];
        $price_promotion = $row['price_promotion'];
        $prd_img = $row['prd_img'];
        $prd_id = $row['prd_id'];
        $pty_id = $row['pty_id'];
        $soldOut = $row["amount"] == 0;
        $imgClass = $soldOut ? 'sold-out' : '';
        $overlay = $soldOut ? '<div class="sold-out-overlay">Sold Out</div>' : '';
       
    } else {
        echo "ไม่พบข้อมูลสถานที่ท่องเที่ยว";
        exit;
    }

    // Query to retrieve additional images for the specified tourist place
    $additionalImages = array(); // Initialize an array to store additional images

    $additionalImagesSql = "SELECT * FROM product_img WHERE prd_id = $prd_id";
    $additionalImagesResult = $proj_connect->query($additionalImagesSql);

    if ($additionalImagesResult->num_rows > 0) {
        while ($imageRow = $additionalImagesResult->fetch_assoc()) {
            $additionalImages[] = $imageRow['img'];
        }
    }

    
} else {
    echo "ระบุ p_id ไม่ถูกต้อง";
    exit;
}
$sql = "SELECT * FROM product WHERE prd_reccom = 1";
$result = $proj_connect->query($sql);

// Check if any products were found
if ($result->num_rows > 0) {
    $recommendedProducts = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $recommendedProducts = [];
}
?>


<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php include('mainweb_page/head.php'); ?>
    <!-- head -->

<body>
<header>
    <!-- Navbar -->
    <?php include('mainweb_page/nav_bar.php'); ?>
    <!-- Navbar -->
</header>

<main>


    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light"><?php echo $prd_name; ?> </h1>
        
            </div>
        </div>
    </section>

 

    <div class="container">
        
        <div class="row">
             
            <div class="col-md-8">
                
                 <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $prd_img; ?>" alt="<?php echo $prd_name; ?>" class="img-fluid img-thumbnail rounded mx-auto d-block">
            </div>
            <div class="col-md-4">
                <h1><?php echo $prd_name; ?></h1>
                <p class="lead"><?php echo $prd_desc; ?></p>
                <?php if ($price_promotion > 0): ?>
        <h3 class="text-danger">ราคา: <?php echo number_format($price_promotion, 2); ?>  บาท</h3>
        <p class="text-muted"><del>ราคาปกติ: <?php echo number_format($prd_price, 2); ?>  บาท</del></p>
    <?php else: ?>
        <h3>ราคา: <?php echo number_format($prd_price, 2); ?> THB</h3>
    <?php endif; ?>
                <?php
   if (!$soldOut && (isset($_SESSION['mmb_username']) || isset($_SESSION['line_profile']))) { // ตรวจสอบว่ามี session mmb_username หรือไม่
    // ถ้ามี session mmb_username ให้แสดงปุ่ม "เพิ่มไปยังตะกร้า"
?>
    <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="addToCart(<?php echo $prd_id; ?>, <?php echo $_SESSION['mmb_id']; ?>, <?php echo $pty_id; ?>,'<?php echo $prd_name; ?>', <?php echo $prd_price; ?>)">
        <i class="fas fa-cart-plus"></i> เพิ่มไปยังตะกร้า
    </a>
    
    
<?php
} // ปิดเงื่อนไข
?>
             
            </div>
        </div>
    </div>


   <!-- Display additional tourist images in a grid with 3 columns -->
   <?php if (!empty($additionalImages)): ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-left">รูปภาพเพิ่มเติม</h3>
                    <div class="row">
                        <?php foreach ($additionalImages as $image): ?>
                            <div class="col-md-4">
                                <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $image; ?>" alt="Additional Image" class="img-fluid img-thumbnail">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    
   
    









<div class="container my-5">
    <div class="row">
        <div class="col-md-5">
            <div class="main-img">
                <!-- Main Product Image -->
                <img class="img-fluid img-thumbnail rounded " src="<?php echo $prd_img ? 'startbootstrap-sb-admin-2-gh-pages/pages/product/' . $prd_img : 'http://via.placeholder.com/640x360.jpg'; ?>" alt="<?php echo $prd_name; ?>">

                <!-- Additional Images -->
                <div class="row my-3 previews">
                    <?php if (!empty($additionalImages)): ?>
                        <?php foreach ($additionalImages as $image): ?>
                            <div class="col-md-3">
                                <img class="w-100 img-thumbnail rounded " src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $image; ?>" alt="<?php echo $prd_name; ?>">
                            </div>
                        <?php endforeach; ?>
                   
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Remaining code -->
  

        <div class="col-md-7">
        <div class="card shadow-lg">
        <div class="card-body">
            <div class="main-description px-2">
                <div class="product-title text-bold my-3">
                    <?php echo $prd_name; ?>
                </div>

                <!-- Pricing Area -->
                <div class="price-area my-4">
                    <?php if ($price_promotion > 0): ?>
                        <p class="old-price mb-1">
                            <del>$<?php echo number_format($prd_price, 2); ?></del>
                            <span class="old-price-discount text-danger">
                                (<?php echo round((($prd_price - $price_promotion) / $prd_price) * 100); ?>% off)
                            </span>
                        </p>
                        <p class="new-price text-bold mb-1">$<?php echo number_format($price_promotion, 2); ?></p>
                    <?php else: ?>
                        <p class="new-price text-bold mb-1">$<?php echo number_format($prd_price, 2); ?></p>
                    <?php endif; ?>
                    <p class="text-secondary mb-1">(Additional tax may apply on checkout)</p>
                </div>

                <!-- Buttons and Quantity Input -->
                <div class="buttons d-flex my-5">
                    <div class="block">
                        <a href="#" class="shadow btn custom-btn">Wishlist</a>
                    </div>
                    <div class="block">
                        <button class="shadow btn custom-btn" onclick="addToCart(<?php echo $prd_id; ?>)">Add to cart</button>
                    </div>
                    <div class="block quantity">
                        <input type="number" class="form-control" id="cart_quantity" value="1" min="1" max="5">
                    </div>
                </div>

                <!-- Product Details -->
                <div class="product-details my-4">
                    <p class="details-title text-color mb-1">Product Details</p>
                    <p class="description"><?php echo $prd_desc; ?></p>
                </div>

                <!-- Other sections like Delivery, Questions, etc. -->
                ...
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-body">
       <ul class="nav nav-tabs mt-5" id="productTab" role="tablist">
           <li class="nav-item" role="presentation">
               <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                   type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
           </li>
           <li class="nav-item" role="presentation">
               <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button"
                   role="tab" aria-controls="specs" aria-selected="false">Specifications</button>
           </li>
           <li class="nav-item" role="presentation">
               <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                   role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
           </li>
       </ul>
       <div class="tab-content" id="productTabContent">
           <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
               <p class="mt-3">
               <?php echo $prd_desc; ?>
               </p>
           </div>
           <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="specs-tab">
               <table class="table mt-3">
                   <tr>
                       <th>Weight</th>
                       <td>1kg</td>
                   </tr>
                   <tr>
                       <th>Dimensions</th>
                       <td>10 x 20 x 5 cm</td>
                   </tr>
               </table>
           </div>
           <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
               <div class="mt-3">
                   <h5>John Doe</h5>
                   <p>I loved this product! It really changed the way I work.</p>
                   <h5>Jane Smith</h5>
                   <p>Great quality and excellent after-sales service.</p>
   
               </div>
           </div>
       </div>
   </div>
   </div>
</div>

</div>

<div class="container my-4">
    <!-- Card to wrap the similar products section -->
    <div class="card shadow-lg">
        <div class="card-body">
            <h5 class="card-title display-5">Similar Products</h5>
            <hr>

            <!-- Similar Products Row -->
            <div class="row">
                <?php foreach ($recommendedProducts as $product): ?>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <!-- Badge -->
                            <span class="badge bg-primary position-absolute" style="top: 10px; left: 10px;">Recommended</span>
                            
                            <!-- Product Image -->
                            <img class="card-img-top" src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $product['prd_img']; ?>" alt="<?php echo $product['prd_name']; ?>">

                            <!-- Card Body -->
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['prd_name']; ?></h5>
                                <p class="card-text">$<?php echo number_format($product['prd_price'], 2); ?></p>
                                <!-- Additional Card Content (like buttons) can go here -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>





                        </main>
    <!-- footer -->
    <?php include('mainweb_page/footer.php'); ?>
    <!-- footer -->

    <!-- end_script -->
    <?php include('mainweb_page/end_script.php'); ?>
    <!-- end_script -->
</body>
</html>
