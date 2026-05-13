@extends('layout.backend.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-title">Trashed Hospitals</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('hospital.index') }}" class="btn btn-primary"><i class="fe fe-arrow-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row" id="bulk_actions_container" style="display: none; margin-bottom: 15px;">
        <div class="col-sm-12">
            <div class="card bg-light border-primary mb-0">
                <div class="card-body py-2 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge badge-primary px-3 py-2" id="selected_count_badge">0 selected</span>
                        <span class="ml-2 font-weight-bold text-primary">Bulk Actions:</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-success" id="bulkRestoreBtn">
                            <i class="fe fe-refresh-cw"></i> Restore Selected
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
                                    <th>Deleted At</th>
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
                                    <td>{{ $hospital->deleted_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('hospital.restore', $hospital->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Restore"><i class="fe fe-refresh-cw"></i> Restore</button>
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
</div>

{{-- Bulk Restore Confirmation Modal --}}
<div class="modal fade" id="bulkRestoreModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fe fe-refresh-cw mr-1"></i> Confirm Bulk Restore
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fe fe-refresh-cw text-success" style="font-size: 48px;"></i>
                <h5 class="mt-3">Restore Hospitals</h5>
                <p class="text-muted">Are you sure you want to restore the selected hospital(s)?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="executeBulkRestoreBtn">Yes, Restore</button>
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

    // ── Bulk Restore ─────────────────────────────────────────
    $('#bulkRestoreBtn').on('click', function() {
        $('#bulkRestoreModal').modal('show');
    });

    $('#executeBulkRestoreBtn').on('click', function() {
        var ids = [];
        $('.hospital_checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        $('#bulkRestoreModal').modal('hide');
        
        $.ajax({
            url: "{{ route('hospital.bulk-restore') }}",
            type: 'POST',
            data: { 
                ids: ids, 
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
                showToast('Something went wrong!', 'danger');
            }
        });
    });

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
