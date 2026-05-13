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
                <a href="{{ route('hospital.trash') }}" class="btn btn-danger"><i class="fe fe-trash"></i> Trash</a>
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
                                    <a href="{{ route('hospital.index') }}" class="btn btn-danger btn-block">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row" id="bulk_actions_container" style="display: none; margin-bottom: 15px;">
    <div class="col-sm-12">
        <div class="card bg-light border-primary mb-0">
            <div class="card-body py-2 d-flex align-items-center justify-content-between">
                <div>
                    <span class="badge badge-primary px-3 py-2" id="selected_count_badge">0 selected</span>
                    <span class="ml-2 font-weight-bold text-primary">Bulk Actions:</span>
                </div>
                <div class="d-flex" style="gap: 10px;">
                    <button type="button" class="btn btn-sm btn-success bulk-status-btn" data-status="active">
                        <i class="fe fe-check-circle"></i> Mark Active
                    </button>
                    <button type="button" class="btn btn-sm btn-danger bulk-status-btn" data-status="inactive">
                        <i class="fe fe-x-circle"></i> Mark Inactive
                    </button>
                </div>
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
                                <th><input type="checkbox" id="select_all"></th>
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
                                    <td><input type="checkbox" class="hospital_checkbox" value="{{ $hospital->id }}"></td>
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
                                        <form action="{{ route('hospital.destroy', $hospital->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-name="{{ $hospital->hospital_name }}"><i class="fe fe-trash"></i></button>
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

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteHospitalModal" tabindex="-1" role="dialog" aria-labelledby="deleteHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteHospitalModalLabel">
                    <i class="fe fe-alert-triangle mr-1"></i> Delete Hospital
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fe fe-trash-2" style="font-size: 48px; color: #dc3545;"></i>
                <h5 class="mt-3">Are you sure?</h5>
                <p class="text-muted mb-0">You are about to delete:</p>
                <p class="font-weight-bold" id="deleteHospitalName"></p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fe fe-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fe fe-trash"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Bulk Status Confirmation Modal --}}
<div class="modal fade" id="bulkConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="bulkConfirmHeader">
                <h5 class="modal-title text-white">
                    <i class="fe fe-refresh-cw mr-1"></i> Confirm Bulk Action
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <i id="bulkConfirmIcon" style="font-size: 48px;"></i>
                <h5 class="mt-3" id="bulkConfirmTitle"></h5>
                <p class="text-muted" id="bulkConfirmMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn" id="executeBulkBtn">Yes, Proceed</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var $deleteForm = null;
    var selectedStatus = null;

    // ── Delete Modal ──────────────────────────────────────────
    $(document).on('click', '.delete-btn', function() {
        $deleteForm = $(this).closest('.delete-form');
        $('#deleteHospitalName').text($(this).data('name'));
        $('#deleteHospitalModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function() {
        $('#deleteHospitalModal').modal('hide');
        if ($deleteForm) $deleteForm.submit();
    });

    // ── Select All ───────────────────────────────────────────
    $('#select_all').on('click', function() {
        $('.hospital_checkbox').prop('checked', this.checked);
        toggleBulkActions();
    });

    // ── Individual Checkbox ─────────────────────────────────
    $(document).on('change', '.hospital_checkbox', function() {
        var total = $('.hospital_checkbox').length;
        var checked = $('.hospital_checkbox:checked').length;
        $('#select_all').prop('checked', total > 0 && total === checked);
        toggleBulkActions();
    });

    function toggleBulkActions() {
        var count = $('.hospital_checkbox:checked').length;
        if (count > 0) {
            $('#selected_count_badge').text(count + ' selected');
            $('#bulk_actions_container').fadeIn(200);
        } else {
            $('#bulk_actions_container').fadeOut(200);
        }
    }

    // ── Bulk Status Buttons ──────────────────────────────────
    $('.bulk-status-btn').on('click', function() {
        selectedStatus = $(this).data('status');
        var count = $('.hospital_checkbox:checked').length;
        
        // Prepare Modal Content
        if (selectedStatus === 'active') {
            $('#bulkConfirmHeader').attr('class', 'modal-header bg-success');
            $('#bulkConfirmIcon').attr('class', 'fe fe-check-circle text-success');
            $('#bulkConfirmTitle').text('Set as Active');
            $('#bulkConfirmMessage').text('Are you sure you want to activate ' + count + ' selected hospital(s)?');
            $('#executeBulkBtn').attr('class', 'btn btn-success').text('Activate');
        } else {
            $('#bulkConfirmHeader').attr('class', 'modal-header bg-danger');
            $('#bulkConfirmIcon').attr('class', 'fe fe-x-circle text-danger');
            $('#bulkConfirmTitle').text('Set as Inactive');
            $('#bulkConfirmMessage').text('Are you sure you want to deactivate ' + count + ' selected hospital(s)?');
            $('#executeBulkBtn').attr('class', 'btn btn-danger').text('Deactivate');
        }
        
        $('#bulkConfirmModal').modal('show');
    });

    $('#executeBulkBtn').on('click', function() {
        var ids = [];
        $('.hospital_checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        $('#bulkConfirmModal').modal('hide');
        
        $.ajax({
            url: "{{ route('hospital.bulk-status') }}",
            type: 'POST',
            data: { 
                ids: ids, 
                status: selectedStatus, 
                _token: "{{ csrf_token() }}" 
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    setTimeout(function() { location.reload(); }, 1200);
                } else {
                    showToast(response.message, 'danger');
                }
            },
            error: function() {
                showToast('Something went wrong! Please try again.', 'danger');
            }
        });
    });

    // ── Toast ─────────────────────────────────────────────────
    function showToast(message, type) {
        if (type === 'success') {
            iziToast.success({
                title: 'Success',
                message: message,
                position: 'topRight',
                backgroundColor: '#40a7a3',
                titleColor: 'white',
                messageColor: 'white',
                icon: 'mdi mdi-check',
                iconColor: 'white',
            });
        } else {
            iziToast.error({
                title: 'Error',
                message: message,
                position: 'topRight',
                backgroundColor: '#f70400',
                titleColor: 'white',
                messageColor: 'white',
                icon: 'mdi mdi-close',
                iconColor: 'white',
            });
        }
    }
});
</script>
@endsection