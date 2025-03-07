<?php 
    /**
     * Authentication Service
     * 
     * @link https://appzstory.dev
     * @author Yothin Sapsamran (Jame AppzStory Studio)
     */


    if( !isset($_SESSION['mmb_id'] ) ){
        header('Location: ../../login.php');  
    }
    if ($_SESSION["member"] == 1 && $_SESSION["status"] == "") {
        // ถ้ามีค่า member เป็น 1 และ status เป็นค่าว่าง ให้ทำการเปลี่ยนทางหรือกระทำตามที่คุณต้องการ
        header("Location: ../../../../index.php");
        exit();
    }
    
    // if ($_SESSION["member"] === 1) {
    //     // ถ้ามีค่าเป็น "member" ให้ทำการเปลี่ยนทางหรือกระทำตามที่คุณต้องการ
    //     header("Location: ../dashboard/");
    //     exit();
    // }
?>