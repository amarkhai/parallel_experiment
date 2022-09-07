<?php

function printConsole(string $str) {
    print_r($str . PHP_EOL);
}

printConsole('Start program');

$numbers = [];
$i = 0;
$sum = 0;

$runtime1 = new \parallel\Runtime();
$runtime2 = new \parallel\Runtime();
$runtime3 = new \parallel\Runtime();
$runtime4 = new \parallel\Runtime();

printConsole('Fill array');

while ($i < 8000000) {
    $numbers[] = rand(1, 100);
    $i++;
}

printConsole('Counting');

$start = microtime(true);

for ($i = 0; $i < 8000000; $i++) {
    $sum += $numbers[$i];
}

$finish = microtime(true);
$resultTime = $finish - $start;

printConsole('Result sum=' . $sum);
printConsole('Result time=' . $resultTime);

printConsole('Start parallel counting');
$startParallel = microtime(true);

$future1 = $runtime1->run(function(array $numbers){
    $sum = 0;
    for ($i = 0; $i < 2000000; $i++) {
        $sum += $numbers[$i];
    }

    return $sum;
}, [$numbers]);

$future2 = $runtime2->run(function(array $numbers){
    $sum = 0;
    for ($i = 2000000; $i < 4000000; $i++) {
        $sum += $numbers[$i];
    }

    return $sum;
}, [$numbers]);

$future3 = $runtime3->run(function(array $numbers){
    $sum = 0;
    for ($i = 4000000; $i < 6000000; $i++) {
        $sum += $numbers[$i];
    }

    return $sum;
}, [$numbers]);

$future4 = $runtime4->run(function(array $numbers){
    $sum = 0;
    for ($i = 6000000; $i < 8000000; $i++) {
        $sum += $numbers[$i];
    }

    return $sum;
}, [$numbers]);

$sumParallel = $future1->value()
    + $future2->value()
    + $future3->value()
    + $future4->value()
;

$finishParallel = microtime(true);
$resultTimeParallel = $finishParallel - $startParallel;

printConsole('Result time parallel=' . $resultTimeParallel);
printConsole('Result sum parallel=' . $sumParallel);