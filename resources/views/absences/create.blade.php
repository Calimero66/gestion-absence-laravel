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

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 font-medium">Date</label>
                            <input type="date" id="date" name="date" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        </div>

                        <!-- Session -->
                        <div class="mb-4">
                            <label for="session" class="block text-gray-700 font-medium">Session</label>
                            <input type="text" id="session" name="session" placeholder="Enter session details" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        </div>

                        <!-- Justification -->
                        <div class="mb-4">
                            <label for="justification" class="block text-gray-700 font-medium">Justification</label>
                            <textarea id="justification" name="justification" rows="4"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"></textarea>
                        </div>

                        <!-- Penalty -->
                        <div class="mb-4">
                            <label for="penalty" class="block text-gray-700 font-medium">Penalty</label>
                            <input type="number" id="penalty" name="penalty" step="0.01" placeholder="Enter penalty amount"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 font-medium">Status</label>
                            <select id="status" name="status" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
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

                        <!-- Submit Button -->
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
