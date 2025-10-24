<?php
$conn = new mysqli("localhost", "root", "", "collecticart");

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id=$id");
header("Location: home.php");
exit;
?>