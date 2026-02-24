@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Add New Book</h2>

            <form action="{{ route('books.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="published_year" :value="__('Published Year')" />
                    <x-text-input id="published_year" class="block mt-1 w-full" type="number" name="published_year"
                        required />
                    <x-input-error :messages="$errors->get('published_year')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="author_id" :value="__('Author')" />
                    <div class="flex gap-2">
                        <select name="author_id" id="author_select"
                            class="flex-1 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                            required>
                            <option value="">-- Select Author --</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-secondary-button type="button" onclick="toggleAuthorModal(true)">
                            + New
                        </x-secondary-button>
                    </div>
                    <x-input-error :messages="$errors->get('author_id')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="total_copies" :value="__('Total Copies')" />
                        <x-text-input id="total_copies" class="block mt-1 w-full" type="number" name="total_copies"
                            value="1" min="1" required />
                    </div>
                    <div>
                        <x-input-label for="available_copies" :value="__('Available Copies')" />
                        <x-text-input id="available_copies" class="block mt-1 w-full" type="number" name="available_copies"
                            value="1" min="0" required />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 mt-8">
                    <a href="{{ route('books.index') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 border-b border-transparent hover:border-gray-900">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Save Book') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <div id="authorModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-500/75 backdrop-blur-sm">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden w-full max-w-md transform transition-all">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Add Author</h3>

                <form action="{{ route('authors.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="from_book_create" value="1">

                    <div>
                        <x-input-label for="modal_name" :value="__('Full Name')" />
                        <x-text-input id="modal_name" class="block mt-1 w-full" type="text" name="name" required />
                    </div>

                    <div>
                        <x-input-label for="modal_email" :value="__('Email Address')" />
                        <x-text-input id="modal_email" class="block mt-1 w-full" type="email" name="email" required />
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <x-secondary-button type="button" onclick="toggleAuthorModal(false)">
                            Cancel
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Save Author') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleAuthorModal(show) {
            const modal = document.getElementById('authorModal');
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
@endsection