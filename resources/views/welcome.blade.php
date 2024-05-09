<?php
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Attendance Management System</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            content: ["./*.html"],
            theme: {
                extend: {},
            },
            darkMode: "class",
        };
    </script>

</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">

    <div class="bg-black flex items-center justify-center h-screen">
        <div class="text-center">
            <h1 class="text-white text-4xl font-bold">Attendance Management System</h1>
            <p class="text-white mt-4">Welcome to the Attendance Management System. Click the button below to get started.</p>
            <hr class="my-4">
            <a href="{{ route('login-page') }}" class="mt-8 px-4 py-2 bg-blue-500 text-white rounded-md">Get Started</a>
        </div>
    </div>

    <div class="fixed bottom-0 right-0 p-4">
        <p class="text-sm text-white">Made with ❤️ by Ahmed Mohiuddin</p>
    </div>

</body>

</html>