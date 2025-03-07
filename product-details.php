<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    


<?php
// รับ ID ของสินค้าจาก URL
$prd_id = $_GET["prd_id"];

// เชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "otop");

// เรียกข้อมูลสินค้า
$sql = "SELECT * FROM product WHERE prd_id = $prd_id";
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีสินค้าหรือไม่
if ($result && mysqli_num_rows($result) > 0) {
  // แสดงรายละเอียดสินค้า
  $row = mysqli_fetch_assoc($result);
  ?>

  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $row["prd_name"]; ?></h5>
      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <img src="<?php echo $row["prd_img"]; ?>" class="img-fluid" alt="<?php echo $row["prd_name"]; ?>">
      <h3 class="text-center"><?php echo $row["prd_price"]; ?> THB</h3>
      <p class="text-center"><?php echo $row["prd_desc"]; ?></p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    </div>
  </div>

<?php
} else {
  // สินค้าไม่พบ
  echo "<p>สินค้าไม่พบ</p>";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>