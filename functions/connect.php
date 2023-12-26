<?php

try {
    $conn = mysqli_connect('localhost', 'root', '', 'small_project');
} catch (Exception $e) {
    echo $e->getMessage();
}
