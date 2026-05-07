@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Edit FAQ</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control" required value="{{ old('question', $faq->question) }}">
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea name="answer" class="form-control" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $faq->order) }}">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $faq->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $faq->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
