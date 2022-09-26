<x-app-layout>
    <x-slot name="header">
        <div class="inner-navigation">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Project Categories ') }}
            </h2>
            <div class="right-links">
            <x-nav-button :href="route('projects')" class="navigation-btn">
                {{ __('Projects') }}
            </x-nav-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mb-2">
            <!-- Session Status -->
            <x-success-status class="mb-4" :status="session('message')" />
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="row">
                @if(request()->routeIs('projectCategory'))
                <div class="p-6 bg-white border-r border-gray-200 col-md-3" >
                    <form method="POST" action="{{ route('createProjectCategory') }}" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        <!-- Name -->
                        <div class="">
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="off" value="" />
                        </div>
                        <!-- Parent Id -->
                        <div class="mt-3">
                            <x-label for="parent_id" :value="__('Parent')" />
                            <select id="parent_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="parent_id">
                                <option value="0">No Parent</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-2">
                            <x-button class="ml-4">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
                @endif
                @if(request()->routeIs('updateProjectCategoryForm'))
                <div class="p-6 bg-white border-r border-gray-200 col-md-3" >
                    <form method="POST" action="{{ route('updateProjectCategory', $category->id) }}" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div class="">
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="off" value="{{ $category->name }}" />
                        </div>
                        <!-- Parent -->
                        <div class="mt-3">
                            <x-label for="parent_id" :value="__('Parent')" />
                            <select id="parent_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="parent_id">
                                <option value="0">No Parent</option>
                                @foreach ($categories as $cat)
                                @if($cat->id != $category->id)
                                <option value="{{ $cat->id }}" {{($category->parent_id == $cat->id)? 'selected' : ''}} >{{ $cat->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-2">
                            <x-nav-button href="javascript:history.back();" class="navigation-btn">
                                {{ __('Cancel') }}
                            </x-nav-button>
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
                @endif
                <div class="p-6 bg-white col-md-9">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark table-striped">
                            <th>Id</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($categories as $categ)
                            <tr>
                                
                               <td>{{ $categ->id }}</td>
                               <td>{{ ucwords($categ->name) }}</td>
                               <td> {{optional($categ->parent)->name}}</td>
                               <td>
                                <div class="flex align-items-center">
                               <a href="{{route('updateProjectCategoryForm',$categ->id)}}" class="navigation-btn btn btn-success mr-2">
                                    <i class="fa fa-edit"></i>
                                </a>
                               <x-delete-buttons :action="route('deleterProjectCategory',$categ->id)" />
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
    </div>
</x-app-layout>
