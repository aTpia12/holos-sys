<?php

namespace App\Http\Controllers;

use App\Mail\ReminderEventsMailable;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EventsReminderController extends Controller
{
    public function __invoke(Request $request)
    {
        $events = Event::with('user')->whereDate('start_date', $request->start_date)->get();

        try{
            foreach ($events as $event) {
                Mail::to($event->user->email)->send(new ReminderEventsMailable($event));
            }

            return response()->json([
                'success' => true,
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
