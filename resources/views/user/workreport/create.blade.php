<x-app-layout>
    <x-slot name="header">
        <div class="inner-navigation">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Todays Work Report') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('WorkReportCreate') }}" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        <!-- Name -->
                        <div class="row">
                        <div class="mt-2 col-md-12">
                            <x-label for="project_id" :value="__('Project')" />
                            <select id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full select2-simple" name="project_id" required>
                                <option value="">Select a Project</option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Start Time -->
                        <div class="mt-2 col-md-6">
                            <x-label for="start_time" :value="__('Start Time')" />
                            <div class="relative cs-form">
                                <x-input type="text" name="start_time" class="block mt-1 w-full" placeholder="Select Start time" onfocus="this.type = 'time'" onblur="this.type = 'text'" required />
                            </div> 
                        </div>
                        <!-- End Date -->
                        <div class="mt-2 col-md-6">
                            <x-label for="end_time" :value="__('End Time')" />
                            <div class="relative">
                                <x-input type="time" name="end_time" class="block mt-1 w-full" placeholder="Select End date" required />
                            </div>
                        </div>
                        <!-- Comments -->
                        <div class="mt-2 col-md-12">
                            <x-label for="comments" :value="__('Comments')" />
                            <textarea id="comments" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" rows="6" type="text" name="comments" autocomplete="off" required></textarea>
                        </div>
                        </div>
                        <div class="flex items-center justify-end mt-2">
                            <x-button class="ml-4">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('.select2-simple').select2({
            placeholder: "Select a Project",
            allowClear: true
        });
    });
</script>