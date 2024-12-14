
<div class="p-4 sm:ml-64 mt-14">
    <h1 class="text-xl">Productos</h1>

    <div class="bg-white mt-5 p-4">
        <button wire:ignore data-modal-target="crud-modal-product" data-modal-toggle="crud-modal-product" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 ">Agregar</button>
        <div class="relative overflow-x-auto">
            <label for="table-search" class="sr-only">Buscar</label>
            <div class="relative mt-1">
            
                <input wire:model="search" wire:keyup="searchProducts($event.target.value)" type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar productos">
            </div><br>
        <table class="w-full text-sm text-left rtl:text-right">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3"> Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Cantidad
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Categoria
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Precio
                        </th>
                        <th scope="col" class="px-6 py-3">
                            IVA
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total con IVA
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="bg-white border-b">
                        <td class="font-medium text-gray-900 whitespace-nowrap">{{ $product->name }}</td>
                            <td>{{ $product->cant }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>${{ $product->price }}</td>
                            <td>${{ $product->category->id === 2 ? '0.00' : $product->price }}</td>
                            <td>${{ $product->category->id === 2 ? $product->price : $product->price*1.16 }}</td>
                        <td class="px-6 py-4">
                            <div wire:click="findProduct({{ $product->id }})" data-modal-target="crud-modal-edit-product" data-modal-toggle="crud-modal-edit-product" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
         </div>
    </div>
    <!-- Main modal -->
    <!-- Main modal -->
    <div id="crud-modal-product" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-white">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Crear Producto
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="crud-modal-product">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="save"  class="p-4 md:p-5">
                    <button type="button" id="toggleCamera" class="mt-4 px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                        Iniciar Escaneo
                    </button>
                    <div id="interactive" class="relative"></div>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input wire:model="name" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Nombre del producto" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                            <input wire:model="price" type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="$2999" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">

                            <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Imagen</label>
                            <input wire:ignore wire:model="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" id="file_input" type="file">

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
                            <select wire:model="category_id" id="category" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option selected="">Categoría</option>
                                <option value="1">Masajes</option>
                                <option value="2">Uñas</option>
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="barcode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código de Barras</label>
                            <input wire:model="code" type="text" name="barcode" id="barcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="123456789">
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                            <textarea wire:model="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Descripción del producto..."></textarea>
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Agregar Producto
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore id="crud-modal-edit-product" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-white">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Editar Producto
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal-edit-product">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form   class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input wire:model="nameUpdate" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Nombre del producto" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                            <input wire:model="priceUpdate" type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="$2999" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Imagen</label>
                            <input wire:ignore wire:model="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" id="file_input" type="file">

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
                            <select wire:model="category_id" id="category" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option selected="">Categoría</option>
                                <option value="1">Masajes</option>
                                <option value="2">Uñas</option>
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="barcode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código de Barras</label>
                            <input wire:model="codeUpdate" type="text" name="barcode" id="barcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="123456789">
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                            <textarea wire:model="descriptionUpdate" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Descripción del producto..."></textarea>
                        </div>
                        <div class="col-span-2">
                            <img src="https://holos-spa.com/images/products/1.jpeg" width="30%" alt=""/>
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Actualizar Producto
                    </button>
                    {{ $imageUpdate }}
                </form>
            </div>
        </div>
    </div>
</div>
<script>

    if (document.getElementById("selection-table-product") && typeof simpleDatatables.DataTable !== 'undefined') {

        let multiSelect = true;
        let rowNavigation = false;
        let table = null;

        const resetTable = function() {
            if (table) {
                table.destroy();
            }

            const options = {
                rowRender: (row, tr, _index) => {
                    if (!tr.attributes) {
                        tr.attributes = {};
                    }
                    if (!tr.attributes.class) {
                        tr.attributes.class = "";
                    }
                    if (row.selected) {
                        tr.attributes.class += " selected";
                    } else {
                        tr.attributes.class = tr.attributes.class.replace(" selected", "");
                    }
                    return tr;
                }
            };
            if (rowNavigation) {
                options.rowNavigation = true;
                options.tabIndex = 1;
            }

            table = new simpleDatatables.DataTable("#selection-table-product", options);


            // Mark all rows as unselected
            table.data.data.forEach(data => {
                data.selected = false;
            });

            table.on("datatable.selectrow", (rowIndex, event) => {
                event.preventDefault();
                const row = table.data.data[rowIndex];
                if (row.selected) {
                    row.selected = false;
                } else {
                    if (!multiSelect) {
                        table.data.data.forEach(data => {
                            data.selected = false;
                        });
                    }
                    row.selected = true;
                }
                table.update();
            });
        };

        // Row navigation makes no sense on mobile, so we deactivate it and hide the checkbox.
        const isMobile = window.matchMedia("(any-pointer:coarse)").matches;
        if (isMobile) {
            rowNavigation = false;
        }

        resetTable();
    }
</script>
<script>
    let isScanning = false;

    document.getElementById('toggleCamera').addEventListener('click', function() {
        if (!isScanning) {
            startScanning();
            this.textContent = 'Detener Escaneo';
        } else {
            stopScanning();
            this.textContent = 'Iniciar Escaneo';
        }
        isScanning = !isScanning;
    });

    function startScanning() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#interactive'),
                constraints: {
                    facingMode: "environment" // Usar la cámara trasera en dispositivos móviles
                }
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader"] // Agrega más tipos según sea necesario
            }
        }, function(err) {
            if (err) {
                console.error("Error al iniciar Quagga:", err);
                return;
            }
            console.log("Iniciando el escáner...");
            Quagga.start();
        });

        // Manejo de detección
        Quagga.onDetected(function(data) {
            const code = data.codeResult.code;
            document.getElementById("barcode").value = code;

            // Detener el escáner después de detectar un código
            stopScanning();
        });
    }

    function stopScanning() {
        Quagga.stop();
    }
</script>
<script>
    window.addEventListener('productCreated', event => {
        var myModalEl = document.getElementById('crud-modal-product');

        // Cerrar el modal usando Flowbite
        myModalEl.classList.add('hidden'); // Oculta el modal

        // Alternativamente, si estás usando la clase Modal de Flowbite:
        const modalInstance = new Modal(myModalEl);
        modalInstance.hide(); // Cierra el modal si está abierto
    });

</script>
