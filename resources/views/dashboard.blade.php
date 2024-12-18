<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

@php
        date_default_timezone_set('America/Mexico_City');
        $users = \App\Models\User::whereDate('created_at', \Carbon\Carbon::today())->doesntHave('events')->get();
        $usersCount = \App\Models\User::where('name', '<>', 'Administrador')->count();
        $sesionsCount = \App\Models\Event::count();
        $productsCount = \App\Models\Product::count();
        $nextAppointments = \App\Models\Event::whereDate('start_date', \Carbon\Carbon::today())->get();
@endphp

    <div class="p-4 sm:ml-64 mt-14">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 md:p-12">
                <a href="{{ route('calendar') }}" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M17 11h-2.722L8 17.278a5.512 5.512 0 0 1-.9.722H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM6 0H1a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V1a1 1 0 0 0-1-1ZM3.5 15.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM16.132 4.9 12.6 1.368a1 1 0 0 0-1.414 0L9 3.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z"/>
                    </svg>
                    Sesiones
                </a>
                <h2 class="text-gray-900 text-3xl font-extrabold mb-2">Sesiones</h2>
                <p class="text-lg font-normal text-gray-500 mb-4">{{ $sesionsCount }}</p>
                <a href="{{ route('calendar') }}" class="text-blue-600  hover:underline font-medium text-lg inline-flex items-center">Ver
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 md:p-12">
                <a href="{{ route('users') }}" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M17 11h-2.722L8 17.278a5.512 5.512 0 0 1-.9.722H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM6 0H1a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V1a1 1 0 0 0-1-1ZM3.5 15.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM16.132 4.9 12.6 1.368a1 1 0 0 0-1.414 0L9 3.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z"/>
                    </svg>
                    Clientes
                </a>
                <h2 class="text-gray-900 text-3xl font-extrabold mb-2">Clientes</h2>
                <p class="text-lg font-normal text-gray-500 mb-4">{{ $usersCount}}</p>
                <a href="{{ route('users') }}" class="text-blue-600  hover:underline font-medium text-lg inline-flex items-center">Ver
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 md:p-12">
                <a href="{{ route('productos') }}" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M17 11h-2.722L8 17.278a5.512 5.512 0 0 1-.9.722H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM6 0H1a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V1a1 1 0 0 0-1-1ZM3.5 15.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM16.132 4.9 12.6 1.368a1 1 0 0 0-1.414 0L9 3.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z"/>
                    </svg>
                    Productos
                </a>
                <h2 class="text-gray-900 text-3xl font-extrabold mb-2">Productos</h2>
                <p class="text-lg font-normal text-gray-500 mb-4">{{ $productsCount }}</p>
                <a href="{{ route('productos') }}" class="text-blue-600  hover:underline font-medium text-lg inline-flex items-center">Ver
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </div>


            <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">
                <div class="flex justify-between">
                    <div>
                        <h5 class="leading-none text-3xl font-bold text-gray-900 pb-2">${{ App\Models\Sale::sum('total'); }}</h5>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Ventas esta semana</p>
                    </div>
                    <div
                        class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 text-center">
                        23%
                        <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                        </svg>
                    </div>
                </div>
                <div id="data-series-chart"></div>
                <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between mt-5">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button
                            id="dropdownDefaultButton"
                            data-dropdown-toggle="lastDaysdropdown"
                            data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
                            type="button">
                            Ultimos 7 dias
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <form method="GET" action="{{ route('dashboard') }}">
                            <div id="lastDaysdropdown" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                    <li>
                                        <button type="submit" name="range" value="yesterday" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ayer</button>
                                    </li>
                                    <li>
                                        <button type="submit" name="range" value="today" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Hoy</button>
                                    </li>
                                    <li>
                                        <button type="submit" name="range" value="last_7_days" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Últimos 7 días</button>
                                    </li>
                                    <li>
                                        <button type="submit" name="range" value="last_30_days" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Últimos 30 días</button>
                                    </li>
                                    <li>
                                        <button type="submit" name="range" value="last_90_days" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Últimos 90 días</button>
                                    </li>
                                </ul>
                            </div>
                        </form>

                        <a
                            href="#"
                            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                            Reporte
                            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>



            <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-xl font-bold leading-none text-gray-900">Proximas Citas</h5>
                    <a href="{{ route('users') }}" class="text-sm font-medium text-blue-600 hover:underline">
                        Ver Todo
                    </a>
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($nextAppointments as $nextAppointment)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="w-[48px] h-[48px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                        </svg>

                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $nextAppointment->user->name }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                        {{ \Carbon\Carbon::parse($nextAppointment->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($nextAppointment->end_date)->format('H:i') }}
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-xl font-bold leading-none text-gray-900">Nuevas Solicitudes</h5>
                    <a href="{{ route('users') }}" class="text-sm font-medium text-blue-600 hover:underline">
                        Ver Todo
                    </a>
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="w-[48px] h-[48px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                        </svg>

                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $user->email }}
                                        </p>
                                    </div>

                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @php
        $dailyTotals = [];
        $range = request('range');

        switch ($range) {
            case 'yesterday':
                $date = \Carbon\Carbon::now()->subDay()->format('Y-m-d');
                $total = \App\Models\Sale::whereDate('created_at', $date)->sum('total');
                $dailyTotals[] = $total;
                break;

            case 'today':
                $date = \Carbon\Carbon::now()->format('Y-m-d');
                $total = \App\Models\Sale::whereDate('created_at', $date)->sum('total');
                $dailyTotals[] = $total;
                break;

            case 'last_7_days':
                for ($i = 6; $i >= 0; $i--) {
                    $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                    $total = \App\Models\Sale::whereDate('created_at', $date)->sum('total');
                    $dailyTotals[] = $total;
                }
                break;

            case 'last_30_days':
                for ($i = 29; $i >= 0; $i--) {
                    $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                    $total = \App\Models\Sale::whereDate('created_at', $date)->sum('total');
                    $dailyTotals[] = $total;
                }
                break;

            case 'last_90_days':
                for ($i = 89; $i >= 0; $i--) {
                    $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                    $total = \App\Models\Sale::whereDate('created_at', $date)->sum('total');
                    $dailyTotals[] = $total;
                }
                break;

            default:
                // Si no se selecciona ningún rango, puedes optar por mostrar los últimos 7 días
                for ($i = 6; $i >= 0; $i--) {
                    $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                    $total = \App\Models\Sale::whereDate('created_at', $date)->sum('total');
                    $dailyTotals[] = $total;
                }
        }
    @endphp

</x-app-layout>
<script>
        const dailyTotals = @json($dailyTotals);
        const options = {
        // add data series via arrays, learn more here: https://apexcharts.com/docs/series/
        series: [
    {
        name: "Productos",
        data: dailyTotals,
        color: "#1A56DB",
    },
        ],
        chart: {
        height: "100%",
        maxWidth: "100%",
        type: "area",
        fontFamily: "Inter, sans-serif",
        dropShadow: {
        enabled: false,
    },
        toolbar: {
        show: false,
    },
    },
        tooltip: {
        enabled: true,
        x: {
        show: false,
    },
    },
        legend: {
        show: false
    },
        fill: {
        type: "gradient",
        gradient: {
        opacityFrom: 0.55,
        opacityTo: 0,
        shade: "#1C64F2",
        gradientToColors: ["#1C64F2"],
    },
    },
        dataLabels: {
        enabled: false,
    },
        stroke: {
        width: 6,
    },
        grid: {
        show: false,
        strokeDashArray: 4,
        padding: {
        left: 2,
        right: 2,
        top: 0
    },
    },
        xaxis: {
        categories: ['01 Diciembre', '02 Diciembre', '03 Diciembre', '04 Diciembre', '05 Diciembre', '06 Diciembre', '07 Diciembre'],
        labels: {
        show: false,
    },
        axisBorder: {
        show: false,
    },
        axisTicks: {
        show: false,
    },
    },
        yaxis: {
        show: false,
        labels: {
        formatter: function (value) {
        return '$' + value;
    }
    }
    },
    }

        if (document.getElementById("data-series-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("data-series-chart"), options);
        chart.render();
    }
</script>
