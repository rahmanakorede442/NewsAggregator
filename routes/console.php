<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');


Artisan::command('automate', function(){

})->purpose('Fetch from news services to automate update')->everyTenMinutes();
