<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Essência Company</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        crossorigin="anonymous" />
    @viteReactRefresh
    @vite('resources/js/app.js')
</head>

<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="root"></div>
</body>

</html>
