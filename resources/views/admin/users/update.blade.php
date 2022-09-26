<x-app-layout>
    <x-slot name="header">
        <div class="inner-navigation">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Update Users') }}
            </h2>
            <x-nav-button href="javascript:history.back();" class="navigation-btn">
                    {{ __('Back') }}
            </x-nav-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('updateUser',$user->id) }}" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div class="column-3 gap-4">
                        <div class="mt-4">
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user->name }}" required autocomplete="off" />
                            <x-input id="role" class="block mt-1 w-full" type="hidden" name="role" value="{{ $user->role }}" required/>
                        </div>
                        <!-- User Name -->
                        <div class="mt-4">
                            <x-label for="username" :value="__('Username')" />
                            <x-input id="username" class="block mt-1 w-full" type="text" name="username" value="{{ $user->username }}" required autocomplete="false" disabled />
                            <p class="error mt-1"></p>
                        </div>
                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user->email }}" required  autocomplete="off" />
                        </div>
                        <!-- Father Name -->
                        <div class="mt-4">
                            <x-label for="fathername" :value="__('Father Name')" />
                            <x-input id="fathername" class="block mt-1 w-full" type="text" name="fathername" value="{{ $user->fathername }}"  autocomplete="off" />
                        </div>
                        <!-- Address -->
                        <div class="mt-4">
                            <x-label for="address" :value="__('Address')" />
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address" value="{{ $user->address }}"  autocomplete="off" />
                        </div>
                        <!-- Phone -->
                        <div class="mt-4">
                            <x-label for="phone" :value="__('Phone')" />
                            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{ $user->phone }}" required  autocomplete="off" />
                        </div>
                        <!-- Whatsapp -->
                        <div class="mt-4">
                            <x-label for="whatsapp" :value="__('Whatsapp')" />
                            <x-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp" value="{{ $user->whatsapp }}"  autocomplete="off" />
                        </div>
                        <!-- Adhar Number -->
                        <div class="mt-4">
                            <x-label for="adhar_number" :value="__('Adhar Number')" />
                            <x-input id="adhar_number" class="block mt-1 w-full" type="text" name="adhar_number" value="{{ $user->adhar_number }}" required  autocomplete="off" />
                        </div>
                        <!-- PAN Number -->
                        <div class="mt-4">
                            <x-label for="pan_number" :value="__('PAN Number')" />
                            <x-input id="pan_number" class="block mt-1 w-full" type="text" name="pan_number" value="{{ $user->pan_number }}"  autocomplete="off" />
                        </div>
                        <!-- Experience -->
                        <div class="mt-4">
                            <x-label for="total_experience" :value="__('Total Experience (In yrs)')" />
                            <x-input id="total_experience" class="block mt-1 w-full" type="text" name="total_experience" value="{{ $user->total_experience }}" required  autocomplete="off" />
                        </div>
                        <!-- Salary -->
                        <div class="mt-4">
                            <x-label for="current_salary" :value="__('Current Salary (In Rs.)')" />
                            <x-input id="current_salary" class="block mt-1 w-full" type="text" name="current_salary" value="{{ $user->current_salary }}"  autocomplete="off" />
                        </div>
                        <!-- Job Profile -->
                        <div class="mt-4">
                            <x-label for="job_profile" :value="__('Job Profile')" />
                            <x-input id="job_profile" class="block mt-1 w-full" value="{{ $user->job_profile }}" type="text" name="job_profile" required autocomplete="off" />
                        </div>
                        <!-- Resume -->
                        <div class="mt-4">
                            <x-label for="cv" :value="__('Resume')" />
                            <x-input id="cv" class="block mt-1 w-full" type="file" name="file" autocomplete="off" />
                            <a href="{{ asset('resume/'.$user->cv) }}" download>{{ $user->cv }}</a>
                        </div>

                        <!-- Active -->
                        <div class="mt-4">
                            <x-label for="active" :value="__('Active/Block')" />
                            <select id="active" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" type="text" name="active" required>
                                <option value="1" {{$user->active == '1' ? 'selected' : '' }} >Active</option>
                                <option value="0" {{$user->active == '0' ? 'selected' : '' }}>Block</option>
                            </select>
                        </div>

                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
