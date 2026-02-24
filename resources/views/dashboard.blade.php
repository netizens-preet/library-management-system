<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(auth()->user()->role === 'author')
                    <h3 class="text-lg font-bold">Author Management Console</h3>
                    <p>Welcome, Author! Here you can manage your library catalog.</p>
                    <div class="mt-4 flex gap-4">
                        <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Book</a>
                        <a href="{{ route('authors.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Add New Author</a>
                    </div>
                @else
                    <h3 class="text-lg font-bold">Member Library</h3>
                    <p>Welcome, Member! Browse the catalog and borrow your favorite books.</p>
                    <div class="mt-4">
                        <a href="{{ route('books.index') }}" class="bg-indigo-500 text-white px-4 py-2 rounded">Browse Catalog</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
