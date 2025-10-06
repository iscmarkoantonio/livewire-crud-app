<div class="p-4">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Project Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create and manage your projects.') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- button section --}}
    <div class="text-end mb-4">


        <flux:modal.trigger name="project-modal">
            <flux:button wire:click="$dispatch('open-project-modal', { mode: 'create' })" variant="primary"
                color="indigo" icon="plus-circle" class="cursor-pointer">Add Project
            </flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Render form component --}}
    <livewire:projects.form-modal />
    <livewire:common.delete-confirmation />


    {{-- Flash message component --}}
    <div x-data="{ show: false, message: '', type: '' }" x-init="window.addEventListener('flash', e => {
        const data = e.detail[0];
        message = data.message;
        type = data.type;
        show = true;
        settimeout(() => show = false, 4000);
    
    });" x-show="show" x-transition
        class="fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white z-50"
        :class="{
            'bg-emerald-600': type === 'success',
            'bg-red-600': type === 'error',
        }"
        style="display: none;">

        <span x-text="message"></span>

    </div>

    {{-- Table for listing --}}
    <div class="overflow-x-auto border rounded-xl shadow-md">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold border-b">
                <tr>
                    <th class="py-4">#</th>
                    <th class="py-4">Name</th>
                    <th class="py-4">Description</th>
                    <th class="py-4">Status</th>
                    <th class="py-4">Deadline</th>
                    <th class="px-13 py-4">Logo</th>
                    <th class="py-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($projects as $project)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4">{{ $loop->index + 1 }}</td>
                        <td class="py-4">{{ $project->name }}</td>
                        <td class="py-4">{{ $project->description }}</td>
                        <td class="py-4 capitalize">

                            @php
                                $statusColor = match ($project->status) {
                                    'pending' => 'bg-yellow-300 text-yellow-800 border border-yellow-500',
                                    'in-progress' => 'bg-blue-300 text-blue-800 border border-blue-500',
                                    'completed' => 'bg-green-300 text-green-800 border border-green-500',
                                    'cancelled' => 'bg-red-300 text-red-800 border border-red-500',
                                };
                            @endphp

                            <span class="px-3 py-1 rounded shadow-sm {{ $statusColor }}">{{ $project->status }}</span>

                        </td>
                        <td class="py-4">{{ $project->deadline }}</td>
                        <td class="py-4">
                            @if ($project->project_logo)
                                <img src="{{ asset('storage/' . $project->project_logo) }}" alt="Project logo"
                                    class="h-18 w-32 rounded border" />
                            @endif
                        </td>

                        {{-- Actions --}}

                        <td class="py-4">

                            {{-- Project Modal --}}
                            <flux:modal.trigger name="project-modal">

                                {{-- View --}}
                                <flux:button
                                    wire:click="$dispatch('open-project-modal', { mode: 'view', project: {{ $project }} })"
                                    class="cursor-pointer" variant="primary" color="sky" icon="eye"
                                    class="cursor-pointer">
                                </flux:button>

                                {{-- Edit --}}
                                <flux:button
                                    wire:click="$dispatch('open-project-modal', { mode: 'edit', project: {{ $project }} })"
                                    class="cursor-pointer mx-1" variant="primary" color="blue" icon="pencil"
                                    class="cursor-pointer">
                                </flux:button>

                            </flux:modal.trigger>

                            {{-- Delete --}}

                            <flux:modal.trigger name="delete-confirmation-modal">
                                <flux:button
                                    wire:click="$dispatch('confirm-delete', {
                                    id: {{ $project->id }}, 
                                    dispatchAction: 'delete-project',
                                    modalName: 'delete-confirmation-modal',
                                    heading: 'Delete Project?',
                                    subheading: 'You are about to delete this project: <strong> {{ $project->name }} </trong>. <br/> This action cannot be undone.',
                                    confirmButtonText: 'Delete Project', 

                                    })"
                                    class="cursor-pointer" variant="primary" color="red" icon="trash"
                                    class="cursor-pointer">
                                </flux:button>
                            </flux:modal.trigger>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center">
                            <flux:text class="flex items-center justify-center text-red-500">
                                <flux:icon.exclamation-triangle class="mr-2" /> No projects found!
                            </flux:text>
                        </td>
                    </tr>
                @endforelse



            </tbody>
        </table>
    </div>


    {{-- Pagination --}}
    <div class="mt-4">
        {{ $projects->links() }}
    </div>




</div>
