<?php
session_start(); // Start the session

require('connect.php'); // Include your database connection file

if (isset($_GET['p_id'])) {
    $p_id = base64_decode($_GET['p_id']);

    // Query to retrieve the main tourist place information from the 'tourist' table
    $sql = "SELECT * FROM tourist WHERE p_id = $p_id";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $p_name = $row['p_name'];
        $p_des = $row['p_des'];
        $p_addr = $row['p_addr'];
        $p_img = $row['p_img'];
        $map = $row['map'];
        $time = $row['time'];
        $contact = $row['contact'];
    } else {
        echo "ไม่พบข้อมูลสถานที่ท่องเที่ยว";
        exit;
    }

    // Query to retrieve additional images for the specified tourist place
    $additionalImages = array(); // Initialize an array to store additional images

    $additionalImagesSql = "SELECT * FROM tourist_img WHERE p_id = $p_id";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head -->
    <?php include('mainweb_page/head.php'); ?>
    <!-- head -->
</head>

<body>
    <header>
        <!-- Navbar -->
        <?php include('mainweb_page/nav_bar.php'); ?>
        <!-- Navbar -->
    </header>

    <main>

        <!-- <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light text-start"> <i class="fa-solid fa-location-dot"></i> <?php echo $p_name; ?></h1>
                <h5 class="fw-light text-start"><?php echo $p_addr; ?></h5>
            </div>
        </div>
    </section> -->


        <div class="container mt-5">
            <div class="row">
                <div class="col-xl-12">
                    <img src="startbootstrap-sb-admin-2-gh-pages/pages/tourist/<?php echo $p_img; ?>" alt="<?php echo $p_name; ?>" class="img-fluid w-100 rounded mx-auto d-block img-thumbnail">
                </div>




                <div class="col-xl-8 mt-5">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1><?php echo $p_name; ?></h1>
                            <p class="lead"><?php echo $p_des; ?></p>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-5">
                    <div class="card shadow">
                        <div class="card-body">
                            <p class="h5"> <i class="fa-solid fa-location-dot"></i> ที่อยู่: <?php echo $p_addr; ?> </p>
                            <p class="h5"> <i class="fa-solid fa-calendar-days"></i> เวลา: <?php echo $time; ?> </p>
                            <p class="h5"> <i class="fa-solid fa-phone"></i> ติดต่อ: <?php echo $contact; ?> </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Display additional tourist images in a grid with 3 columns -->
        <?php if (!empty($additionalImages)) : ?>
            <div class="container mt-5 mb-5 ">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-left">รูปภาพเพิ่มเติม</h3>
                        <div class="row">
                            <?php foreach ($additionalImages as $image) : ?>
                                <div class="col-md-4 mt-3">
                                    <img src="startbootstrap-sb-admin-2-gh-pages/pages/tourist/<?php echo $image; ?>" alt="Additional Image" class="img-fluid  rounded-lg-3 shadow-lg">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <!-- Google Maps iframe with styling -->
                    <div class="ratio ratio-16x9 shadow rounded border">
                        <?php echo $map; ?>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <!-- Login modal -->
    <?php include('mainweb_page/login_modal.php'); ?>
    <!-- footer -->
    <?php include('mainweb_page/footer.php'); ?>
    <!-- footer -->

    <!-- end_script -->
    <?php include('mainweb_page/end_script.php'); ?>
    <!-- end_script -->
</body>

</html>