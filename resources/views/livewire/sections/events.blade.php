<div class="p-4 sm:ml-64 mt-14">
    <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-gray-900 container mx-auto p-4">

                        <h2 class="mb-2 text-lg font-semibold text-gray-900">Instrucciones</h2>
                        <ol class="w-full space-y-1 text-gray-500 list-decimal list-inside">
                            <li>
                                <span class="font-semibold text-gray-900">Primero seleccione la fecha en que se llevará a cabo la sesión o sesiones.</span>
                            </li>
                            <li>
                                <span class="font-semibold text-gray-900">Segundo paso seleccione la hora en que se llevará a cabo la sesión o sesiones.</span>
                            </li>
                            <li>
                                <span class="font-semibold text-gray-900">De clic en el botón para generar la sesión.</span>
                            </li>
                        </ol>

                        <form wire:submit.prevent="{{ $userId->events->count() === 0 ? 'createValSession' : 'createTenSessions' }}">
                            <div class="grid gap-6 mb-6 md:grid-cols-2 mt-10">
                                <!-- Calendario -->
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    </div>
                                    <input id="datepicker-autohide" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" wire:change="updateSelectedDate($event.target.value)" datepicker-min-date="{{ $nextBusinessDayFormatted }}" type="text" class="bg-gray-700 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Selecciona Fecha"
                                    autocomplete="off">
                                </div>

                                <!-- Área para seleccionar horarios disponibles -->
                                <div class="mb-6 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-4 bg-gray-800"> <!-- Ajusté la altura máxima aquí -->
                                    <h2 class="text-lg font-semibold mb-2 text-white">Horarios Disponibles</h2>
                                    <div class="grid grid-cols-2 gap-4"> <!-- 4 columnas -->
                                        @foreach($availableTimes as $time)
                                            <button type="button" wire:click="updateSelectedTime('{{ $time }}')"
                                                    class="text-white rounded-lg p-2 hover:bg-blue-600 focus:outline-none {{ $selectedTime === $time ? 'bg-blue-900' : 'bg-blue-600' }}">
                                                {{ $time }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjetas con iconos -->
                            <div class="grid grid-cols-3">
                                <!-- Primera tarjeta con 3 iconos -->
                                <div class="p-4 bg-black rounded-lg shadow-md">
                                    Masaje / Valoración
                                    <hr>
                                    <div class="flex justify-around pt-3">
                                        @for ($i = 0; $i < 3; $i++)
                                            <div class="">
                                                <svg class="w-6 h-6 {{ ($masajeValoracionCount > $i) ? 'text-red-500' : 'text-green-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M2.535 11A3.981 3.981 0 0 0 2 13v4a1 1 0 0 0 1 1h2v1a1 1 0 1 0 2 0v-1h10v1a1 1 0 1 0 2 0v-1h2a1 1 0 0 0 1-1v-4c0-.729-.195-1.412-.535-2H2.535ZM20 9V8a4 4 0 0 0-4-4h-3v5h7Zm-9-5H8a4 4 0 0 0-4 4v1h7V4Z"/>
                                                </svg>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="flex justify-center pt-2">
                                        <span class="{{ ($masajeValoracionCount > 0) ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $masajeValoracionCount }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Tarjeta Manicure / Pedicure -->
                                <div class="p-4 bg-white rounded-lg shadow-md" wire:click="selectService('manicure')">
                                    Manicure / Pedicure
                                    <hr>
                                    <div class="flex justify-around pt-3">
                                        @for ($i = 0; $i < 2; $i++)
                                            <div class="">
                                                <svg class="w-6 h-6 {{ ($manicurePedicureCount > $i) ? 'text-red-500' : 'text-green-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M2.535 11A3.981 3.981 0 0 0 2 13v4a1 1 0 0 0 1 1h2v1a1 1 0 1 0 2 0v-1h10v1a1 1 0 1 0 2 0v-1h2a1 1 0 0 0 1-1v-4c0-.729-.195-1.412-.535-2H2.535ZM20 9V8a4 4 0 0 0-4-4h-3v5h7Zm-9-5H8a4 4 0 0 0-4 4v1h7V4Z"/>
                                                </svg>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="flex justify-center pt-2">
                                        <span class="{{ ($manicurePedicureCount > 0) ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $manicurePedicureCount }}
                                        </span>
                                    </div>

                                </div>

                                <!-- Tarjeta Reiki -->
                                <div class="p-4 bg-white rounded-lg shadow-md" wire:click="createSessionReiki">
                                    Reiki
                                    <hr>
                                    <div class="flex justify-center pt-3">
                                        @for ($i = 0; $i < 1; $i++)
                                            <div class="">
                                                <svg class="w-6 h-6 {{ ($reikiCount > $i) ? 'text-red-500' : 'text-green-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M2.535 11A3.981 3.981 0 0 0 2 13v4a1 1 0 0 0 1 1h2v1a1 1 0 1 0 2 0v-1h10v1a1 1 0 1 0 2 0v-1h2a1 1 0 0 0 1-1v-4c0-.729-.195-1.412-.535-2H2.535ZM20 9V8a4 4 0 0 0-4-4h-3v5h7Zm-9-5H8a4 4 0 0 0-4 4v1h7V4Z"/>
                                                </svg>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="flex justify-center pt-2">
                                        <span class="{{ ($reikiCount > 0) ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $reikiCount }}
                                        </span>
                                    </div>

                                </div>
                            </div>

                                <!-- Botón para crear sesiones -->
                            @if($masajeValoracionCount < 3)
                                <div class="mb-6 mt-4">
                                    <button type="submit" class="bg-green-500 text-white rounded-lg p-2 hover:bg-green-600 focus:outline-none">
                                        {{ $userId->events->count() === 0 ? 'Crear sesión de valoración' : 'Crear 10 sesiones' }}
                                    </button>

                                </div>
                            @endif

                        </form>

                        <!-- Lista de eventos -->
                        <div class="mt-10 w-full">
                            <h2 class="text-lg font-semibold mb-4">Eventos Programados</h2>
                            <table class="w-full bg-white border border-gray-300 rounded-lg shadow-md mt-6">
                                <thead>
                                <tr class="text-white font-bold" style="background-color: #2A1A3F">
                                    <th class="py-2 px-4 border-b">Fecha</th>
                                    <th class="py-2 px-4 border-b">Hora</th>
                                    <th class="py-2 px-4 border-b">Título</th>
                                    <th class="py-2 px-4 border-b">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userId->events as $index => $event)
                                    <tr class="hover:bg-gray-100 {{ $event->cancelled ? 'bg-yellow-300' : '' }}" style="{{ $event->cancelled ? 'background-color: #FFC027;' : '' }}">
                                        <td class="py-2 px-4 border-b">
                                            @if($event->cancelled)
                                                <span class="line-through">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</span>
                                                &rarr;
                                                {{ $this->selectedDate }}
                                            @else
                                                {{ $event->start_date }}
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            @if($event->cancelled)
                                                <span class="line-through">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i:s') }}</span>
                                                &rarr;
                                                {{ $this->selectedTime }}
                                            @else
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('H:i:s') }}
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">{{ $event->title }}</td>
                                        <td class="py-2 px-4 border-b flex space-x-2">
                                            @if($event->cancelled)
                                                <button wire:click="cancelEvent({{ $index }}, {{ 0 }})" class="text-gray-500 hover:underline">Cancelar</button>
                                                <button wire:click="cancelEvent({{ $index }}, {{ 1 }})" style="background-color: #F12430" class="text-white rounded-lg p-2 hover:bg-green-600 focus:outline-none">
                                                    Actualizar
                                                </button>
                                            @else
                                                <button wire:click="cancelEvent({{ $index }}, {{ 0 }})" class="text-red-500 hover:underline">Reagendar</button>
                                            @endif
                                            @if($event->description === "Sesiones Masaje" || $event->description === "Manicure" || $event->description === "Pedicure" || $event->description === "Reiki")
                                                    @if(\App\Models\EventSale::where('event_id', $event->id)->first())
                                                        <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                            Pagado
                                                        </span>
                                                    @else
                                                        <button wire:click="getPayService('{{$event->description}}', '{{$event->id}}')"  class="text-blue-500 hover:underline">Cobrar</button>
                                                    @endif
                                                @endif
                                                <button wire:model="objectEvent" wire:click="eventIdDelete({{ $event }})" class="text-red-500 hover:underline">Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para seleccionar tipo de servicio -->
        @if($selectedService && $manicurePedicureCount < 2)
            <div class="fixed inset-0 flex items-center justify-center z-50">
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold">Selecciona el Servicio</h3>
                    <button wire:click="createSession('Manicure')" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded">Manicure</button>
                    <button wire:click="createSession('Pedicure')" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded">Pedicure</button>
                    <button wire:click="$set('selectedService', null)" class="mt-3 text-gray-700">Cancelar</button>
                </div>
            </div>
        @endif
        @if($getPay)
            <div class="fixed inset-0 flex items-center justify-center z-50">
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold">Ingrea el monto:</h3>
                    <input wire:model="amountPay" type="text">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900">Tipo de pago</label>
                    <select wire:model="tipePay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>Selecciona tipo</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                    </select>
                    <button wire:click="processPay" class="mt-3 text-blue-700">Cobrar</button>
                    <button wire:click="cancelPay"  class="mt-3 text-gray-700">Cancelar</button>
                </div>
            </div>
        @endif
        <!-- Modal Loader Zone -->
        <div id="static-modal-events" data-modal-backdrop="static" tabindex="-1" aria-hidden="{{ !$showModal3 }}" class="{{ $showModal3 ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 flex justify-center items-center" style="height: 300px;"> <!-- Ajusta la altura según sea necesario -->
                    <!-- Modal header -->
                    <div class="p-4 md:p-5 space-y-4 flex flex-col justify-center items-center">
                        <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
                            <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
                            <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
                            <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                            <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                        </svg>
                        <p>Generando Sesiones...</p> <!-- Mensaje opcional -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const datepickerEl = document.getElementById('datepicker-autohide');

        datepickerEl.addEventListener('changeDate', function (event) {
            Livewire.dispatch('updateSelectedDate', [event.target.value] );
        });
    });

</script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('deleteEvent', (event) => {

            Swal.fire({
                title: "¿Estas seguro de eliminar la cita?",
                text: "Este proceso es irreversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('eventDeleteFunction');
                }
            });

        });
        Livewire.on('errorDateTime', (event) => {

            Swal.fire({
                title: "Debe seleccionar fecha y hora!",
                text: "para poder actualizar el evento",
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: "#2A1A3F",
                confirmButtonText: "OK"
            });

        });
        Livewire.on('errorDateTimeCard', (event) => {

            Swal.fire({
                title: "Debe seleccionar fecha y hora!",
                text: "para poder agendar",
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: "#2A1A3F",
                confirmButtonText: "OK"
            });

        });
        Livewire.on('updateEvent', (event) => {
            Swal.fire({
                title: "Evento actualizado correctamente!",
                text: "",
                icon: "success",
                showCancelButton: false,
                confirmButtonColor: "#2A1A3F",
                confirmButtonText: "OK"
            });

        });

        Livewire.on('emptyTimeEvents', (event) => {
            setTimeout(() => {
                Swal.fire({
                    title: "Sesiones creadas correctamente!",
                    text: "en la parte inferior podras consultar tus sesiones",
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#2A1A3F",
                    cancelButtonColor: "#F12430",
                    confirmButtonText: "OK"
                }).then((result) => {
                    // Redirigir a la misma página después de cerrar el alert
                    window.location.href = window.location.href;
                });
            }, 5000);
        })
    });
</script>
