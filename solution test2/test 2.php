

<?php
function findSingleNumber($arr) {
$numCounts = array();
// Count the occurrences of each number
foreach ($arr as $num) {
if (isset($numCounts[$num])) {
$numCounts[$num]++;
} else {
$numCounts[$num] = 1;
}
}
// Find the number that occurs only once
