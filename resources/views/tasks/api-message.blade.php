<x-guest-layout>

    <div class="flex justify-center px-4 py-2">
        {{ session('message') }}
    </div>
    <div class="flex justify-center mt-6 mt-6">
        <a href="{{ session('link') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
        {{ session('button-text') }}
        </a>
    </div>

</x-guest-layout>