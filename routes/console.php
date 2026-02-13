<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('tarik', function () {
    $this->comment("rajool");
})->purpose('Display an inspiring quote');

Schedule::command('welcome',function(){
    
})->everySecond();
