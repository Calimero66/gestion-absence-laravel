<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absences') }}
        </h2>
    </x-slot> -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Here you can manage your absences.") }}
                    
                    <form action="{{ route('absences.store') }}" method="POST">
                        @csrf

                        <!-- Employee Name -->
                        <div class="mb-4">
                            <label for="employee_name" class="block text-sm font-medium text-gray-700">Employee Name</label>
                            <input type="text" id="employee_name" name="employee_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>

                        <!-- Date of Absence -->
                        <div class="mb-4">
                            <label for="absence_date" class="block text-sm font-medium text-gray-700">Date of Absence</label>
                            <input type="date" id="absence_date" name="absence_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>

                        <!-- Reason for Absence -->
                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Absence</label>
                            <textarea id="reason" name="reason" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit Absence
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
