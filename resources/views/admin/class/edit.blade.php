@extends('admin.layouts.app')

@section('content')
<div class="p-4 sm:ml-64 dark:bg-gray-900 bg-white">

    <div class="flex items-center mt-16 mb-6">
        <a href="{{ route('class.index') }}"
            class="flex items-center gap-1 p-2 rounded-lg border border-gray-300 shadow-sm dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700 dark:text-white" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white ml-5">Edit Class</h1>
    </div>

    <div class="p-4 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg">
        <form action="{{ route('class.update', $class->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2 mb-8">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Class Name</label>
                    <input type="text" name="name" required value="{{ old('name', $class->name) }}"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                </div>

                 <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Major</label>
                    <select name="major_id" required
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Major</option>
                        @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ old('major_id', $class->major_id) == $major->id ? 'selected' : '' }}>
                            {{ $major->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Homeroom Teacher</label>
                    <select name="homeroom_teacher_id" required
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Homeroom Teacher</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id', $class->homeroom_teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                    <select name="semester" required
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Semester</option>
                        <option value="1" {{ old('semester', $class->semester) == '1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ old('semester', $class->semester) == '2' ? 'selected' : '' }}>Semester 2</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year</label>
                    <select id="year" name="year" required
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Class Chief</label>
                    <input type="text" name="class_chief" required value="{{ old('class_chief', $class->class_chief) }}"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select name="status" required
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" {{ old('status', $class->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $class->status) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                Update
            </button>
        </form>
    </div>

    <div class="p-4 bg-white dark:bg-gray-900 mt-8 border border-gray-200 dark:border-gray-700 rounded-lg">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Students</h2>
            <div class="gap-5">
             <button type="button" data-modal-target="import-form" data-modal-toggle="import-form"
                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 font-bold rounded">
                import
            </button>
             <button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 font-bold rounded">
                Add Student
            </button>
            </div>
          
        </div>

        <div class="p-4 border border-gray-200 rounded-lg dark:border-gray-700 dark:bg-gray-900 bg-white mt-3">
            <table id="selection-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Major</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classStudents as $cs)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                        <td class="px-4 py-2">{{ $cs->student->name }}</td>
                        <td class="px-4 py-2">
                            {{ $cs->student->gender == 0 ? 'Male' : 'Female' }}
                        </td>
                        <td>{{ $cs->student->major->name ?? '-' }}</td>
                        <td>{{ $cs->student->nis }}</td>
                        <td>{{ $cs->student->nisn ?? '-' }}</td>
                        <td>

                            <form action="{{ route('class-student.destroy', [$class->id, $cs->student_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="deleteConfirmation(event, this)"
                                    class="text-red-700 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    <!-- Delete Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="import-form" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Import Students</h3>

       <form action="{{ route('import.student-class') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="major_id" value="{{ old('major_id', $class->major_id) }}">
    <input type="hidden" name="class_id" value="{{ old('class_id', $class->id) }}">

    <input type="file" name="file" required class="block w-full">
    
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 mt-2 rounded">
        Import
    </button>
</form>


    </div>
</div>



<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Add Student to Class</h3>
        <form action="{{ route('class-student.store') }}" method="POST">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class->id }}">
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose Student</label>
                <select name="student_id" id="student_id" class="w-full bg-gray-50 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-lg" required>
                    <option value="">Select Student</option>
                    @foreach ($students as $student)
                    @if (!$classStudents->contains('student_id', $student->id))
                    <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->nis }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" data-modal-hide="crud-modal"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectYear = document.getElementById('year');
        const selectedYear = "{{ old('year', $class->year) }}";
        const current = new Date().getFullYear();
        for (let yr = current + 1; yr >= current - 5; yr--) {
            const option = document.createElement('option');
            option.value = yr;
            option.text = yr;
            if (yr == selectedYear) option.selected = true;
            selectYear.appendChild(option);
        }

        // Init Select2
        $('#student_id').select2({
            dropdownParent: $('#crud-modal'),
            width: '100%',
            placeholder: "-- Select Student --",
            allowClear: true
        });
    });
</script>

@push('scripts')
<script>
    function deleteConfirmation(event, button) {
        event.preventDefault(); // Mencegah submit langsung

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: "#3085d6",
            cancelButtonText: 'No, cancel!',
            cancelButtonColor: "#d33",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success!',
            text: '{{ session('
            success ') }}',
            icon: 'success',
            confirmButtonText: 'Okay'
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Error!',
            text: '{{ session('
            error ') }}',
            icon: 'error',
            confirmButtonText: 'Okay'
        });
    });
</script>
@endif
@endpush


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection