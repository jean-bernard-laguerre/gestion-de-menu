<?php
    require __DIR__ . "/../classes/Database.php";

    $pdo = new Database();
    session_start();

    $content = trim(file_get_contents("php://input"));

    $data = json_decode($content, true);
    $response['success'] = true;
    
    $sql = "DELETE FROM " . $data["table"] ." 
            WHERE id = ?";

    $req = $pdo->bdd->prepare($sql);
    $req->execute( [$data["id"]] );

    echo json_encode($response);
?>