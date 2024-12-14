<?php

namespace App\Livewire\Sections;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

class Calendar extends Component
{
    public $events = [];
    public $availableTimes = []; // Horarios disponibles

    public function mount()
    {
        $this->loadEvents();
        $this->generateAvailableTimes();
    }

    public function loadEvents()
    {
        $this->events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date, // Aquí usas el mutador
                'end' => $event->end_date,     // Aquí usas el mutador
            ];
        });
    }
    
    #[On('updateEvent')]
    public function updateEvent($eventId, $start, $end)
    {

        // Buscar el evento por ID
        $event = Event::find($eventId);

            // Actualizar los campos del evento
            $event->start_date = Carbon::parse($start);
            $event->end_date = Carbon::parse($end);
            $event->save();
    
    }

    public function generateAvailableTimes()
    {
        // Generar horarios disponibles (ejemplo: cada hora de 9 a 17)
        $start = Carbon::createFromTime(9, 0);
        $end = Carbon::createFromTime(17, 0);
        while ($start->lessThanOrEqualTo($end)) {
            $this->availableTimes[] = $start->format('H:i');
            $start->addHour();
        }
    }

    public function addEvent($title, $startTime)
    {
        // Validar que no haya conflictos con otros eventos
        foreach ($this->events as $event) {
            if ($event['start'] < $startTime && $event['end'] > $startTime) {
                session()->flash('error', 'El horario está ocupado.');
                return;
            }
        }

        // Agregar nuevo evento
        $this->events[] = [
            'title' => $title,
            'start' => $startTime,
            'end' => Carbon::parse($startTime)->addHour()->format('Y-m-d\TH:i:s'),
        ];

        session()->flash('message', 'Evento agregado exitosamente.');
    }
    public function render()
    {
        return view('livewire.sections.calendar');
    }
}
