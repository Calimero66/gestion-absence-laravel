<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Absence') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Add a New Absence</h3>

                    <form action="{{ route('absences.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 font-medium">Date</label>
                            <input type="date" id="date" name="date" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="reason" class="block text-gray-700 font-medium">Reason</label>
                            <textarea id="reason" name="reason" rows="4" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="block text-gray-700 font-medium">Type</label>
                            <select id="type" name="type" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                <option value="sick">Sick</option>
                                <option value="vacation">Vacation</option>
                                <option value="personal">Personal</option>
                            </select>
                        </div>

                        <!-- Select Student -->
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700 font-medium">Student</label>
                            <select id="user_id" name="user_id" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                <option value="">Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>