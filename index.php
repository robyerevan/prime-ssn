<?php

/*
 * generate all prime number SSNs that consist of only prime numbers
 * usserviceanimals.org coding challenge
 * Author: Robert Sargsyan
 * */


/**
 * Check if the give number is prime
 * @param $number
 * @return bool
 */
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


/**
 *
 * Function to find next prime number after given n number.
 * I am not creating this function from scratch as php language has such function,
 * otherwise look isPrime() function
 *
 * @param $n
 * @return resource
 */
function nextPrime($n) {
    return gmp_nextprime($n);
}


/**
 * Generate prime numbers for a given range
 * @param $start
 * @param $end
 * @return array
 */
function generatePrimes($start, $end) {
    $primeNumbers = [];
    $length = strlen($end);
for ($i = $start; ; ) {
    $primeNumber = gmp_nextprime($i);
    if ($primeNumber > $end)
        break;
    $i = $primeNumber;
    $primeNumbers[] = str_pad($primeNumber, $length, '0', STR_PAD_LEFT);
}
return $primeNumbers;
}


// find 2 digit prime numbers
$prime2Digit = generatePrimes(1, 10);

// find 3 digit prime numbers
$prime3Digit = generatePrimes(10, 999);

// Merge 2 digit primes into 3 digit prime array to avoid double search
$i = count($prime2Digit);
while($i) {
    $prime3 = str_pad($prime2Digit[--$i], 3, '0', STR_PAD_LEFT);
    array_unshift($prime3Digit, $prime3);
}


// find 4 digit prime numbers
$prime4Digit = generatePrimes(1000, 9999);

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
foreach ($primeSSN as $ssn ) {
    echo $ssn . PHP_EOL;
}