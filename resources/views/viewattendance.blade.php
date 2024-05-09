<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>

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
        <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->role }}!</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="submit" value="Logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>

    <!-- Student Attendance View -->
    @if(auth()->user()->role === 'student')
    <div class="bg-gray-200 p-4">
        <div class="mb-4">
            <h2 class="text-xl font-bold">Your Attendance for {{ $classroom->name }}</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr class="border border-black">
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="border border-black">
                    @foreach($attendances as $attendance)
                    @if ($attendance->student_id === auth()->user()->id)

                    <tr class="border border-black">
                        <td class="border px-4 py-2 border-black">{{ $attendance->date->format('d-m-Y') }}</td>
                        <td class="border px-4 py-2 border-black {{ $attendance->status?'bg-green-500':'bg-red-500' }}">{{ $attendance->status?'Present':'Absent' }}</td>
                    </tr>


                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</body>

</html>