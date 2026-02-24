@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Edit Borrowing Record</h2>

            <div class="mb-6 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-gray-500 dark:text-gray-400">Member:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $borrow->member->name }}</span>
                </div>
                <div>
                    <span class="block text-gray-500 dark:text-gray-400">Book:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $borrow->book->title }}</span>
                </div>
            </div>

            <form action="{{ route('borrows.update', $borrow->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Due Date -->
                <div>
                    <x-input-label for="due_date" :value="__('Adjust Due Date')" />
                    <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date"
                        :value="old('due_date', $borrow->due_date->format('Y-m-d'))" required />
                    <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-8">
                    <a href="{{ route('borrows.index') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 border-b border-transparent hover:border-gray-900">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Update Due Date') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection