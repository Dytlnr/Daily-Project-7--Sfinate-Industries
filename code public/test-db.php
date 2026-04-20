<?php
require_once __DIR__ . '/../src/db.php';

try {
    $pdo = db();
    echo "CONNECTED ✅<br>";
    echo "Server: " . $pdo->query("SELECT VERSION() v")->fetch()['v'];
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
