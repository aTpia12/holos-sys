<?php

namespace App\Livewire\Sections;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use App\Models\Sale as SaleModel;
use App\Models\User as UserModel;
use App\Mail\TicketMailable;
use Illuminate\Support\Facades\Mail;
use App\Models\EventSale;

class Events extends Component
{
    public $dateNow;

    public $selectedIndex = null;

    public $selectedDate = null;
    public $selectedTime = null;
    public $nextBusinessDayFormatted;
    public $availableTimes = [];

    public $showModal3 = false;

    public $userId;

    public $masajeValoracionCount = 0;
    public $manicurePedicureCount = 0;
    public $reikiCount = 0;
    public $selectedService = null;

    public $getPay = false;
    public $servicePay = '';
    public $amountPay;
    public $tipePay;
    public $serviceId;
    public $objectEvent;

    public function eventIdDelete(Event $eventId)
    {
        $this->objectEvent = $eventId;
        $this->dispatch('deleteEvent');
    }
    #[On('eventDeleteFunction')]
    public function deleteEvent()
    {
        $this->objectEvent->delete();
    }

    public function processPay()
    {

        $saleCart = SaleModel::create([
            'user_id' => $this->userId->id,
            'total' => $this->amountPay,
            'subtotal' => $this->amountPay,
            'iva' => '0.00',
            'type' => $this->tipePay !== null ? $this->tipePay : 'efectivo',
            'cart' => json_encode([
                ['id' => 701,
                'name' => $this->servicePay,
                'image' => '',
                'price' => $this->amountPay,
                'quantity' => 1]
                ]),
        ]);

        EventSale::create([
            'event_id' => $this->serviceId,
            'sale_id' => $saleCart->id,
        ]);

        $ticketData = [
            'user' => UserModel::find($this->userId->id), // Asegúrate de usar el ID correcto
            'products' => json_decode($saleCart->cart), // Decodificamos el JSON del carrito guardado
            'subtotal' => $saleCart->subtotal, // Usamos el subtotal guardado en la venta
            'iva' => $saleCart->iva, // Usamos el IVA guardado en la venta
            'total' => $saleCart->total, // Usamos el total guardado en la venta
            'date' => now(), // Fecha actual
            'email' => UserModel::find($this->userId->id)->email, // Obtenemos el email del usuario
            'name' => UserModel::find($this->userId->id)->name, // Obtenemos el nombre del usuario
        ];

        $sendEmail = Mail::to(UserModel::find($this->userId->id)->email)->send(new TicketMailable($ticketData));

        $this->getPay = false;

        return redirect()->route('ticket', $saleCart);
    }

    public function cancelPay()
    {
        $this->getPay = false;
    }

    public function getPayService($servicePay, $serviceId)
    {
        $this->servicePay = $servicePay;
        $this->serviceId = $serviceId;
        $this->getPay = true;
    }

    public function modalLoader()
    {
        $this->showModal3 = true;
    }

    public function selectService($service)
    {
        if (empty($this->selectedDate) || empty($this->selectedTime)) {
            $this->dispatch('errorDateTimeCard');
            return;
        }
        $this->selectedService = $service;
    }

    public function createSessionReiki()
    {
        if (empty($this->selectedDate) || empty($this->selectedTime)) {
            $this->dispatch('errorDateTimeCard');
            return;
        }

        $dateBD = \DateTime::createFromFormat('d/m/Y', $this->selectedDate);
        $convertDate = $dateBD->format('Y-m-d');
        $timeBD = $this->selectedTime;
        $timeToAdd = Carbon::parse($timeBD)->addHours(1)->toTimeString();

        $counts = $this->canSchedule($convertDate, $timeBD, $timeToAdd, 'reiki', 1);

        if ($counts['reiki'] >= 1) {

            $this->dispatch('maxEvents');
            return;
        }else
        {
            $this->modalLoader();
            Event::create([
                'user_id' => $this->userId->id,
                'title' => 'Reiki '.$this->userId->name,
                'description' => 'Reiki',
                'start_date' => $convertDate. ' ' . $timeBD,
                'end_date' => $convertDate. ' ' . $timeToAdd,
            ]);

            $this->dispatch('emptyTimeEvents');
        }
    }

    public function createSession($sercvice)
    {
        $dateBD = \DateTime::createFromFormat('d/m/Y', $this->selectedDate);
        $convertDate = $dateBD->format('Y-m-d');
        $timeBD = $this->selectedTime;
        $timeToAdd = Carbon::parse($timeBD)->addHours(1)->toTimeString();

        $counts = $this->canSchedule($convertDate, $timeBD, $timeToAdd, $sercvice, 2);

        if ($counts['manicure_pedicure'] >= 2) {

            $this->dispatch('maxEvents');
            return;
        }else
        {
            $this->modalLoader();

            Event::create([
                'user_id' => $this->userId->id,
                'title' => $sercvice.' '.$this->userId->name,
                'description' => $sercvice,
                'start_date' => $convertDate. ' ' . $timeBD,
                'end_date' => $convertDate. ' ' . $timeToAdd,
            ]);
            $this->selectedService = null;
            $this->dispatch('emptyTimeEvents');
        }
    }

    public function cancelEvent($index, $flag)
    {
        $events = Event::paginate(10);
        $event = $events[$index];

        if ($this->selectedIndex === $index) {
            $event->cancelled = !$event->cancelled;
            $this->selectedIndex = null;
        } else {
            if ($this->selectedIndex !== null) {
                $previousEvent = $events[$this->selectedIndex];
                $previousEvent->cancelled = false;
            }
            $event->cancelled = true;
            $this->selectedIndex = $index;
        }

        if($flag === 1)
        {
            if($this->selectedDate === null || $this->selectedTime === null)
            {
                $this->dispatch('errorDateTime');
            }else{
                $event->start_date = Carbon::parse($this->selectedDate)->format('Y-m-d')." ".$this->selectedTime;
                $time = Carbon::createFromFormat('H:i:s', $this->selectedTime);
                $time->addHours(1)->addMinutes(30);
                $event->end_date = $time;

                $this->dispatch('updateEvent');
            }

        }

        $event->save();
    }

    #[On('updateSelectedDate')]
    public function updateSelectedDate($date)
    {
        $this->selectedDate = $date;
        $timeBD = $this->selectedTime;
        $timeToAdd = Carbon::parse($timeBD)->addHours(1)->toTimeString();

        $counts = $this->canSchedule($this->selectedDate, $this->selectedTime, $timeToAdd, 'valoracion', 3);


        $this->masajeValoracionCount = $counts['masaje_valoracion'];
        $this->manicurePedicureCount = $counts['manicure_pedicure'];
        $this->reikiCount = $counts['reiki'];

        $this->getAvailableTimes($date);
    }

    public function updateSelectedTime($time)
    {
        $dateBD = $this->selectedDate;
        $timeBD = $time;
        $timeToAdd = Carbon::parse($timeBD)->addHours(1)->toTimeString();

        $counts = $this->canSchedule($dateBD, $time, $timeToAdd, 'valoracion', 3);

        $this->masajeValoracionCount = $counts['masaje_valoracion'];
        $this->manicurePedicureCount = $counts['manicure_pedicure'];
        $this->reikiCount = $counts['reiki'];

        $this->selectedTime = $time;
    }

    public function getAvailableTimes($date)
    {

        $allTimes = [
            '08:00:00', '09:00:00', '10:00:00',
            '11:00:00', '12:00:00', '13:00:00','14:00:00','15:00:00', '16:00:00','17:00:00', '18:00:00', '19:00:00'
        ];

        $this->availableTimes = array_values($allTimes);
    }

    public function createTenSessions()
    {
        if($this->selectedDate === null || $this->selectedTime === null)
        {
            $this->dispatch('errorDateTime');
        }else{
            $dateBD = \DateTime::createFromFormat('d/m/Y', $this->selectedDate);
            $convertDate = $dateBD->format('Y-m-d');
            $timeBD = $this->selectedTime;
            $timeToAdd = Carbon::parse($timeBD)->addHours(1)->toTimeString();
            $this->modalLoader();

            for ($i = 0; $i < 10; $i++)
            {
                // Convertir $dateBD nuevamente a Carbon para manipularlo
                $startDate = Carbon::createFromFormat('Y-m-d', $convertDate);
                $endDate = Carbon::createFromFormat('Y-m-d', $convertDate);

                $counts = $this->canSchedule($convertDate, $timeBD, $timeToAdd, 'valoracion', 3);

                if ($counts['masaje_valoracion'] >= 3) {

                    $this->dispatch('maxEvents');
                    return;
                }else{



                    Event::create([
                        'user_id' => $this->userId->id,
                        'title' => 'S' . ($i + 1) . ' ' . $this->userId->name,
                        'description' => 'Sesiones Masaje',
                        'start_date' => $i === 0 ? $convertDate.' '.$timeBD : $startDate->copy()->addWeeks($i)->toDateString() . ' ' . $timeBD,
                        'end_date' => $i === 0 ? $convertDate.' '.$timeToAdd : $endDate->copy()->addWeeks($i)->toDateString() . ' ' . $timeToAdd,
                    ]);
                }


            }
            $this->dispatch('emptyTimeEvents');
        }

    }

    public function createValSession()
    {
        if($this->selectedDate === null || $this->selectedTime === null)
        {
            $this->dispatch('errorDateTime');
        }else{
            $dateBD = \DateTime::createFromFormat('d/m/Y', $this->selectedDate);
            $convertDate = $dateBD->format('Y-m-d');
            $timeBD = $this->selectedTime;
            $timeToAdd = Carbon::parse($timeBD)->addHours(1)->toTimeString();

            $counts = $this->canSchedule($convertDate, $timeBD, $timeToAdd, 'valoracion', 3);

            if ($counts['masaje_valoracion'] >= 3) {

                $this->dispatch('maxEvents');
                return;
            }else
            {
                $this->modalLoader();

                Event::create([
                    'user_id' => $this->userId->id,
                    'title' => 'Valoración '.$this->userId->name,
                    'description' => 'Valoración',
                    'start_date' => $convertDate. ' ' . $timeBD,
                    'end_date' => $convertDate. ' ' . $timeToAdd,
                ]);

                $this->dispatch('emptyTimeEvents');
            }
        }

    }

    private function canSchedule($date, $time, $timeToAdd, $type, $maxCount)
    {
        $startDateTime = "$date $time"; // "2024-12-09 08:00:00"
        $endDateTime = "$date $timeToAdd"; // "2024-12-09 09:00:00"

        // Consultar eventos existentes
        $existingEvents = Event::where(function ($query) use ($startDateTime, $endDateTime) {
            $query->where('start_date', '<', $endDateTime)
                ->where('end_date', '>', $startDateTime);
        })->get();

        // Contadores para las diferentes categorías
        $masajeValoracionCount = 0;
        $manicurePedicureCount = 0;
        $reikiCount = 0;

        foreach ($existingEvents as $event) {

            // Verificar las descripciones de los eventos
            if (strpos($event->description, 'Sesiones Masaje') !== false || strpos($event->description, 'Valoración') !== false) {
                $masajeValoracionCount++;
            }
            if (strpos($event->description, 'Manicure') !== false || strpos($event->description, 'Pedicure') !== false) {
                $manicurePedicureCount++;
            }
            if (strpos($event->description, 'Reiki') !== false) {
                $reikiCount++;
            }
        }

        return [
            'masaje_valoracion' => $masajeValoracionCount,
            'manicure_pedicure' => $manicurePedicureCount,
            'reiki' => $reikiCount,
        ];
    }



    public function mount(User $userId)
    {
        $this->dateNow = Carbon::now()->format('d/m/Y');

        $currentDate = Carbon::createFromFormat('d/m/Y', $this->dateNow);

        $nextBusinessDay = $currentDate;

        if ($nextBusinessDay->isWeekend()) {
            if ($nextBusinessDay->isSunday()) {
                // Si es domingo, añade 1 día (pasa al lunes)
                $nextBusinessDay->addDays(1);
            }
            // Si es sábado, no se hace nada y se permite seleccionar el sábado
        }

        $this->nextBusinessDayFormatted = $nextBusinessDay->format('d/m/Y');
        $this->selectedService = null;

        $this->userId = $userId;
        // Aquí puedes realizar la consulta de eventos usando $this->userId
        $events = Event::where('user_id', $this->userId->id)->get();
        return view('livewire.sections.events', ['events' => $events]);
    }

    public function render()
    {
        $events = Event::where('user_id', $this->userId)->get();
        return view('livewire.sections.events', ['events' => $events]);
    }
}
