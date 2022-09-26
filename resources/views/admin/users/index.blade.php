<x-app-layout>
    <x-slot name="header">
        <div class="inner-navigation">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <x-nav-button :href="route('createUserForm')" class="navigation-btn">
                {{ __('Create User') }}
            </x-nav-button>
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
                            <th>Name</th>
                            <th>Father</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Adhar</th>
                            <th>PAN</th>
                            <th>Profile</th>
                            <th>Active</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                               <td>{{ $user->id }}</td>
                               <td>{{ $user->name }}</td>
                               <td>{{ $user->fathername }}</td>
                               <td>{{ $user->email }}</td>
                               <td>{{ $user->phone }}</td>
                               <td>{{ $user->adhar_number }}</td>
                               <td>{{ $user->pan_number }}</td>
                               <td>{{ $user->job_profile }}</td>
                               <td><input class="toggle-trigger" type="checkbox" data-toggle="toggle" onchange="BanOrActive(this,'{{ $user->id }}');" {{ ($user->active)? 'checked' : '' }}></td>
                               <td>
                                    <div class="flex align-items-center">
                                        <a href="{{route('updateUserForm',$user->id)}}" class="navigation-btn btn btn-success mr-2">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <x-delete-buttons :action="route('deleterUser',$user->id)" />
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function BanOrActive(el,userid){
        if(userid != undefined && userid != ''){
            var active = 0;
            if($(el).is(":checked")){
                active = 1;
            }
            $.ajax({
                type:'POST',
                url:"{{ route('activeUser') }}",
                data:{id : userid, active : active},
                success:function(data){
                        if($.isEmptyObject(data.error)){
                            // location.reload();
                        }else{
                            console.log(data.error);
                        }
                }
                });
        }
    }
</script>