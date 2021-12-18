<?php

function randomString(){

    $randomString = rand(0000000, 9999999).'_'.date('Ymd_His/');

    return $randomString;
}