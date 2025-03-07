<?php
require_once('connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT * FROM tourist";
$result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result = mysqli_num_rows($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Types</title>
    <style>
         /* กำหนดความกว้างของคอลัมน์ที่มีข้อความรายละเอียด */
    th:nth-child(3),
    td:nth-child(3) {
        max-width: 150px; /* ปรับขนาดของคอลัมน์รายละเอียด */
        white-space: nowrap; /* อักขระที่ยาวเกินจะไม่ขึ้นบรรทัดใหม่ */
        overflow: hidden; /* ซ่อนข้อความที่เกินขอบเขตของคอลัมน์ */
        text-overflow: ellipsis; /* แสดงเครื่องหมาย ... ถ้าข้อความยาวเกิน */
    }
    </style>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   
</head>
<body>
<a href="index.php">Home</a>
    <h1 class=" text-center ">หน้าจัดการสินค้า</h1>
    <table class="table table-bordered  border-dark">
    <thead>
        <tr>
            <th>ชื่อสถานที่</th>
            <th>รายละเอียด</th>
            <th>ที่อยู่</th>
            <th>รูป</th>


            <th colspan="2"><a href="tourist_add.php">เพิ่มข้อมูล</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($totalrows_result > 0) {
            while ($row_result = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row_result['p_name']; ?></td>
                   
                    <!-- ใช้ Bootstrap 5 class "text-truncate" เพื่อแสดงข้อความที่ยาวเกิน -->
                    <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $row_result['p_des']; ?></td>

             
                    <td><img src="<?php echo $row_result['p_img']; ?>" alt="" style="max-width: 100px; max-height: 100px;"></td>
                    <td><?php echo $row_result['p_addr']; ?></td>
                 
                    <td><a href="tourist_edit.php?p_id=<?php echo $row_result['p_id']; ?>">แก้ไข</a></td>
                    <td><a href="tourist_delete.php?p_id=<?php echo $row_result['p_id']; ?>">ลบ</a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="4">ไม่มีข้อมูลในระบบ</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>
