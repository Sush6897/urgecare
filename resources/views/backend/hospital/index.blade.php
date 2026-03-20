@extends('layout.backend.app')
@section('content')
@php
    $partners = App\Models\Partner::all();
@endphp
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-title">Hospitals</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('hospital.trash') }}" class="btn btn-warning"><i class="fe fe-trash"></i> Trash</a>
                <a href="{{ route('hospital.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i> Add Hospital</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                   <th>Hospital Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Area</th>
                                    <th>Status</th>
                                    <th>Created</th>
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
                                    <td>{{ $hospital->state }}</td>
                                    <td>{{ $hospital->country }}</td>
                                    <td>{{ $hospital->area}}</td>
                                    <td>
                                        <span class="badge {{ $hospital->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($hospital->status) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($hospital->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('hospital.edit', $hospital->id) }}" class="btn btn-sm btn-primary"><i class="fe fe-pencil"></i></a>
                                        <form action="{{ route('hospital.destroy', $hospital->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this hospital?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
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
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('error'))
        iziToast.error({
            title: 'error',
            message: '{{ Session::get("error") }}',
            backgroundColor: '#f70400', // Set the background color to black
            titleColor: 'white', // Set the title color to white for better visibility
            messageColor: 'white', // Set the message color to white for better visibility
            icon: 'mdi mdi-close', // MDI information icon
            iconColor: 'white',
        });
        @endif

        @if(Session::has('success'))
        iziToast.success({
            title: 'Success',
            message: '{{ Session::get("success") }}',
            backgroundColor: '#40a7a3', // Set the background color to black
            titleColor: 'white', // Set the title color to white for better visibility
            messageColor: 'white', // Set the message color to white for better visibility
            icon: 'mdi mdi-check', // MDI information icon
            iconColor: 'white',
        });
        @endif
    });
</script>
@endsection