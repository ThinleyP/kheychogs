<?php
function calculateTriangleArea($base, $height) {
    // Calculate the area
    $area = ($base * $height) / 2;
    return $area;
}
 
// Example usage:
$base = 5;
$height = 10;
$area = calculateTriangleArea($base, $height);
echo "The area of the triangle is: " . $area;
?>
