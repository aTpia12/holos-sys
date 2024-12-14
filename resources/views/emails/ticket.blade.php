<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6; /* bg-gray-100 */
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff; /* bg-white */
            border-radius: 8px; /* rounded-lg */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* shadow-lg */
            padding: 24px; /* p-6 */
            border: 1px solid #e5e7eb; /* border-gray-200 */
        }
        h2 {
            font-size: 24px; /* text-3xl */
            font-weight: bold;
            text-align: center;
            color: #1f2937; /* text-gray-800 */
            margin-bottom: 24px; /* mb-6 */
        }
        .details {
            margin-bottom: 16px; /* mb-4 */
            color: #4b5563; /* text-gray-700 */
        }
        table {
            width: 100%; /* w-full */
            border-collapse: collapse;
            margin-top: 16px; /* mt-4 */
        }
        th, td {
            border: 1px solid #d1d5db; /* border-gray-300 */
            padding: 12px; /* px-4 py-2 */
            text-align: left;
        }
        th {
            background-color: #e5e7eb; /* bg-gray-200 */
            font-weight: bold;
        }
        .totals {
            margin-top: 24px; /* mt-6 */
            background-color: #f9fafb; /* bg-gray-100 */
            padding: 16px; /* p-4 */
            border-radius: 8px; /* rounded-lg */
        }
        .totals div {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ticket de Venta</h2>
        
        <div class="details">
            <p><strong>Cliente:</strong> {{ $ticketData['name'] }}</p>
            <p><strong>Email:</strong> {{ $ticketData['email'] }}</p>
            <p><strong>Fecha:</strong> {{ $ticketData['date']->format('d/m/Y H:i') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ticketData['products'] as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div><strong>Subtotal:</strong> ${{ number_format($ticketData['subtotal'], 2) }}</div>
            <div><strong>IVA:</strong> ${{ number_format($ticketData['iva'], 2) }}</div>
            <div><strong>Total:</strong> ${{ number_format($ticketData['total'], 2) }}</div>
        </div>
        <h2>Este comprobante no tiene efectos fiscales.</h2>
    </div>
</body>
</html>
