<div class="p-4 sm:ml-64 mt-14">
    <h1 class="text-2xl font-bold mb-4">Sistema de Punto de Venta</h1>

    <!-- Buscador de Productos -->
    <div class="mb-4">
        <input type="text" wire:model="search" wire:keydown.enter="searchProducts($event.target.value)" placeholder="Buscar productos..." class="border rounded p-2 w-full">
    </div>

    <!-- Tabla de Productos -->
    <div class="overflow-x-auto mt-2">
        <table class="min-w-full bg-white border border-gray-300">
        <thead>
        <tr>
            <th class="py-2 px-4 border-b">Nombre</th>
            <th class="py-2 px-4 border-b">Precio</th>
            <th class="py-2 px-4 border-b">Imagen</th>
            <th class="py-2 px-4 border-b">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                <td class="py-2 px-4 border-b">${{ number_format($product->price, 2) }}</td>
                <td class="py-2 px-4 border-b"><img alt="{{ $product->name }}" src="https://holos-spa.com/images/products/{{ $product->image }}.jpeg" width="10%"></td>
                <td class="py-2 px-4 border-b">
                    <button wire:click="addToCart({{ $product->id }})" class="bg-blue-500 text-white rounded px-4 py-1">Agregar</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>

    <!-- Carrito -->
    <h2 class="text-xl font-bold mt-6">Carrito</h2>
    @if(count($cart) > 0)
        <div class="overflow-x-auto mt-2">
            <table class="min-w-full bg-white border border-gray-300 mt-2">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">Producto</th>
                <th class="py-2 px-4 border-b">Precio</th>
                <th class="py-2 px-4 border-b">Cantidad</th>
                <th class="py-2 px-4 border-b">Total</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cart as $item)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $item['name'] }}</td>
                    <td class="py-2 px-4 border-b">${{ number_format($item['price'], 2) }}</td>
                    <td class="py-2 px-4 border-b">{{ $item['quantity'] }}</td>
                    <td class="py-2 px-4 border-b">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    <td class="py-2 px-4 border-b">
                        <button wire:click="removeFromCart({{ $item['id'] }})" class="bg-red-500 text-white rounded px-4 py-1">Eliminar</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

        <!-- Total de Venta -->
        <div class="mt-4">
            <!-- Total de Venta -->
            <div class="mt-6 p-6 bg-white rounded-lg shadow-lg border border-gray-300">
                <h2 class="text-xl font-semibold mb-4">Resumen de la Venta</h2>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700">SubTotal:</span>
                    <span class="font-bold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700">IVA:</span>
                    <span class="font-bold text-gray-900">${{ number_format($iva, 2) }}</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-300 pt-2 mt-4">
                    <span class="text-lg font-bold text-gray-800">Total:</span>
                    <span class="text-lg font-bold text-blue-600">${{ number_format($total, 2) }}</span>
                </div>
            
            </div>

            
            <!-- Campo para buscar usuarios -->
            <div class="relative w-full max-w-md mt-5">
                <input type="text" 
                       wire:model="userSearch" 
                       wire:keyup="searchUsers($event.target.value)" 
                       placeholder="Buscar cliente..."
                       class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" />
                
                <!-- Lista de usuarios encontrados -->
                @if(!empty($users))
                    <ul class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg mt-1 shadow-lg">
                        @foreach($users as $user)
                            <li wire:click="{{ $user->id === 'new' ? 'selectUser(0)' : 'selectUser(' . $user->id . ')' }}" 
                                class="py-2 px-4 cursor-pointer hover:bg-blue-100 transition duration-150 ease-in-out">
                                
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                
            
                @endif
            
                <!-- Mostrar el usuario seleccionado -->
                @if($selectedUser)
                    <h3 class="mt-4 text-lg font-semibold">Cliente Seleccionado: <span class="font-normal">{{ optional(\App\Models\User::find($selectedUser))->name }}</span></h3>
                @endif
            
            </div>


            <!-- Tipos de Pago -->
            <div class="mt-4">
                <label for="payment_type" class="block text-sm font-medium text-gray-700">Tipo de Pago:</label>
                <select wire:model="paymentType" id="payment_type" class="mt-1 block w-full p-2 border rounded-md">
                    <option value="">Seleccionar...</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                </select>

                <!-- Botón para Procesar Venta -->
                <button wire:click="processSale" class="mt-3 bg-green-500 text-white rounded px-4 py-1">Procesar Venta</button>

            </div>

        </div>

    @else
        <p>No hay productos en el carrito.</p>
    @endif
    

                <button id="pos-user-modal" data-modal-target="{{$showNewUserFields ?? 'crud-modal-pos-user'}}" data-modal-toggle="{{$showNewUserFields ?? 'crud-modal-pos-user'}}" class="{{$showNewUserFields ? 'block' : 'hidden'}} text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                  Toggle modal
                </button>
 
                
<!-- Main modal -->
<div id="crud-modal-pos-user" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create New Product
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal-pos-user">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$2999" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Select category</option>
                            <option value="TV">TV/Monitors</option>
                            <option value="PC">PC</option>
                            <option value="GA">Gaming/Console</option>
                            <option value="PH">Phones</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                        <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>                    
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Add new product
                </button>
            </form>
        </div>
    </div>
</div> 

</div>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('errorStock', message => {

            Swal.fire({
                title: message,
                text: "",
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: "#2A1A3F",
                confirmButtonText: "OK"
            });

        });
    });
</script>
<script>
        document.getElementById('pos-user-modal').addEventListener('click', function(){
            const $targetEl = document.getElementById('crud-modal-pos-user');

            const modal = new Modal($targetEl);

            modal.show();
        });
</script>

