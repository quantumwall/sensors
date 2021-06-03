#!/usr/bin/env php
<?php
function  current_time() {
    return `date | cut -f5 -d ' '`;
}
$start_time = current_time();
$hours = $minutes = $seconds = 0;
$max_temp_time = 0;
$min_temp_time = 0;
$max_temp = 0;
$min_temp = 0;
while (true) {
    $current_time = current_time();
    echo `clear`;
    echo "Start time - $start_time";
    echo "Current time - $current_time";
    $seconds++;
    if ($seconds > 59) {
        $seconds = 0;
        $minutes++;
        if ($minutes > 59) {
            $minutes = 0;
            $hours++; 
        }
    } 
    echo str_pad($hours % 24, 2, "0", STR_PAD_LEFT), ":",
        str_pad($minutes % 60, 2, "0", STR_PAD_LEFT), ":",
        str_pad($seconds % 60, 2, "0", STR_PAD_LEFT);
    sleep(1);
} 
