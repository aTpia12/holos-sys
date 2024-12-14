<div class="p-4 sm:ml-64 mt-14">
        <h1 class="text-xl">Categorias</h1>

        <div class="bg-white mt-5 p-4">
            <button wire:ignore id="category-modal" data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 ">Agregar</button>

            <div class="relative overflow-x-auto">
                <div class="pb-4 bg-white">
        <label for="table-search" class="sr-only">Buscar</label>
        <div class="relative mt-1">
        
            <input wire:model="search" wire:keyup="searchCategories($event.target.value)" type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="buscar categorias">
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Descripción
                </th>
                <th scope="col" class="px-6 py-3">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="bg-white border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                    {{ $category->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $category->name }}
                </td>
                <td class="px-6 py-4">
                    <div wire:click="findCategory({{ $category->id }})" data-modal-target="crud-modal-edit-category" data-modal-toggle="crud-modal-edit-category" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>

        </div>
        <!-- Main modal -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-gray-700 rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Crear Nueva Categoría
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form wire:submit.prevent="save" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <input wire:model="name" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Ingresa un nombre para la categoría" required="">
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                <textarea wire:model="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Describe la categoría"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Agregar categoría
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Main modal Edit -->
        <div wire:ignore id="crud-modal-edit-category" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Editar Categoría
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="crud-modal-edit-category">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form wire:submit.prevent="update" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <input wire:model="nameUpdate" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Ingresa un nombre para la categoría" required="">
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                <textarea wire:model="descriptionUpdate" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Describe la categoría"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Agregar categoría
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        window.addEventListener('categoryCreated', event => {
            var myModalEl = document.getElementById('crud-modal');

            // Cerrar el modal usando Flowbite
            myModalEl.classList.add('hidden'); // Oculta el modal

            // Alternativamente, si estás usando la clase Modal de Flowbite:
            const modalInstance = new Modal(myModalEl);
            modalInstance.hide(); // Cierra el modal si está abierto
        });

        window.addEventListener('categoryUpdated', event => {
            var myModalEl2 = document.getElementById('crud-modal-edit-category');

            // Cerrar el modal usando Flowbite
            myModalEl2.classList.add('hidden'); // Oculta el modal

            // Alternativamente, si estás usando la clase Modal de Flowbite:
            const modalInstance2 = new Modal(myModalEl2);
            modalInstance2.hide(); // Cierra el modal si está abierto
        });
    </script>
    <script>
        function openModal() {
            var myModalEl = document.getElementById('crud-modal');
            if (myModalEl) {
                myModalEl.classList.remove('hidden'); // Muestra el modal
            }
        }

        document.getElementById('category-modal').addEventListener('click', function(){
            const $targetEl = document.getElementById('crud-modal');

            const modal = new Modal($targetEl);

            modal.show();
        });
    </script>
