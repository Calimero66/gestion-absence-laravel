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
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

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
                                    <td class="px-4 py-2 border">
                                        @if ($absence->justification)
                                            <a href="{{ route('absences.download', $absence->id) }}"
                                                class="inline-flex items-center px-3 py-1 text-sm text-blue-600 hover:text-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Download
                                            </a>
                                        @else
                                            @if (auth()->user()->role === 'student' && auth()->id() === $absence->user_id)
                                                <form action="{{ route('absences.update', $absence->id) }}" method="POST"
                                                    enctype="multipart/form-data" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="file" name="justification" accept=".pdf,.jpg,.jpeg,.png"
                                                        class="text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                    <button type="submit"
                                                        class="px-3 py-1 text-sm text-white bg-green-600 rounded hover:bg-green-700 transition-colors">
                                                        Upload
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">{{ $absence->penalty }}</td>
                                    <td class="px-4 py-2 border">
                                        <span class="px-2 py-1 text-sm rounded-full
                                                {{ $absence->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                                {{ $absence->status === 'approved' ? 'bg-green-200 text-green-800' : '' }}
                                                {{ $absence->status === 'rejected' ? 'bg-red-200 text-red-800' : '' }}">
                                            {{ ucfirst($absence->status) }}
                                        </span>
                                    </td>
                                    @if (auth()->user()->role === 'teacher')
                                        <td class="px-4 py-2 border">{{ $absence->user->name }}</td>
                                    @endif
                                    <td class="px-4 py-2 border">
                                        {{ $absence->teacher ? $absence->teacher->name : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <a href="{{ route('absences.show', $absence->id) }}"
                                            class="inline-block px-2 py-1 text-sm text-blue-600 hover:text-blue-800">View</a>

                                        @can('update', $absence)
                                            <a href="{{ route('absences.edit', $absence->id) }}"
                                                class="inline-block px-2 py-1 text-sm text-green-600 hover:text-green-800">Edit</a>
                                        @endcan

                                        @can('delete', $absence)
                                            <form action="{{ route('absences.destroy', $absence->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 text-sm text-red-600 hover:text-red-800"
                                                    onclick="return confirm('Are you sure you want to delete this absence?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan

                                        @if (auth()->user()->role === 'teacher')
                                            <a href="mailto:{{ $absence->user->email }}"
                                                class="inline-block px-2 py-1 text-sm text-purple-600 hover:text-purple-800">Contact</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if (auth()->user()->role === 'teacher')
                        <div class="mt-4">
                            <a href="{{ route('absences.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add New Absence
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>