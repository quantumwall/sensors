#!/usr/bin/env php
<?php

function  current_time() {
    return `date | cut -f5 -d ' '`;
}

function current_temp() {
    return `sensors | grep Package | cut -f5 -d ' ' | grep -Eo '[0-9]{1,}' | head -n1 | tr -d '\n'`;
}

function colored($text, $color) {
    switch ($color) {
        case "red":
            $colored_text = "\033[00;31m$text\033[00m";
            break;
        case "green":
            $colored_text = "\033[00;32m$text\033[00m";
            break;
        case "orange":
            $colored_text = "\033[01;38;5;208m$text\033[00m";
            break;
        default:
            $colored_text = "\033[00;37m$text\033[00m";
    }    
    return $colored_text;
}

function color_of_temp($temp) {
    if ($temp > 0 && $temp <= 50) {
        return "green";
    }
    elseif ($temp > 50 && $temp <= 68) {
        return "orange";
    }
    else {
        return "red";
    }
}

$start_time = current_time();
$hours = $minutes = $seconds = 0;
$min_temp_time = $current_time = $max_temp_time = current_time();
#$min_temp = $current_temp = $max_temp = rand(46, 77);
$min_temp = $current_temp = $max_temp = current_temp();
while (true) {
    if ($current_temp < $min_temp) {
        $min_temp = $current_temp;
        $min_temp_time = $current_time;
    }
    elseif ($current_temp >= $max_temp) {
        $max_temp = $current_temp;
        $max_temp_time = $current_time;
    }

    echo `clear`;
    echo "Start time -\t\t$start_time";
    echo "Current time -\t\t$current_time";
    $seconds++;
    if ($seconds > 59) {
        $seconds = 0;
        $minutes++;
        if ($minutes > 59) {
            $minutes = 0;
            $hours++; 
        }
    } 

    echo "Elapsed time -\t\t".str_pad($hours % 24, 2, "0", STR_PAD_LEFT), ":",
        str_pad($minutes % 60, 2, "0", STR_PAD_LEFT), ":",
        str_pad($seconds % 60, 2, "0", STR_PAD_LEFT)."\n";
    echo "\n";
    echo "Current temperature -\t".colored($current_temp, color_of_temp($current_temp))."\n";
    echo "Maximum temperature -\t".colored($max_temp, color_of_temp($max_temp))." at $max_temp_time";
    echo "Minimum temperature -\t".colored($min_temp, color_of_temp($min_temp))." at $min_temp_time";
    $current_temp = current_temp();
    $current_time = current_time();
    sleep(1);
} 
