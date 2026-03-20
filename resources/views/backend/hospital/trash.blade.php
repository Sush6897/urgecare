@extends('layout.backend.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-title">Trashed Hospitals</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('hospital.index') }}" class="btn btn-primary"><i class="fe fe-arrow-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
           
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Hospital Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hospitals as $hospital)
                                <tr>
                                    <td>{{ $hospital->hospital_name }}</td>
                                    <td>{{ $hospital->contact }}</td>
                                    <td>{{ $hospital->address }}</td>
                                    <td>{{ $hospital->city }}</td>
                                    <td>{{ $hospital->deleted_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <form action="{{ route('hospital.restore', $hospital->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Restore"><i class="fe fe-refresh-cw"></i> Restore</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
               
        </div>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('error'))
        iziToast.error({
            title: 'error',
            message: '{{ Session::get("error") }}',
            backgroundColor: '#f70400',
            titleColor: 'white',
            messageColor: 'white',
            icon: 'mdi mdi-close',
            iconColor: 'white',
        });
        @endif

        @if(Session::has('success'))
        iziToast.success({
            title: 'Success',
            message: '{{ Session::get("success") }}',
            backgroundColor: '#40a7a3',
            titleColor: 'white',
            messageColor: 'white',
            icon: 'mdi mdi-check',
            iconColor: 'white',
        });
        @endif
    });
</script>
@endsection
