@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Dashboard</h2>
        <hr>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Books</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Book::count() }}</p>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-xl shadow-sm border border-green-100 dark:border-green-800/30">
                <h3 class="text-sm font-medium text-green-600 dark:text-green-400 uppercase tracking-wider">Active Members</h3>
                <p class="mt-2 text-3xl font-bold text-green-700 dark:text-green-300">{{ \App\Models\member::where('is_active', true)->count() }}</p>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-6 rounded-xl shadow-sm border border-yellow-100 dark:border-yellow-800/30">
                <h3 class="text-sm font-medium text-yellow-600 dark:text-yellow-400 uppercase tracking-wider">Books Borrowed</h3>
                <p class="mt-2 text-3xl font-bold text-yellow-700 dark:text-yellow-300">{{ \App\Models\BorrowRecord::whereNull('returned_at')->count() }}</p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-3">Quick Actions</h3>
            <div class="flex gap-4">
                <a href="{{ route('borrows.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Issue New Book
                </a>
                <a href="{{ route('members.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Add New Member
                </a>
            </div>
        </div>

        @php
            $overdueBooks = \App\Models\BorrowRecord::whereNull('returned_at')
                ->where('due_date', '<', now())
                ->with(['member', 'book'])
                ->get();
        @endphp

        <div class="mt-10">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Overdue Books ({{ $overdueBooks->count() }})</h3>
            @if($overdueBooks->isNotEmpty())
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Member</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Book</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Due Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                            @foreach($overdueBooks as $record)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white">{{ $record->member->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $record->book->title }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-red-600 font-medium">{{ $record->due_date->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 rounded-md">
                    <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">No overdue books. Great job!</p>
                </div>
            @endif
        </div>
    </div>
@endsection