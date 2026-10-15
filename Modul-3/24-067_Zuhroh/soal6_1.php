<?php
// 1. array_push[cite: 4]
$arr1 = array("A");
echo 'Array awal: ("A")<br>';
array_push($arr1, "B");
echo 'Hasil array_push: ' . implode(" ", $arr1) . '<br><br>';

// 2. array_merge[cite: 4]
$arr_a = array("A", "B");
$arr_b = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$merged = array_merge($arr_a, $arr_b);
echo 'Hasil array_merge: ' . implode(" ", $merged) . '<br><br>';

// 3. array_values[cite: 4]
$assoc = array("x" => 1, "y" => 2);
echo 'Array awal: ("x"=>1, "y"=>2)<br>';
$vals = array_values($assoc);
echo 'Hasil array_values: ' . implode(" ", $vals) . '<br><br>';

// 4. array_search[cite: 4]
$search_arr = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
$found_key = array_search("B", $search_arr);
echo 'Hasil array_search: ' . $found_key . '<br><br>';

// 5. array_filter[cite: 4]
$filter_arr = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$filtered = array_filter($filter_arr);
echo 'Hasil array_filter: ' . implode(" ", $filtered) . '<br><br>';

// 6. Sorting Indexed Array (sort & rsort)[cite: 4]
$numbers = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';

$s_num = $numbers;
sort($s_num);
echo 'Hasil sort: ' . implode(" ", $s_num) . '<br>';

$r_num = $numbers;
rsort($r_num);
echo 'Hasil rsort: ' . implode(" ", $r_num) . '<br><br>';

// 7. Sorting Associative Array (asort, ksort, arsort, krsort)[cite: 4]
$age = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

// Helper format assoc[cite: 4]
function printAssocPairs($arr) {
    $out = array();
    foreach ($arr as $k => $v) {
        $out[] = "$k=>$v";
    }
    return implode(", ", $out);
}

// asort[cite: 4]
$a = $age; asort($a);
echo 'Hasil asort: ' . printAssocPairs($a) . '<br>';

// ksort[cite: 4]
$b = $age; ksort($b);
echo 'Hasil ksort: ' . printAssocPairs($b) . '<br>';

// arsort[cite: 4]
$c = $age; arsort($c);
echo 'Hasil arsort: ' . printAssocPairs($c) . '<br>';

// krsort[cite: 4]
$d = $age; krsort($d);
echo 'Hasil krsort: ' . printAssocPairs($d) . '<br>';
?>