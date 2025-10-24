<?php
require __DIR__ . "/session-config.php";

if (isset($_SESSION['user_id'])) {
    echo "LOGGED_IN";
} else {
    echo "NOT_LOGGED_IN";
}
