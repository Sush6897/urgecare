@extends('layout.backend.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-title">Global Settings</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ul>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('setting.create') }}" class="btn btn-primary"><i class="fe fe-edit"></i> Edit Settings</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @if($setting)
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <tbody>
                                <tr>
                                    <th>Email Address</th>
                                    <td>{{ $setting->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td>{{ $setting->contact_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Emergency Number</th>
                                    <td>{{ $setting->emergency_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Non-Emergency Number</th>
                                    <td>{{ $setting->non_emergency_number ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        Settings have not been configured yet. Please click "Edit Settings" to add them.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
