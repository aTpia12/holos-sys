<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('events:send-reminders', function () {

    $this->info('Comando ejecutado: email:send-reminders');
})->purpose('Enviar recordatorios de eventos por correo electrónico')->dailyAt('21:47');
