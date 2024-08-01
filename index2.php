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
foreach ($numCounts as $num => $count) {
if ($count == 1) {
return $num;
}
}
return null; // Return null if no single number is found
}
// Input sample array
$inputArray = array(5, 3, 4, 3, 4);
$singleNumber = findSingleNumber($inputArray);
echo "The single number in the array is: " . $singleNumber;
?>
<?php
function dayType($day) {
// Convert the input to lowercase to make the function case-insensitive
$day = strtolower($day);
switch ($day) {
case "monday":
case "tuesday":
case "wednesday":
case "thursday":
case "friday":
return ucfirst($day) . " is a weekday.";
case "saturday":
case "sunday":
return ucfirst($day) . " is a weekend.";
default:
return "Invalid day input.";
}
}
// Example usage:
$day1 = "Monday";
$day2 = "Saturday";
$day3 = "Sunday";
$day4 = "Holiday";
echo dayType($day1) . PHP_EOL; // Output: Monday is a weekday.
echo dayType($day2) . PHP_EOL; // Output: Saturday is a weekend.
echo dayType($day3) . PHP_EOL; // Output: Sunday is a weekend.
echo dayType($day4) . PHP_EOL; // Output: Invalid day input.
?>