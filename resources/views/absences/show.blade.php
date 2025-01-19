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
                        <li><strong>Reason:</strong> {{ $absence->reason }}</li>
                        <li><strong>Type:</strong> {{ ucfirst($absence->type) }}</li>
                        <li><strong>Session:</strong> {{ $absence->session }}</li>
                        <li><strong>Justification:</strong> {{ $absence->justification ?? 'N/A' }}</li>
                        <li><strong>Penalty:</strong> {{ $absence->penalty ? 'point' . number_format($absence->penalty, 2) : 'N/A' }}</li>
                        <li><strong>Status:</strong> {{ ucfirst($absence->status) }}</li>
                    </ul>
                    <a href="{{ route('absences.index') }}" class="text-blue-500 hover:underline mt-4 block">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
