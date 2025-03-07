<?php
/**
 **** AppzStory Back Office Management System Template ****
 * Index Get ALL Members
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

try {
    $db = new Database();
    $conn = $db->connect();
    
    $sql = 'SELECT * FROM member WHERE member = 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $response = [
        'status' => true,
        'response' => $members,
        'message' => 'Get Data Members Success'
    ];
    
    http_response_code(200);
    echo json_encode($response);
} catch (PDOException $exception) {
    $response = [
        'status' => false,
        'message' => 'Failed to fetch data: ' . $exception->getMessage()
    ];
    
    http_response_code(500);
    echo json_encode($response);
}