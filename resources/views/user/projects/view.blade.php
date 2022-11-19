<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td><x-label for="name" :value="__('Project Name')" /></td>
                                        <td>{{ $project->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Assigned By')" /></td>
                                        <td>{{ ucfirst(optional($project->assignBy)->name) }}</td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Project Details')" /></td>
                                        <td>{{ $project->project_details }}</td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Project CreatedOn')" /></td>
                                        <td>{{ $project->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Project Duration(In Hours)')" /></td>
                                        <td>{{ $project->duration }} Hours</td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Project Start Date')" /></td>
                                        <td>{{ $project->start_date }}</td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Project Status')" /></td>
                                        <td>{{ ucfirst($project->status) }}</td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Total Work by team')" /></td>
                                        <td>
                                        <?php $duration = 0; 
                                        foreach($project->workreports as $workreport):
                                            $duration += $workreport->duration;
                                        endforeach; ?>
                                        {{ (int)($duration / 3600) }} Hours  {{ (int)(($duration % 3600) / 60) }} Minutes
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><x-label for="name" :value="__('Developers Work on this project')" /></td>
                                        <td>
                                        <?php $assignTo = []; ?>
                                        @foreach($project->assignTo as $users)
                                        <?php $assignTo[] = ucfirst($users->name); ?>
                                        @endforeach

                                        {{ implode(',',$assignTo) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Developer</th>
                                        <th>Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($project->assignTo as $users)
                                    <tr>
                                        <td>{{ ucfirst($users->name) }}</td>
                                        <td>
                                        <?php $duration = 0; 
                                        foreach($project->workreports as $workreport):
                                            if($workreport->user_id == $users->id):
                                                $duration += $workreport->duration;
                                            endif;
                                        endforeach; ?>
                                        {{ (int)($duration / 3600) }} Hours  {{ (int)(($duration % 3600) / 60) }} Minutes
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
