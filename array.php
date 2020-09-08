<?php
echo "<pre>";
 
$array = array("R" => 'Ruby', 'PHP', 'JavaScript', 'HTML');
// Check key has associate array
function has_string_keys(array $array) {
    return count(array_filter(array_keys($array), 'is_string')) > 0;
}
echo "<strong>Check key has associate array</strong><br/>";
echo has_string_keys($array) ? "S" : "N";
echo "<br/>";

// Array walk Function
echo "<strong>Array walk Function</strong><br/>";
array_walk($array, function(&$v, $k) {
    $v = $v . ' - Programming Language';
});
print_r($array);

//Array Map with predefined function
echo "<strong>Array Map with predefined function</strong><br/>";
$origarray2 = array_map("strlen", $array);
print_r($origarray2);

//Array Map with user defined function
echo "<strong>Array Map with user defined function</strong><br/>";
$origarray3 = [100, 200, 7, 1];
$origarray4 = array_map(fn($n) => ($n*$n*$n), $origarray3);
print_r($origarray4);
echo "<br/>";

// User defined Sort
echo "<strong>User defined Sort</strong><br/>";
usort($origarray3, function ($x, $y) {
    return $x > $y;
});
print_r($origarray3);
echo "<br/>";

//Array Difference
echo "<strong>Array Difference from given string using predefined function</strong><br/>";
$str1 = "BANGALORE";
$str2  = "BECG";
function processStrings1($str1, $str2) {
    $result = [];
    $array1 = str_split($str1);
    $array2 = str_split($str2);
    $result = array_diff($array1 , $array2);
    return $result;
}
print_r(processStrings1($str1, $str2));

echo "<strong>Array Difference from given string using logic</strong><br/>";
function processStrings2($str1, $str2) {
    $result = [];
    $array1 = str_split($str1);
    $array2 = str_split($str2);
    $merged = array_merge($array1, $array2);
    for ($i = 0; $i < count( $array1); $i++) {
        if (in_array($merged[$i], $array1) != in_array($merged[$i], $array2)) {
            $result[] = $merged[$i];
        }
    }
    return $result;
}
print_r(processStrings2($str1, $str2));

// Function to return GCD 
function gcd( $a, $b) { if ($a==0 ) return $b; return gcd($b % $a, $a); } 

// Function to return LCM 
function lcm( $a, $b) { return ($a * $b) / gcd($a, $b); } 
$a=15;
$b=20;
echo "LCM of " .$a ." and ".$b." is ".lcm($a, $b)."</br>";

// Swapping of two number with two variable
echo "After swapping:</br>"; 
$a=$a + $b; 
$b=$a - $b; 
$a=$a - $b; 
echo "a = $a</br>"; 
echo "b = $b</br>"; 

// First and Last Occurence
$array3 = ["iron", "helium", "potassium", "ascorbic", "helium", "zinc", "sodium"];
echo "First Index : " .array_search("helium", $array3, true). "</br>";
function lastIndexOf($needle, $arr) {
    return array_search($needle, array_reverse($arr, true), true);
}
echo "Last Index : " .lastIndexOf("helium", $array3). "</br>";

//Reverse the Number
$num=4; 
$revnum=0 ; 
while ($num> 1) { $rem = $num % 10; $revnum = ($revnum * 10) + $rem; $num = ($num / 10); } 
echo "Reverse number is: $revnum". "</br>"; 

//Check for prime number
function isPrime($n) { 
    for($x=2; $x < ($n-1); $x++) { 
        //echo "Mod :".($n%$x);
        if($n%$x == 0) { return "$n is Prime Number..</br>"; } 
    } 
    return "$n is not a Prime Number..</br>"; 
} 
echo isPrime(12);

$array4 = array("mary,joe","joe,marry", "a,b", "z,b,c,a", "b,a");
// $array4 = array( array("mary","joe"),  array("joe","marry"),  array("a","b"), array("z","b","c","a"),  array("b","c"));
function sorter_by_value($a, $b) {
    return strcmp($a[0], $b[0]);
}
function sorter_by_key($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
}
function array_unique_key($array) {
    $result = array();
    foreach (array_unique(array_keys($array)) as $tvalue) {
        $result[$tvalue] = $array[$tvalue];
    }
    return $result;
}
function compareFriends($frndsList) : array {
    $newarrays = [];
    for($i=0; $i<count($frndsList); $i++) {
        $new_array = @explode(",", $frndsList[$i]);
        usort($new_array, "sorter_by_value");
        $newarrays[] = $new_array;
    }
    return array_unique_key($newarrays); 
}
$array5 = compareFriends($array4);
print_r($array5);

echo "<strong>Array Unique Function</strong><br/>";
$array6 = array("12", 'abc', '12', 'mp', 33, 'mp');
$array6 = array_diff_assoc($array6, array_unique($array6));
print_r($array6);

echo "<strong>Array Count Values Function</strong><br/>";
$oldArray = array("B","Cat","Dog","B","Dog","Dog","Cat");
print_r(array_count_values($oldArray)); 

echo "<strong>Array Splice Function</strong><br/>";
$newArray = array( 'Elephant' );
array_splice( $oldArray, 3, 0, $newArray);
print_r($oldArray);