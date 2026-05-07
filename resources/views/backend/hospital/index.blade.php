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

{{-- Bulk Status Modal (checkbox-triggered) --}}
<div class="modal fade" id="bulkStatusModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fe fe-layers mr-1"></i> Update Hospital Status
                </h5>
                <button type="button" class="close text-white" onclick="location.reload();" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fe fe-check-square" style="font-size: 44px; color: #007bff;"></i>
                <h5 class="mt-3 mb-1">Change Status</h5>
                <p class="text-muted" id="bulkSelectedCount"></p>
                <p class="mb-3">What status do you want to apply to the selected hospitals?</p>
                <div class="d-flex justify-content-center" style="gap: 12px;">
                    <button type="button" class="btn btn-success px-4" id="setActiveBtn">
                        <i class="fe fe-check-circle mr-1"></i> Mark as Active
                    </button>
                    <button type="button" class="btn btn-danger px-4" id="setInactiveBtn">
                        <i class="fe fe-x-circle mr-1"></i> Mark as Inactive
                    </button>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" onclick="location.reload();">
                    <i class="fe fe-x"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div id="toastNotification" style="
    position: fixed; top: 20px; right: 20px; z-index: 9999;
    min-width: 280px; display: none;
    background: #fff; border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    border-left: 4px solid #28a745; padding: 16px 20px;
">
    <div class="d-flex align-items-center">
        <i id="toastIcon" class="fe fe-check-circle mr-2" style="font-size: 20px; color: #28a745;"></i>
        <span id="toastMessage" class="font-weight-bold"></span>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var $deleteForm = null;

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
    // ─────────────────────────────────────────────────────────

    // ── Select All ───────────────────────────────────────────
    $('#select_all').on('click', function() {
        $('.hospital_checkbox').prop('checked', this.checked);
        syncSelectAll();
        if (this.checked) openBulkModal();
    });

    // ── Individual Checkbox → open modal immediately ─────────
    $(document).on('change', '.hospital_checkbox', function() {
        syncSelectAll();
        if ($('.hospital_checkbox:checked').length > 0) {
            openBulkModal();
        }
    });

    // Modal is static, cancel reloads the page.

    function openBulkModal() {
        var count = $('.hospital_checkbox:checked').length;
        $('#bulkSelectedCount').text(count + ' hospital(s) selected');
        $('#bulkStatusModal').modal('show');
    }

    function syncSelectAll() {
        var total   = $('.hospital_checkbox').length;
        var checked = $('.hospital_checkbox:checked').length;
        $('#select_all').prop('checked', total > 0 && total === checked);
    }

    // ── Active / Inactive buttons inside modal ────────────────
    $('#setActiveBtn').on('click', function() {
        sendBulkStatus('active');
    });
    $('#setInactiveBtn').on('click', function() {
        sendBulkStatus('inactive');
    });

    function sendBulkStatus(status) {
        var ids = [];
        $('.hospital_checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            showToast('Please select at least one hospital.', 'warning');
            return;
        }

        $('#bulkStatusModal').modal('hide');

        $.ajax({
            url: "{{ route('hospital.bulk-status') }}",
            type: 'POST',
            data: { ids: ids, status: status, _token: "{{ csrf_token() }}" },
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
    }

    // ── Toast ─────────────────────────────────────────────────
    function showToast(message, type) {
        var colors = { success: '#28a745', danger: '#dc3545', warning: '#ffc107' };
        var icons  = { success: 'fe-check-circle', danger: 'fe-x-circle', warning: 'fe-alert-triangle' };
        var color  = colors[type] || '#333';
        var icon   = icons[type]  || 'fe-info';
        $('#toastNotification').css('border-left-color', color).fadeIn(300);
        $('#toastIcon').attr('class', 'fe ' + icon + ' mr-2').css('color', color);
        $('#toastMessage').text(message);
        setTimeout(function() { $('#toastNotification').fadeOut(400); }, 3000);
    }

    // ── Auto-toast on page load for session flash messages ────
    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
        showToast("{{ session('error') }}", 'danger');
    @endif
});
</script>
@endsection