@extends('layout.backend.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">User Visits</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Visits</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent User Visits (Location Access)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Date/Time</th>
                                    <th>IP Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Pincode</th>
                                    <th>Coordinates</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visits as $visit)
                                <tr>
                                    <td>{{ $visit->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $visit->ip_address }}</td>
                                    <td>{{ $visit->city }}</td>
                                    <td>{{ $visit->state }}</td>
                                    <td>{{ $visit->pincode }}</td>
                                    <td>
                                        <a href="https://www.google.com/maps?q={{ $visit->latitude }},{{ $visit->longitude }}" target="_blank">
                                            {{ $visit->latitude }}, {{ $visit->longitude }}
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('user-visits.destroy', $visit->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger-light" onclick="return confirm('Are you sure?')">
                                                <i class="fe fe-trash"></i> Delete
                                            </button>
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
</div>
@endsection
