@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Create New User</h2>

        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label for="email" class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label for="password" class="block mb-1 font-semibold">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 font-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div class="flex items-center space-x-2">
                <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                <label for="is_admin" class="font-semibold">Admin</label>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create User
            </button>
        </form>
    </div>
</div>
@endsection