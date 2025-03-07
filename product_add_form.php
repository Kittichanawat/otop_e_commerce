<!DOCTYPE html>
<html>
<head>
    <title>อัพโหลดรูปภาพสินค้า</title>
</head>
<body>
    <h2>อัพโหลดรูปภาพสินค้า</h2>
    <form action="product_add.php" method="post" enctype="multipart/form-data">
        <label for="image">เลือกรูปภาพ:</label>
        <input type="file" name="image" id="image" accept="image/*" required>
        <br><br>
        <input type="submit" value="อัพโหลด">
    </form>
</body>
</html>
