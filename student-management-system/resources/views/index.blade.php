<html>
    <head>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="bg-gray-200 shadow-lg sticky top-0 p-4">
            <div class="container mx-auto flex justify-between items-center py-2">
                <h1 class="text-xl text-gray-900">Student List</h1>
                <a href="{{'/admin'}}">
                    <button
                        class="bg-blue-800 hover:bg-blue-600 text-white text-sm px-3 py-2 rounded transition-colors duration-300"
                        type="button"
                    >
                        Admin Panel
                    </button>
                </a>
            </div>
        </header>
        <div class="max-w-6xl mx-auto p-4">
            <livewire:student.list />
        </div>
    </body>
</html>