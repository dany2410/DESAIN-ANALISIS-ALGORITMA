<?php
function computeLPS($pattern) {
    $length = strlen($pattern);
    $lps = array_fill(0, $length, 0);

    $len = 0;
    $i = 1;

    while ($i < $length) {
        if ($pattern[$i] === $pattern[$len]) {
            $len++;
            $lps[$i] = $len;
            $i++;
        } else {
            if ($len != 0) {
                $len = $lps[$len - 1];
            } else {
                $lps[$i] = 0;
                $i++;
            }
        }
    }
    return $lps;
}

function kmpSearch($text, $pattern) {
    if ($pattern === '') {
        return [];
    }

    $textLength = strlen($text);
    $patternLength = strlen($pattern);

    $lps = computeLPS($pattern);
    $positions = [];

    $i = 0; // index text
    $j = 0; // index pattern

    while ($i < $textLength) {
        if (strtolower($text[$i]) === strtolower($pattern[$j])) {
            $i++;
            $j++;
        }

        if ($j == $patternLength) {
            $positions[] = $i - $j;
            $j = $lps[$j - 1];
        } elseif ($i < $textLength && strtolower($text[$i]) !== strtolower($pattern[$j])) {
            if ($j != 0) {
                $j = $lps[$j - 1];
            } else {
                $i++;
            }
        }
    }
    return $positions;
}
