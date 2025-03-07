<?php
session_start(); // Start the session

require('connect.php'); // Include your database connection file

if (isset($_GET['t_id'])) {
    $t_id = $_GET['t_id'];

    // Query to retrieve the main tourist place information from the 'tourist' table
    $sql = "SELECT * FROM tradition WHERE t_id = $t_id";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $t_name = $row['t_name'];
        $t_detail = $row['t_detail'];

        $t_img = $row['t_img'];
    } else {
        echo "ไม่พบข้อมูลสถานที่ท่องเที่ยว";
        exit;
    }

    // Query to retrieve additional images for the specified tourist place
    $additionalImages = array(); // Initialize an array to store additional images

    $additionalImagesSql = "SELECT * FROM tradition_img WHERE t_id = $t_id";
    $additionalImagesResult = $proj_connect->query($additionalImagesSql);

    if ($additionalImagesResult->num_rows > 0) {
        while ($imageRow = $additionalImagesResult->fetch_assoc()) {
            $additionalImages[] = $imageRow['img'];
        }
    }
} else {
    echo "ระบุ t_id ไม่ถูกต้อง";
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
        <div class="container text-center">
            <div > <img src="startbootstrap-sb-admin-2-gh-pages/pages/tradition/<?php echo $t_img; ?>" alt="Additional Image" class="img-fluid  rounded-lg-3 shadow-lg mt-5"></div>
            <div class="text-center mt-5">
                <h3><?php echo $t_name; ?></h3>
            </div>
            <div>
                <p><?php echo $t_detail; ?></p>
            </div>
        </div>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"><?php echo $t_name; ?> <i class="fa-solid fa-location-dot"></i></h1>

                    <!-- <p class="lead text-muted">Something short and leading about the collection below—its contents, the
                    creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it
                    entirely.</p>
                <p>
                    <a href="#" class="btn btn-primary my-2">Main call to action</a>
                    <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                </p> -->
                </div>
            </div>
        </section>
        <!-- <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light text-start"> <i class="fa-solid fa-location-dot"></i> </h1>
                <h5 class="fw-light text-start"><?php echo $t_addr; ?></h5>
            </div>
        </div>
    </section> -->


        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <img src="startbootstrap-sb-admin-2-gh-pages/pages/tradition/<?php echo $t_img; ?>" alt="<?php echo $t_name; ?>" class="img-fluid  rounded mx-auto d-block img-thumbnail">
                </div>
                <div class="col-md-4">
                    <h1><?php echo $t_name; ?></h1>
                    <p class="lead"><?php echo $t_detail; ?></p>

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
                                <div class="col-md-4">
                                    <img src="startbootstrap-sb-admin-2-gh-pages/pages/tradition/<?php echo $image; ?>" alt="Additional Image" class="img-fluid  rounded-lg-3 shadow-lg">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <!--                   
                            <div class="col-md-12">
                            <p class="h5"> <i class="fa-solid fa-location-dot"></i> ที่อยู่: <?php echo $t_addr; ?> </p>
                            <p class="h5"> <i class="fa-solid fa-calendar-days"></i> เวลา: <?php echo $time; ?> </p>
                            <p class="h5"> <i class="fa-solid fa-phone"></i> ติดต่อ: <?php echo $contact; ?> </p>
                            <p class="h5">  <?php echo $map; ?> </p>
        
             
                            </div> -->

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