<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbdname = 'webebook';

$koneksi = mysqli_connect($host, $username, $password, $dbdname) or die(mysqli_error($koneksi));