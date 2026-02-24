@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Borrowing Records</h2>
            <a href="{{ route('borrows.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Issue New Book
            </a>
        </div>

        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Member
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                            Book</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                            Due Date</th>
                        <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                    @forelse($records as $record)
                        <tr
                            class="{{ !$record->returned_at && $record->due_date->isPast() ? 'bg-red-50 dark:bg-red-900/10' : '' }}">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $record->member->name ?? 'Unknown Member' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $record->book->title ?? 'Book Deleted' }}
                                @if($record->book && $record->book->trashed())
                                    <span class="text-xs text-red-500 font-semibold ml-1">(OUT OF CATALOG)</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <span
                                    class="{{ !$record->returned_at && $record->due_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                    {{ $record->due_date->format('d M, Y') }}
                                </span>
                                @if(!$record->returned_at && $record->due_date->isPast())
                                    <br><span
                                        class="text-[10px] text-red-600 font-black tracking-tighter uppercase whitespace-nowrap">⚠️
                                        OVERDUE</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium">
                                @if(!$record->returned_at)
                                    <form action="{{ route('borrows.update', $record->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">Mark
                                            Returned</button>
                                    </form>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        ✓ Returned ({{ $record->returned_at->format('d M') }})
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                No borrowing history found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection