@props([
    'bodyClass' => '',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
    <meta name="description" content="{{ isset($description) ? $description : config('app.name') }}">
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <wireui:scripts />
</head>

<body class="{{ $bodyClass }}">
    {{ $slot }}
    @livewireScriptConfig
    @yield('scripts')
</body>

</html>
