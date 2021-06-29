<?php

/*
 * generate all prime number SSNs that consist of only prime numbers
 * Author: Robert Sargsyan
 * runtime ~48 second
 * */

// Check if the give number is prime
function isPrime($number){
    if ($number == 1)
        return false;
    for ($i = 2; $i <= floor(sqrt($number)); $i++){
        if ($number % $i == 0)
            return false;
    }
    return true;
}

$prime2Digit = [];
$prime3Digit = [];
$prime4Digit = [];

// Function to find next prime number after given n number
// I am not creating this function from scratch as php language has such function, otherwise look isPrime() function
function nextPrime($n) {
    return gmp_nextprime($n);
}

// find 2 digit prime numbers
for ($i = 2; ; ) {
    $primeNumber = gmp_nextprime($i);
    if ($primeNumber > 10)
        break;
    $i = $primeNumber;
    $prime2Digit[] = str_pad($primeNumber, 2, '0', STR_PAD_LEFT);
}

// find 3 digit prime numbers
for ($i = 10; ; ) {
    $primeNumber = gmp_nextprime($i);
    if ($primeNumber > 999)
        break;
    $i = $primeNumber;
    $prime3Digit[] = str_pad($primeNumber, 3, '0', STR_PAD_LEFT);
}

// Merge 2 digit primes into 3 digit prime array to avoid double search
$i = count($prime2Digit);
while($i) {
    $prime3 = str_pad($prime2Digit[--$i], 3, '0', STR_PAD_LEFT);
    array_unshift($prime3Digit, $prime3);
}


// find 4 digit prime numbers
for ($i = 1000; ; ) {
    $primeNumber = gmp_nextprime($i);
    if ($primeNumber > 9999)
        break;
    $i = $primeNumber;
    $prime4Digit[] = str_pad($primeNumber, 4, '0', STR_PAD_LEFT);
}

// Merge 3 digit primes into 4 digit prime array to avoid double search
$i = count($prime3Digit);
while($i) {
    $prime4 = str_pad($prime3Digit[--$i], 4, '0', STR_PAD_LEFT);
    array_unshift($prime4Digit, $prime4);
}


//generate SSN numbers and validate if they are prime
$primeSSN =[];
foreach ($prime3Digit as $p3) {
    foreach ($prime2Digit as $p2) {
        foreach ($prime4Digit as $p4) {
            if ( isPrime((int)($p3.$p2.$p4)) ) {
                $primeSSN[] = $p3 . '-' . $p2 . '-' . $p4;
            }
        }
    }
}

// output SSN array
print_r($primeSSN);