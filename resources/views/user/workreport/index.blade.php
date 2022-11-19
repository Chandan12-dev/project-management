<x-app-layout>
    <x-slot name="header">
        <div class="inner-navigation">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('WorK Reports') }}
            </h2>
            <x-nav-button :href="route('WorkReportCreateForm')" class="navigation-btn">
                {{ __('Add Workreport') }}
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
                    <table class="table table-bordered table-hover table-striped nowrap filter-Table">
                        <thead class="thead-dark table-striped">
                            <th>Id</th>
                            <th>Date</th>
                            <th>Project</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Hours</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($workreports as $report)
                            <tr>
                               <td>{{ $report->id }}</td>
                               <td>{{ $report->report_date }}</td>
                               <td><a href="{{ route('viewprojects', optional($report->project)->id) }}">{{ optional($report->project)->name }}</a></td>
                               <td>{{ $report->start_time }}</td>
                               <td>{{ $report->end_time }}</td>
                               <td> {{ (int)($report->duration / 3600) }} Hours  {{ (int)(($report->duration % 3600) / 60) }} Minutes</td>
                               <td>{{ $report->comment }}</td>
                               <td>
                                    <div class="flex align-items-center">
                                        <x-delete-buttons :action="route('DeleteWorkReport',$report->id)" />
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
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: 'Select an option'
        });
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('.filter-Table').DataTable( {
            responsive: true,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
        } );
    
        new $.fn.dataTable.FixedHeader( table );
    } );
</script>