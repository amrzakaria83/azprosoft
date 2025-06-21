<?php
try {
    $conn = new PDO(
        "sqlsrv:Server=DESKTOP-PMNDNNT;Database=Emanger", 
        "sa",
        "1"
    );
    echo "Connected successfully with sa account!";
} catch (PDOException $e) {
    echo "SA connection failed: " . $e->getMessage();
}