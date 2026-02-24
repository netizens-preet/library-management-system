@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Edit Book</h2>

            <form action="{{ route('books.update', $book->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="title" :value="__('Book Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $book->title)" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="author_id" :value="__('Author')" />
                    <select name="author_id" id="author_id"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        required>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ (old('author_id', $book->author_id) == $author->id) ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('author_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="available_copies" :value="__('Available Copies')" />
                    <x-text-input id="available_copies" class="block mt-1 w-full" type="number" name="available_copies"
                        :value="old('available_copies', $book->available_copies)" required />
                    <x-input-error :messages="$errors->get('available_copies')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-8">
                    <a href="{{ route('books.index') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 border-b border-transparent hover:border-gray-900">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Update Book') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection