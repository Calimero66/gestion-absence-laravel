<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absence Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Absence Details</h3>
                    <ul class="list-disc pl-6">
                        <li><strong>Date:</strong> {{ $absence->date }}</li>
                        <li><strong>Session:</strong> {{ $absence->session }}</li>
                        <li><strong>Justification:</strong> {{ $absence->justification ?? 'N/A' }}</li>
                        <li><strong>Penalty:</strong> 
                            {{ $absence->penalty ? number_format($absence->penalty, 2) . ' points' : 'N/A' }}
                        </li>
                        <li><strong>Status:</strong> 
                            <span class="px-2 py-1 text-sm rounded-full
                                {{ $absence->status === 'pending' ? 'bg-yellow-200' : '' }}
                                {{ $absence->status === 'approved' ? 'bg-green-200' : '' }}
                                {{ $absence->status === 'rejected' ? 'bg-red-200' : '' }}">
                                {{ ucfirst($absence->status) }}
                            </span>
                        </li>
                        @if(auth()->user()->role === 'teacher')
                            <li><strong>Student:</strong> {{ $absence->user->name }}</li>
                            <li><strong>Student Email:</strong> 
                                <a href="mailto:{{ $absence->user->email }}" class="text-blue-500 hover:underline">
                                    {{ $absence->user->email }}
                                </a>
                            </li>
                        @endif
                    </ul>

                    <div class="mt-6">
                        <a href="{{ route('absences.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Back to List
                        </a>
                        
                        @can('update', $absence)
                            <a href="{{ route('absences.edit', $absence->id) }}" class="bg-green-500 text-white px-4 py-2 rounded ml-2">
                                Edit
                            </a>
                        @endcan

                        @can('delete', $absence)
                            <form action="{{ route('absences.destroy', $absence->id) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded"
                                    onclick="return confirm('Are you sure you want to delete this absence?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
