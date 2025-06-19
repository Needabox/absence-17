@extends('admin.layouts.app')
@section('content')
<div class="p-4 sm:ml-64 dark:bg-gray-900 bg-white">
    <div class="flex items-center justify-between mt-16">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Students</h1>
        <a href="{{ route('students.create') }}"
            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add Student
        </a>
    </div>

    <div class="p-4 border border-gray-200 rounded-lg dark:border-gray-700 dark:bg-gray-900 bg-white mt-3">
        <table id="selection-table">
            <thead>
                <tr>
                    <th> <span class="flex items-center">
                            Name
                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span></th>
                    <th> <span class="flex items-center">
                            NIS
                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span></th>
                    <th> <span class="flex items-center">
                            NISN
                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span></th>
                    <th> <span class="flex items-center">
                            Gender
                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span></th>
                    <th> <span class="flex items-center">
                            Major
                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span></th>
                    <th> <span class="flex items-center">
                            Status
                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span></th>
                    <th> <span class="flex items-center">
                            Created at
                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->nis }}</td>
                    <td>{{ $student->nisn ?? '-' }}</td>
                    <td>{{ $student->gender == 0 ? 'Male' : 'Female' }}</td>
                    <td>{{ $student->major->name }}</td>
                    <td>
                        @if ($student->status)
                        <span class="text-green-500">Active</span>
                        @else
                        <span class="text-red-500">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $student->created_at }}</td>
                    <td>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('students.edit', $student->id) }}"
                                class="text-blue-700 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="deleteConfirmation(event, this)"
                                    class="text-red-700 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteConfirmation(event, button) {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "This student will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: "#3085d6",
            cancelButtonText: 'Cancel',
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
            confirmButtonText: 'OK'
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
            confirmButtonText: 'OK'
        });
    });
</script>
@endif
@endpush