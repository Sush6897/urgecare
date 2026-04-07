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
                    <form action="{{ route('hospital.enquiry') }}" method="GET">
                        <div class="row filter-row">
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label>Patient Name</label>
                                    <input type="text" name="patient_name" class="form-control" value="{{ request('patient_name') }}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">--All Status--</option>
                                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="notconnected" {{ request('status') == 'notconnected' ? 'selected' : '' }}>Notconnected</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary"><i class="fe fe-search"></i> Search </button>
                                        <a href="{{ route('hospital.enquiry') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
