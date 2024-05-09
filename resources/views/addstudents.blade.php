<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students To Class</title>

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

    <!-- Teacher Dashboard -->
    @if(auth()->user()->role === 'teacher')
    <div class="bg-gray-200 p-4">
        <div class="mb-4">
            <h2 class="text-xl font-bold">Add Students to Class</h2>
            <hr class="my-4">
            <form method="POST" action="{{ route('add-students') }}">
                @csrf
                <table class="table-auto border-collapse">
                    <thead>
                        <tr class="border border-black">
                            <th class="px-4 py-2">Student ID</th>
                            <th class="px-4 py-2">Student Name</th>
                            <th class="px-4 py-2">Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        @if($student->role === 'student')
                        <tr class="border border-black">
                            <td class="border border-black px-4 py-2">{{ $student->id }}</td>
                            <td class="border border-black px-4 py-2">{{ $student->fullname }}</td>
                            <td class="border border-black px-4 py-2">
                                @if($students_in_class->contains($student->id))
                                <input type="checkbox" name="student_{{ $student->id }}" value="{{ $student->id }}" checked class="form-checkbox h-5 w-5 text-green-600">
                                @else
                                <input type="checkbox" name="student_{{ $student->id }}" value="{{ $student->id }}" class="form-checkbox h-5 w-5 text-green-600" checked>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr class="my-4">
                <input type="hidden" name="class_id" value="{{ $classroom }}">
                <div class="flex items-center justify-between">
                    <input type="submit" value="Add Students" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                </div>
            </form>
        </div>
    </div>
    @endif
</body>

</html>