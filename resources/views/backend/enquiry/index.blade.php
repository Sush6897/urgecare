@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Enquiry </h3>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('enquiry.index') }}" method="GET">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Patient Name</label>
                                <input type="text" name="patient_name" class="form-control" value="{{ request('patient_name') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Hospital</label>
                                <select name="hospital_id" class="form-control">
                                    <option value="">--All Hospitals--</option>
                                    @foreach($hospitals as $hosp)
                                        <option value="{{ $hosp->id }}" {{ request('hospital_id') == $hosp->id ? 'selected' : '' }}>{{ $hosp->hospital_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
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
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fe fe-search"></i> Search </button>
                                    <a href="{{ route('enquiry.index') }}" class="btn btn-danger btn-block">Reset</a>
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
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Call ID</th>
                                    <th>Patient Name</th>
                                    <th>Hospital Name</th>
                                    <th>Patient Contact</th>
                                    <th>Hospital Contact</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>


                                @forelse($enquiry as $enq)
                                <tr>
                                    <td>{{$enq->sid}}</td>
                                    <td>{{$enq->patient_name}}</td>
                                    <td>{{$enq->hospital->hospital_name}}</td>
                                    <td>{{$enq->from}}</td>
                                    <td>{{$enq->to}}</td>
                                    <td>{{$enq->status}}</td>
                                    <td>{{ \Carbon\Carbon::parse($enq->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                         
                                            <form action="{{ route('enquiry.status', ['id' => $enq->id]) }}" method="POST" class="me-2">
                                                @csrf
                                                @method('POST')
                                                <div class="input-group">
                                                    <select class="form-select" name="status" onchange="this.form.submit()">
                                                        <option value="success" {{ $enq->status == 'success' ? 'selected' : '' }}>Success</option>
                                                        <option value="notconnected" {{ $enq->status == 'notconnected' ? 'selected' : '' }}>Notconnected</option>
                                                        <option value="pending" {{ $enq->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    </select>
                                                </div>
                                            </form>

                                            <form class="ml-3" action="{{ route('enquiry.destroy', $enq->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Enquiry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">No enquiries found.</td>
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