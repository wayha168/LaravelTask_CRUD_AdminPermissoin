@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit User</h2>

        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2 border rounded @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-3 py-2 border rounded @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold">New Password (leave blank to keep)</label>
                <input type="password" name="password"
                    class="w-full px-3 py-2 border rounded @error('password') border-red-500 @enderror">
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-3 py-2 border rounded">
            </div>

            <div class="flex items-center space-x-2">
                <input type="checkbox" name="is_admin" value="1" id="is_admin" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                <label for="is_admin" class="font-semibold">Admin</label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded hover:bg-green-700">
                    Update User
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 text-center bg-gray-300 py-2 rounded hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection