@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Issue New Book</h2>

            <form action="{{ route('borrows.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Member -->
                <div>
                    <x-input-label for="member_id" :value="__('Member')" />
                    <select name="member_id" id="member_id"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        required>
                        <option value="">-- Select Member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                </div>

                <!-- Book -->
                <div>
                    <x-input-label for="book_id" :value="__('Book')" />
                    <select name="book_id" id="book_id"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        required>
                        <option value="">-- Select Book --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_copies }} available)
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('book_id')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-8">
                    <a href="{{ route('borrows.index') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 border-b border-transparent hover:border-gray-900">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Confirm Borrow') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection