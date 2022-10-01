<x-app-layout>
    <x-slot name="header">
        <div class="inner-navigation">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Project') }}
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
                    <form method="POST" action="{{ route('createProject') }}" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        <!-- Name -->
                        <div class="row">
                        <div class="mt-2 col-md-4">
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="off" />
                            <input type="hidden" value="{{ Auth::user()->id }}" id="assign_by" name="assign_by" />
                        </div>
                        <!-- User Name -->
                        <div class="mt-2 col-md-4">
                            <x-label for="status" :value="__('Status')" />
                            <select id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" type="text" name="status" required>
                                <option value="hold">Hold</option>
                                <option value="running">Running</option>
                                <option value="client_reply_waiting">Client Reply Waiting</option>
                                <option value="failed">Failed</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <!-- Start Date -->
                        <div class="mt-2 col-md-4">
                            <x-label for="start_date" :value="__('Start Date')" />
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <x-input datepicker datepicker-autohide datepicker-buttons datepicker-format="yyyy-mm-dd" name="start_date" datepicker-orientation="top left" type="text" class="pl-10 block mt-1 w-full" placeholder="Select date" />
                            </div>
                            
                        </div>
                        <!-- Assign To -->
                        <div class="mt-2 col-md-4">
                            <x-label for="assign_to" :value="__('Assign To')" />
                            <select id="assign_to" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full select2-multiple" name="assign_to[]" multiple>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Category -->
                        <div class="mt-2 col-md-4">
                            <x-label for="cat_id" :value="__('Project Category')" />
                            <select id="cat_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="cat_id">
                                <option value="">--Select Category--</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Project Duration -->
                        <div class="mt-2 col-md-4">
                            <x-label for="duration" :value="__('Project Duration(In Hours)')" />
                            <x-input id="duration" class="block mt-1 w-full" type="text" name="duration"   autocomplete="off" />
                        </div>
                        <!-- Attachments -->
                        <div class="mt-2 col-md-4">
                            <x-label for="attachment" :value="__('Attachments')" />
                            <p id="button-area">
                            <label for="attachment" class="block w-full">
                                <a class="btn btn-primary block w-full text-light" role="button" aria-disabled="false">Upload Attachments</a>
                            </label>
                            <input type="file" name="attachment[]" id="attachment" style="visibility: hidden; position: absolute;" multiple/>
                            </p>
                            <p id="files-area" class="block w-full">
                                <span id="filesList">
                                    <span id="files-names"></span>
                                </span>
                            </p>
                        </div>
                        <!-- Project Details -->
                        <div class="mt-2 col-md-8">
                            <x-label for="project_details" :value="__('Project Details')" />
                            <textarea id="project_details" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" rows="10" type="text" name="project_details" autocomplete="off"></textarea>
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
        $('.select2-multiple').select2({
            placeholder: 'Select an option'
        });

        const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file

        $("#attachment").on('change', function(e){
            for(var i = 0; i < this.files.length; i++){
                let fileBloc = $('<span/>', {class: 'file-block'}),
                    fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
                fileBloc.append('<span class="file-delete"><span>+</span></span>')
                    .append(fileName);
                $("#filesList > #files-names").append(fileBloc);
            };
            // Ajout des fichiers dans l'objet DataTransfer
            for (let file of this.files) {
                dt.items.add(file);
            }
            // Mise à jour des fichiers de l'input file après ajout
            this.files = dt.files;

            // EventListener pour le bouton de suppression créé
            $('span.file-delete').click(function(){
                let name = $(this).next('span.name').text();
                // Supprimer l'affichage du nom de fichier
                $(this).parent().remove();
                for(let i = 0; i < dt.items.length; i++){
                    // Correspondance du fichier et du nom
                    if(name === dt.items[i].getAsFile().name){
                        // Suppression du fichier dans l'objet DataTransfer
                        dt.items.remove(i);
                        continue;
                    }
                }
                // Mise à jour des fichiers de l'input file après suppression
                document.getElementById('attachment').files = dt.files;
            });
        });
    });
</script>