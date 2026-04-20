<?php
function db(): PDO {
  $host = '127.0.0.1';
  $dbname = 'u961930165_konveksi';
  $user = 'root';
  $pass = 'Root123!'; // password root yang kamu set
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
  return new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
}
