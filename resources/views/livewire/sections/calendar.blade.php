<div class="p-4 sm:ml-64 mt-14">
    <div wire:ignore id="calendar"></div>




    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek, timeGridDay'
                },
                droppable: true,
                editable: true,
                initialView: 'dayGridMonth',
                timeZone: 'America/Mexico_City',
                events: @json($events),
                eventTimeFormat: { // like '14:30:00'
                    hour: '2-digit',
                    minute: '2-digit',
                },
                eventDrop: function(info) {
                    // Lógica para manejar el cambio de fecha/hora al arrastrar
                    let eventId = info.event.id; // Asegúrate de que tengas un ID único para cada evento
                    let start = info.event.start.toISOString();
                    let end = info.event.end ? info.event.end.toISOString() : start; // Si no hay fin, usa el inicio

                
                    Livewire.dispatch('updateEvent', {eventId: eventId, start: start, end: end}); // Llama al método Livewire para actualizar
                },
                eventResize: function(info) {
                    // Lógica para manejar el cambio de fecha/hora al redimensionar
                    let eventId = info.event.id; // Asegúrate de que tengas un ID único para cada evento
                    let start = info.event.start.toISOString();
                    let end = info.event.end ? info.event.end.toISOString() : start; // Si no hay fin, usa el inicio

                    Livewire.dispatch('updateEvent', {eventId: eventId, start: start, end: end}); // Llama al método Livewire para actualizar
                }
            });
            calendar.render();
        });

    </script>
</div>

