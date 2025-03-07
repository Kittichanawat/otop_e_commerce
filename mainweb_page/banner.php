<!-- Banner Carousel -->

<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
    <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
        <!-- PHP: Retrieve data from the 'banner' table and populate carousel items -->
        <?php
        // Your database proj_connectection code here

        // SQL query to fetch banner data
        $sql = "SELECT * FROM banner WHERE pages_show = 1 ORDER BY order_column";
        $result = $proj_connect->query($sql);
        

        // Check if there is any data
        if ($result->num_rows > 0) {
            $first = true; // Variable to track the first item
            while ($row = $result->fetch_assoc()) {
                // Determine if it's the first item to be set as active
                $activeClass = $first ? 'active' : '';
        ?>
        <div class="carousel-item <?php echo $activeClass; ?>">
         <a href="#"> <img src="startbootstrap-sb-admin-2-gh-pages/pages/banner/<?php echo $row['img']; ?>" class="d-block w-100" alt="<?php echo $row['title']; ?>"></a>  
        </div>
        <?php
                $first = false; // Set to false after the first item
            }
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<!-- Custom JavaScript -->
<script>
    // Add JavaScript for Carousel autoplay with a 3-second interval
    $(document).ready(function () {
        // Set the interval for carousel autoplay (in milliseconds)
        $('#bannerCarousel').carousel({
            interval: 3000 // Change this value as needed
        });
    });
</script>
