<div class="p-4 sm:ml-64 mt-14">
    <h1 class="text-2xl font-bold mb-4">Ventas</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($sales as $sale)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $sale->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $sale->type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($sale->total, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('ticket', $sale->id) }}">Ver</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total general -->
        <div class="px-6 py-4">
            <strong>Total General:</strong> ${{ number_format($sales->sum('total'), 2) }}
        </div>
    </div>
</div>