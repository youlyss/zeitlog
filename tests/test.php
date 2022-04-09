<?php
$hours_to_add = 2;

$time = new DateTime();
$stamp = $time->format('Y-m-d H:i:s');
echo $stamp . "\n";
$time->add(new DateInterval('PT' . $hours_to_add . 'H'));

$stamp = $time->format('Y-m-d H:i:s');

echo $stamp;
echo "\n";