<div id="imprimible" wire:ignore class="p-4 sm:ml-64 mt-14">
    <div id="ticket" class="max-w-lg mx-auto p-6 mt-10 bg-white shadow-xl rounded-lg border border-gray-200">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Ticket de Venta</h2>
    
    <div class="mb-4">
        <p class="text-gray-700"><strong>Cliente:</strong> {{ $ticketData['name'] }}</p>
        <p class="text-gray-700"><strong>Fecha:</strong> {{ $ticketData['date']->format('d/m/Y H:i') }}</p>
    </div>

    <table class="w-full mt-4 border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Producto</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Cantidad</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticketData['products'] as $product)
                <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                    <td class="border-b border-gray-300 px-4 py-2">{{ $product->name }}</td>
                    <td class="border-b border-gray-300 px-4 py-2">{{ $product->quantity }}</td>
                    <td class="border-b border-gray-300 px-4 py-2">${{ number_format($product->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6 p-4 bg-gray-100 rounded-lg shadow-md">
        <div class="flex justify-between">
            <p class="font-semibold"><strong>Subtotal:</strong></p>
            <p>${{ number_format($ticketData['subtotal'], 2) }}</p>
        </div>
        <div class="flex justify-between">
            <p class="font-semibold"><strong>IVA:</strong></p>
            <p>${{ number_format($ticketData['iva'], 2) }}</p>
        </div>
        <div class="flex justify-between font-bold text-lg">
            <p><strong>Total:</strong></p>
            <p>${{ number_format($ticketData['total'], 2) }}</p>
        </div>
    </div>

    <!-- Bot車n para imprimir -->
    <div class="mt-6">
        <button onclick="imprimirDiv()" id="impVent" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition duration-200 shadow-md">
            Imprimir Ticket
        </button>
    </div>
    <div class="mt-6">
        <button wire:click="sendTicketEmail" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition duration-200 shadow-md">
            Enviar Email
        </button>
    </div>
</div>
</div>

<script>
        document.getElementById('impVent').addEventListener('click', function(){
            var contenido = document.getElementById('imprimible').innerHTML; // Obtiene el contenido del div
            var ventana = window.open('', '_blank'); // Abre una nueva ventana
            ventana.document.write('<style>');
    ventana.document.write('body { font-family: Arial, sans-serif; margin: 0; padding: 0; }');
    ventana.document.write('.bg-white { background-color: white; }');
    ventana.document.write('.bg-gray-100 { background-color: #f7fafc; }');
    ventana.document.write('.bg-gray-200 { background-color: #edf2f7; }');
    ventana.document.write('.border { border: 1px solid #e2e8f0; }');
    ventana.document.write('.rounded-lg { border-radius: 0.5rem; }');
    ventana.document.write('.shadow-lg { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }');
    ventana.document.write('.text-center { text-align: center; }');
    ventana.document.write('.text-left { text-align: left; }');
    ventana.document.write('.text-sm { font-size: 0.875rem; }');
    ventana.document.write('.font-bold { font-weight: bold; }');
    ventana.document.write('.flex { display: flex; }');
    ventana.document.write('.justify-between { justify-content: space-between; }');
    ventana.document.write('.hover\\:bg-gray-100:hover { background-color: #f7fafc; }'); // Estilo para hover
    ventana.document.write('h2 { margin-bottom: 1.5rem; }'); // Estilo para el título
    ventana.document.write('table { width: 100%; margin-top: 1rem; border-collapse: collapse; }'); // Estilo de la tabla
    ventana.document.write('th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }'); // Estilo de celdas
    ventana.document.write('</style>');

            ventana.document.write(contenido); // Escribe el contenido del div en la nueva ventana

            ventana.document.close(); // Cierra el documento
            ventana.focus(); // Enfoca la nueva ventana
            ventana.print(); // Llama a la función de impresión
            ventana.close(); // Cierra la ventana después de imprimir
        });
    </script>