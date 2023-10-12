<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Upload Your CSV File Here') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                    <div class="text-sm text-green-600">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="text-sm text-red-600">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">
                                <input type="file" name="csv" class="block w-full text-sm text-gray-500 p-2 rounded-full border-0 text-sm font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100" multiple />
                            </label>
                            @error('csv')
                            <div class="text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Add "justify-end" class to align the button to the right -->
                        <div class="flex justify-end">
                            <x-primary-button class="ml-3">
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
