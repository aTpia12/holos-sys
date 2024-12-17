<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios de eventos a los usuarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "Memoria inicial: " . memory_get_usage() . " bytes\n";

        $tomorrow = now()->addDay()->startOfDay();
        $events = Event::whereDate('start_date', $tomorrow)->with('user')->get();

        echo "Memoria después de cargar eventos: " . memory_get_usage() . " bytes\n";

        foreach ($events as $event) {
            if ($event->user) {
                // Enviar notificación
                $event->user->notify(new EventReminder($event));
            }
        }

        echo "Memoria después de enviar notificaciones: " . memory_get_usage() . " bytes\n";

        $this->info('Recordatorios enviados.');
    }
}
