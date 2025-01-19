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

                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Session</th>
                                <th class="px-4 py-2 border">Justification</th>
                                <th class="px-4 py-2 border">Penalty</th>
                                <th class="px-4 py-2 border">Status</th>
                                @if (auth()->user()->role === 'teacher')
                                    <th class="px-4 py-2 border">Student</th>
                                @endif
                                <th class="px-4 py-2 border">Teacher</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absences as $absence)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $absence->date }}</td>
                                    <td class="px-4 py-2 border">{{ $absence->session }}</td>
                                    <td class="px-4 py-2 border">{{ $absence->justification ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">{{ $absence->penalty }}</td>
                                    <td class="px-4 py-2 border">
                                        <span class="px-2 py-1 text-sm rounded-full
                                                    {{ $absence->status === 'pending' ? 'bg-yellow-200' : '' }}
                                                    {{ $absence->status === 'approved' ? 'bg-green-200' : '' }}
                                                    {{ $absence->status === 'rejected' ? 'bg-red-200' : '' }}">
                                            {{ ucfirst($absence->status) }}
                                        </span>
                                    </td>
                                    @if (auth()->user()->role === 'teacher')
                                        <td class="px-4 py-2 border">{{ $absence->user->name }}</td>
                                    @endif
                                    <td class="px-4 py-2 border">
                                        {{ $absence->teacher ? $absence->teacher->name : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('absences.show', $absence->id) }}" class="text-blue-600">View</a>

                                        @can('update', $absence)
                                            | <a href="{{ route('absences.edit', $absence->id) }}"
                                                class="text-green-600">Edit</a>
                                        @endcan

                                        @can('delete', $absence)
                                            | <form action="{{ route('absences.destroy', $absence->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline"
                                                    onclick="return confirm('Are you sure you want to delete this absence?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan

                                        @if (auth()->user()->role === 'teacher')
                                            | <a href="mailto:{{ $absence->user->email }}"
                                                class="text-purple-600 hover:underline">Contact</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if (auth()->user()->role === 'teacher')
                        <div class="mt-4">
                            <a href="{{ route('absences.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add
                                New Absence</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>