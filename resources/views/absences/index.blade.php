<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absences') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg">List of Absences</h3>

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Reason</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Student</th>
                                <th class="px-4 py-2">Teacher</th> <!-- Added Teacher Column -->
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absences as $absence)
                                <tr>
                                    <td class="px-4 py-2">{{ $absence->date }}</td>
                                    <td class="px-4 py-2">{{ $absence->reason }}</td>
                                    <td class="px-4 py-2">{{ $absence->type }}</td>
                                    <td class="px-4 py-2">{{ $absence->user->name }}</td> <!-- Student's name -->
                                    <td class="px-4 py-2">
                                        {{ $absence->teacher ? $absence->teacher->name : 'N/A' }}
                                    </td> <!-- Teacher's name -->
                                    <td class="px-4 py-2">
                                        <a href="{{ route('absences.show', $absence->id) }}" class="text-blue-600">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('absences.create') }}" class="text-blue-600">Add New Absence</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>