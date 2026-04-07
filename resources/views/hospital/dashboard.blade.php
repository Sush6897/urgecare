@extends('layout.hospital.app')
@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome {{auth('hospital')->user()->hospital_name ?? 'Hospital'}} !</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="fe fe-calendar"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $currentMonthCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Current Month</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success">
                            <i class="fe fe-clock"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $lastMonthCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Last Month</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-warning border-warning">
                            <i class="fe fe-activity"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $thisYearCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">This Year</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-info border-info">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $totalCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Total Enquiries</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Recent Enquiries</h4>
                    <a href="{{ route('hospital.enquiry') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Call ID</th>
                                    <th>Patient Name</th>
                                    <th>Patient Contact</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestEnquiries as $enq)
                                <tr>
                                    <td>{{ $enq->sid }}</td>
                                    <td>{{ $enq->patient_name }}</td>
                                    <td>{{ $enq->from }}</td>
                                    <td>
                                        @if($enq->status == 'success')
                                            <span class="badge badge-success">Success</span>
                                        @elseif($enq->status == 'notconnected')
                                            <span class="badge badge-danger">Not Connected</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($enq->created_at)->format('d M Y, h:i A') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No recent enquiries found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
 

</div>
@endsection
