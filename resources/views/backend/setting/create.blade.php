@extends('layout.backend.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('setting.index') }}">Settings</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="card">
        <div class="card-header">
            <h1>Edit Global Settings</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('setting.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $setting->email ?? '') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $setting->contact_number ?? '') }}">
                        @error('contact_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="emergency_number">Emergency Number</label>
                        <input type="text" class="form-control" id="emergency_number" name="emergency_number" value="{{ old('emergency_number', $setting->emergency_number ?? '') }}">
                        @error('emergency_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="non_emergency_number">Non-Emergency Number</label>
                        <input type="text" class="form-control" id="non_emergency_number" name="non_emergency_number" value="{{ old('non_emergency_number', $setting->non_emergency_number ?? '') }}">
                        @error('non_emergency_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>

</div>
@endsection
