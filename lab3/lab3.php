<?php
$equation = "27 - X = 17";

$parts = explode("=", $equation);
$left = trim($parts[0]);
$right = trim($parts[1]);

if (strpos($left, 'X') !== false) {

    if (strpos($left, '+') !== false) {
        $nums = explode('+', $left);

        if (trim($nums[0]) == 'X') {
            $x = $right - trim($nums[1]);
        } else {
            $x = $right - trim($nums[0]);
        }
    }

    elseif (strpos($left, '-') !== false) {
        $nums = explode('-', $left);

        if (trim($nums[0]) == 'X') {
            $x = $right + trim($nums[1]);
        } else {
            $x = trim($nums[0]) - $right;
        }
    }

    echo "X = " . $x;
}
?>