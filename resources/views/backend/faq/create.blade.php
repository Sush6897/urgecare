@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add FAQ</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.faq.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control" required value="{{ old('question') }}">
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea name="answer" class="form-control" rows="5" required>{{ old('answer') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
