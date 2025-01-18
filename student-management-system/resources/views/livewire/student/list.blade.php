<?php

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $students;

    public function mount(): void
    {
        $this->students = Student::latest()->get(['name','email','bio']);
    }
}; ?>

<div class="mt-9 bg-blue shadow-sm rounded-ld divide-y">
    <table class="min-w-full divide-y divide-dray-200 overflow-x-auto">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                Name
                </th>
                <th scope="col"
                class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                Email
                </th>
                <th scope="col"
                class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                Bio
                </th>
            </tr>
        </thead>
    </table>
    <!--@foreach ($students as $student)
        <div class="p-6 flex space-x-2" wire:key="{{ $student->id }}">
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-800">{{ $student->name }}</span>
                        <span class="text-gray-800">{{ $student->email }}</span>
                        <span class="text-gray-800">{{ $student->bio }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach-->
</div>
