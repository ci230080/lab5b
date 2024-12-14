<?php
// Memulakan sesi
session_start();

// Hapuskan sesi yang ada
session_unset();
session_destroy();

// Arahkan semula ke halaman login selepas log keluar
header("Location: login.php");
exit();
?>
