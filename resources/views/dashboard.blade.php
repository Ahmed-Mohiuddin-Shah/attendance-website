<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>

    @endif

    <div class="bg-gray-800 p-4 text-white flex justify-between">
        <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->fullname }}!</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="submit" value="Logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>

    <!-- Teacher Dashboard -->
    @if(auth()->user()->role === 'teacher')
    <div class="bg-gray-200 p-4">
        <div class="mb-4">
            <details class="align-left bg-green-200 dark:bg-green-500  open:transition duration-300 m-5 p-10 rounded-lg">
                <summary class="text-xl font-bold">
                    <h2 class="text-xl font-bold">Create a new Class</h2>
                </summary>
                <form method="POST" action="{{ route('create-class') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Class Name:</label>
                        <input type="text" id="name" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="start_date_time" class="block text-gray-700 text-sm font-bold mb-2">Start Time:</label>
                        <input type="number" id="start_date_time" min="9" max="17" name="start_date_time" required>
                    </div>
                    <div class="mb-4">
                        <label for="credit_hours" class="block text-gray-700 text-sm font-bold mb-2">Credit Hours:</label>
                        <input type="number" id="credit_hours" name="credit_hours" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex items-center justify-between">
                        <input type="submit" value="Create Class" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    </div>
                </form>
            </details>

        </div>
        <div class="mb-4">
            <h2 class="text-xl font-bold">Mark Attendance</h2>
            <div class="flex flex-row flex-wrap">
                @foreach($classes as $classroom)
                <div class="bg-white shadow-md border border-gray-200 rounded-lg max-w-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <a href="#">
                            <h5 class="text-gray-900 font-bold text-2xl tracking-tight mb-2 dark:text-white">{{ $classroom->name }}</h5>
                        </a>
                        <p class="font-normal text-gray-700 mb-3 dark:text-gray-400">Start Time: {{ $classroom->start_time }}</p>
                        <p class="font-normal text-gray-700 mb-3 dark:text-gray-400">End Time: {{ $classroom->end_time }}</p>
                        <p class="font-normal text-gray-700 mb-3 dark:text-gray-400">Credit Hours: {{ $classroom->credit_hours }}</p>
                        <form method="GET" action="{{route('add-students-page', [ 'id' => $classroom->id ])}}">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $classroom->id }}">
                            <input type="submit" value="Add Students" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        </form>
                        <hr class="my-4">
                        <a href="{{ route('mark-attendance-page', ['id' => $classroom->id]) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Mark Attendance
                        </a>
                    </div>
                </div>
                <div class="p-5"></div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Student Dashboard -->
    @if(auth()->user()->role === 'student')
    <div class="bg-blue-200 p-4">
        <div class="mb-4">
            <h2 class="text-xl font-bold">My Classes</h2>
            <hr class="my-4">
            <div class="flex flex-row flex-wrap">
                @if (count($classes) === 0)
                <div class="bg-white shadow-md border border-gray-200 rounded-lg max-w-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <p class="font-normal text-gray-700 mb-3 dark:text-gray-400">You are not enrolled in any classes.</p>
                    </div>
                </div>
                @else
                @foreach($classes as $classroom)
                <div class="bg-white shadow-md border border-gray-200 rounded-lg max-w-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <a href="#">
                            <h5 class="text-gray-900 font-bold text-2xl tracking-tight mb-2 dark:text-white">{{ $classroom->name }}</h5>
                        </a>
                        <p class="font-normal text-gray-700 mb-3 dark:text-gray-400">Start Time: {{ $classroom->start_time }}</p>
                        <p class="font-normal text-gray-700 mb-3 dark:text-gray-400">End Time: {{ $classroom->end_time }}</p>
                        <p class="font-normal text-gray-700 mb-3 dark:text-gray-400">Credit Hours: {{ $classroom->credit_hours }}</p>
                        <hr class="my-4">
                        <form method="GET" action="{{ route('view-attendance-page', [ 'id' => $classroom->id ]) }}">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $classroom->id }}">
                            <input type="submit" value="View Attendance" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        </form>
                    </div>
                </div>
                <div class="p-5"></div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif

</body>

</html>