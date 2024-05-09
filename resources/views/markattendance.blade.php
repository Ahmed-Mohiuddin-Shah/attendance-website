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

    <div class="bg-gray-800 p-4 text-white flex justify-between">
        <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->role }}!</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="submit" value="Logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>

    <!-- Mark Atendance-->
    @if(auth()->user()->role === 'teacher')
    <div class="bg-gray-200 p-4">
        <div class="mb-4">
            <h2 class="text-xl font-bold">Mark Attendance</h2>
            <h2 class="text-xl font-bold">Class: {{ $classroom->name }}</h2>
            <h2 class="text-xl font-bold">Date: {{ date('d-m-Y') }}</h2>
            <hr class="my-4">
            <form method="POST" action="{{ route('mark-attendance') }}">
                @csrf
                <table class="table-auto border-collapse">
                    <thead>
                        <tr class="border border-black">
                            <th class="px-4 py-2">Student ID</th>
                            <th class="px-4 py-2">Student Name</th>
                            <th class="px-4 py-2">Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        @if($student->role === 'student')
                        <tr class="border border-black">
                            <td class="border border-black px-4 py-2">{{ $student->id }}</td>
                            <td class="border border-black px-4 py-2">{{ $student->fullname }}</td>
                            <td class="border border-black px-4 py-2">
                                <input type="checkbox" name="student_{{ $student->id }}" value="{{ $student->id }}" checked class="form-checkbox h-5 w-5 text-green-600">

                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr class="my-4">
                <input type="hidden" name="class_id" value="{{ $classroom->id }}">
                <input type="submit" value="Mark Attendance" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </form>
        </div>
    </div>
    @endif

</body>

</html>