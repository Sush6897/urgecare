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
                <form action="{{ route('hospital.index') }}" method="GET">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Hospital Name</label>
                                <input type="text" name="hospital_name" class="form-control" value="{{ request('hospital_name') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ request('city') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="form-group">
                                <label>Area</label>
                                <input type="text" name="area" class="form-control" value="{{ request('area') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">--All Status--</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fe fe-search"></i> Search </button>
                                    <a href="{{ route('hospital.index') }}" class="btn btn-secondary btn-block">Reset</a>
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
                                   <th>Hospital Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Type</th>
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
                                    <td>
                                        @foreach($hospital->contacts as $contact)
                                            <div>{{ $contact->contact }}</div>
                                        @endforeach
                                        @if($hospital->contacts->isEmpty() && $hospital->contact)
                                            <div>{{ $hospital->contact }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $hospital->address }}</td>
                                    <td>{{ $hospital->city }}</td>
                                    <td>
                                        @if($hospital->emergency)
                                            <span class="badge badge-danger">Emergency</span>
                                        @endif
                                        @if($hospital->nonemergency)
                                            <span class="badge badge-info">Non-Emergency</span>
                                        @endif
                                    </td>
                                    <td>{{ $hospital->area}}</td>
                                    <td>
                                        <span class="badge {{ $hospital->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($hospital->status) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($hospital->created_at)->format('Y-m-d') }}</td>
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
@endsection