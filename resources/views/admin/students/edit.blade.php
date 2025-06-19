@extends('admin.layouts.app')
@section('content')
<div class="p-4 sm:ml-64 dark:bg-gray-900 bg-white">
    <div class="flex items-center mt-16">
        <a href="{{ route('students.index') }}" class="p-2 rounded-lg border border-gray-300 shadow-sm dark:border-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-5 text-gray-700 dark:text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>

        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white ml-5">Edit Student</h1>
    </div>

    <div class="p-4 border border-gray-200 rounded-lg dark:border-gray-700 dark:bg-gray-900 bg-white mt-3">
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                </div>

                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                    <select id="gender" name="gender"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="">-- Select Gender --</option>
                        <option value="0" {{ $student->gender == 0 ? 'selected' : '' }}>Male</option>
                        <option value="1" {{ $student->gender == 1 ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div>
                    <label for="nis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIS</label>
                    <input type="number" id="nis" name="nis" value="{{ old('nis', $student->nis) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                </div>

                <div>
                    <label for="nisn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NISN</label>
                    <input type="number" id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <div>
                    <label for="major_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Major</label>
                    <select id="major_id" name="major_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="">-- Select Major --</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ $student->major_id == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="status" name="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="1" {{ $student->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $student->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 
                font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center 
                dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Update
            </button>
        </form>
    </div>
</div>
@endsection
