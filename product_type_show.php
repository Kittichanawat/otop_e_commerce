<?php
require_once('connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT * FROM product_type";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Types</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   
</head>
<body>
<a href="index.php">Home</a>
    <h1>Product Types</h1>
    <table style="width:100%">
        <tr>
            <th>ประเภทผลิตภัณฑ์</th>
            <th>รายละเอียด</th>
            <th>Product type show</th>
            <th colspan="2"><a href="product_type_add.php">เพิ่มข้อมูล</a></th>
        </tr>

        <?php
        $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
        $totalrows_result = mysqli_num_rows($result);

        if ($totalrows_result > 0) {
            while ($row_result = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row_result['pty_name']; ?></td>
                    <td><?php echo $row_result['pty_desc']; ?></td>
                    <td><?php echo $row_result['pty_show']; ?></td>
                    <td><a href="product_type_edit.php?pty_id=<?php echo $row_result['pty_id']; ?>">แก้ไข</a></td>
                    <td><a href="product_type_delete.php?pty_id=<?php echo $row_result['pty_id']; ?>">ลบ</a></td>
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
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>
