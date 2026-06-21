<?php

include "../koneksi.php";
include "../config.php";

session_start();
session_destroy();
header("Location: " . BASE_URL . "/auth/login.php");
exit;
