<html>
    <head>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
            <livewire:student.list />
        </div>
    </body>
</html>