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

<div class="mt-9 bg-white shadow-xl divide-y border rounded">
    <table class="min-w-full divide-y divide-gray-200 overflow-x-auto">
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
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($students as $student)
                <tr wire:key="{{ $student->id }}">
                    <td class="ph-6 py-4">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $student->name }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="ph-6 py-4">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $student->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="ph-6 py-4">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $student->bio }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
