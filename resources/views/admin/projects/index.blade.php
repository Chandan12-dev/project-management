<x-app-layout>
    <x-slot name="header">
        <div class="inner-navigation">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Projects') }}
            </h2>
            <div class="right-links">
            <x-nav-button :href="route('projectCategory')" class="navigation-btn">
                {{ __('Category') }}
            </x-nav-button>
            <x-nav-button :href="route('createProjectForm')" class="navigation-btn">
                {{ __('Create Project') }}
            </x-nav-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Status -->
            <x-success-status class="mb-4" :status="session('message')" />
            <!-- Validation Errors -->
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table table-bordered table-hover ">
                        <thead class="thead-dark table-striped">
                            <th>Id</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>AssignBy</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                               <td>{{ $project->id }}</td>
                               <td>{{ $project->start_date }}</td>
                               <td>{{ $project->name }}</td>
                               <td>{{ optional($project->category)->name }}</td>
                               <td>{{ optional($project->assignBy)->name }}</td>
                               <td>{{ $project->status }}</td>
                               <td>
                                    <div class="flex align-items-center">
                                        <a href="{{route('updateProjectForm',$project->id)}}" class="navigation-btn btn btn-success mr-2">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <x-delete-buttons :action="route('deleterProject',$project->id)" />
                                    </div>
                               </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
