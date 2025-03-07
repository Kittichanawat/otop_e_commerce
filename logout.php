<?php
session_start(); // เริ่มต้น Session

// ลบ Session ทั้งหมด
session_destroy();

// Redirect ไปยังหน้าเข้าสู่ระบบหรือหน้าอื่น ๆ ตามที่คุณต้องการ
header('Location: index.php'); // แก้เส้นทาง URL ตามที่คุณต้องการ
exit(); // จบการทำงานของหน้า Logout
?>
