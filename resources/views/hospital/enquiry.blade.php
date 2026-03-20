@extends('layout.hospital.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Enquiries</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('hospital.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Enquiries</li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Call ID</th>
                                    <th>Patient Name</th>
                                    <th>Patient Contact</th>
                                    <th>Hospital Contact</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enquiry as $index => $enq)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $enq->sid }}</td>
                                    <td>{{ $enq->patient_name }}</td>
                                    <td>{{ $enq->from }}</td>
                                    <td>{{ $enq->to }}</td>
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
                                    <td colspan="7" class="text-center">No enquiries found for your hospital.</td>
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
