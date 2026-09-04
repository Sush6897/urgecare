@extends('layout.backend.app')

@section('content')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    #patient-map {
        height: 520px;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.12);
        z-index: 1;
    }

    .pulse-marker-walking {
        background: #10B981;
        border: 3px solid #ffffff;
        border-radius: 50%;
        height: 22px;
        width: 22px;
        box-shadow: 0 0 12px #10B981;
        animation: pulseWalk 1.5s infinite;
    }

    .pulse-marker-stopped {
        background: #EF4444;
        border: 3px solid #ffffff;
        border-radius: 50%;
        height: 22px;
        width: 22px;
        box-shadow: 0 0 10px #EF4444;
    }

    @keyframes pulseWalk {
        0% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.8); }
        70% { transform: scale(1.2); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .status-badge-walking {
        background-color: #DBEAFE;
        color: #1D4ED8;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .status-badge-stopped {
        background-color: #FEE2E2;
        color: #DC2626;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .card-metric {
        border-radius: 12px;
        transition: transform 0.2s;
    }
    .card-metric:hover {
        transform: translateY(-3px);
    }
</style>

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm-8">
                <h3 class="page-title"><i class="fe fe-map-pin text-primary"></i> Patient Movement Live Tracking</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patient Tracking</li>
                </ul>
            </div>
            <div class="col-sm-4 text-right">
                <span class="badge badge-pill badge-success p-2">
                    <i class="fa fa-sync-alt fa-spin"></i> Live Auto-Polling (5s)
                </span>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Metrics Cards -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card card-metric bg-white border">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon bg-primary text-white">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3 id="stat-total-active">{{ $totalActive }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info mt-2">
                        <h6 class="text-muted">Active Tracked Patients</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card card-metric bg-white border">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon bg-success text-white">
                            <i class="fa fa-walking"></i>
                        </span>
                        <div class="dash-count">
                            <h3 id="stat-walking">{{ $walkingCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info mt-2">
                        <h6 class="text-muted">Patients Walking</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card card-metric bg-white border">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon bg-danger text-white">
                            <i class="fa fa-user-clock"></i>
                        </span>
                        <div class="dash-count">
                            <h3 id="stat-stopped">{{ $stoppedCount }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info mt-2">
                        <h6 class="text-muted">Patients Stopped / Idle</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 50%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card card-metric bg-white border">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon bg-warning text-white">
                            <i class="fe fe-clock"></i>
                        </span>
                        <div class="dash-count">
                            <h3>60 Min</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info mt-2">
                        <h6 class="text-muted">Auto Tracking Window</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Map Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fe fe-map"></i> Real-time Movement Map</h4>
                    <div>
                        <button class="btn btn-sm btn-outline-primary active mr-1" id="filter-all">All Patients</button>
                        <button class="btn btn-sm btn-outline-success mr-1" id="filter-walking">🚶 Walking Only</button>
                        <button class="btn btn-sm btn-outline-danger" id="filter-stopped">🛑 Stopped Only</button>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div id="patient-map"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sessions Data Table -->
    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Live Tracking Sessions List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0" id="patient-sessions-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Started At</th>
                                    <th>IP Address</th>
                                    <th>Movement Status</th>
                                    <th>Current Speed</th>
                                    <th>Total Distance</th>
                                    <th>Coordinates</th>
                                    <th>Time Left</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="sessions-table-body">
                                @forelse($recentSessions as $session)
                                <tr>
                                    <td>{{ $session->started_at ? $session->started_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                    <td><code>{{ $session->ip_address }}</code></td>
                                    <td>
                                        @if($session->movement_status === 'walking')
                                            <span class="status-badge-walking">🚶 Walking</span>
                                        @else
                                            <span class="status-badge-stopped">🛑 Stopped</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ number_format($session->current_speed, 1) }} km/h</strong></td>
                                    <td>{{ number_format($session->total_distance_meters, 0) }} m</td>
                                    <td>
                                        <small>{{ $session->current_latitude }}, {{ $session->current_longitude }}</small>
                                    </td>
                                    <td>
                                        @if($session->remaining_seconds > 0)
                                            <span class="text-success font-weight-bold">{{ floor($session->remaining_seconds / 60) }}m {{ $session->remaining_seconds % 60 }}s</span>
                                        @else
                                            <span class="text-muted">Expired</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary focus-patient-btn" 
                                            data-lat="{{ $session->current_latitude }}" 
                                            data-lng="{{ $session->current_longitude }}"
                                            data-id="{{ $session->id }}">
                                            <i class="fe fe-eye"></i> View Path
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted p-4">No active tracking sessions found.</td>
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

<!-- Modal for Session Movement Timeline -->
<div class="modal fade" id="sessionTimelineModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fe fe-navigation"></i> Patient Movement History Trail</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-session-info" class="mb-3 p-3 bg-light rounded"></div>
                <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Coordinates</th>
                                <th>Status</th>
                                <th>Speed</th>
                            </tr>
                        </thead>
                        <tbody id="modal-timeline-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // 1. Initialize Leaflet Map (Default center: India / General region)
    var map = L.map('patient-map').setView([20.5937, 78.9629], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors | UrgeCare Patient Tracking'
    }).addTo(map);

    var markersGroup = L.featureGroup().addTo(map);
    var polylineGroup = L.featureGroup().addTo(map);
    var currentFilter = 'all';
    var cachedSessions = [];

    // Custom Icon Creators
    function createPulseIcon(status) {
        var className = (status === 'walking') ? 'pulse-marker-walking' : 'pulse-marker-stopped';
        return L.divIcon({
            className: className,
            iconSize: [22, 22],
            iconAnchor: [11, 11]
        });
    }

    // 2. Fetch and render live active sessions from API
    function fetchAndRenderLiveSessions() {
        $.ajax({
            url: '{{ route("admin.patient-tracking.api.active") }}',
            method: 'GET',
            success: function(res) {
                if (res.status === 'success') {
                    cachedSessions = res.sessions;
                    renderSessions(cachedSessions);
                }
            },
            error: function(err) {
                console.error('[Admin Tracking API Error]', err);
            }
        });
    }

    function renderSessions(sessions) {
        markersGroup.clearLayers();
        polylineGroup.clearLayers();

        var bounds = [];
        var activeCount = 0;
        var walkingCount = 0;
        var stoppedCount = 0;
        var tableHtml = '';

        sessions.forEach(function(s) {
            if (s.is_active) activeCount++;
            if (s.movement_status === 'walking') walkingCount++;
            else stoppedCount++;

            // Apply filter
            if (currentFilter === 'walking' && s.movement_status !== 'walking') return;
            if (currentFilter === 'stopped' && s.movement_status !== 'stopped') return;

            if (s.current_latitude && s.current_longitude) {
                var latLng = [s.current_latitude, s.current_longitude];
                bounds.push(latLng);

                // Add Marker
                var icon = createPulseIcon(s.movement_status);
                var marker = L.marker(latLng, { icon: icon }).addTo(markersGroup);

                var statusText = s.movement_status === 'walking' ? '🚶 Walking' : '🛑 Stopped';
                var statusColor = s.movement_status === 'walking' ? '#2563EB' : '#DC2626';

                var popupContent = `
                    <div style="font-family: sans-serif; padding: 4px;">
                        <h6 style="margin: 0 0 6px; font-weight: 700; color: #1E293B;">Patient Session #${s.id}</h6>
                        <div style="margin-bottom: 4px;"><strong style="color:${statusColor}">${statusText}</strong></div>
                        <div style="font-size: 12px; color: #475569;">
                            <div><strong>IP:</strong> ${s.ip_address || 'N/A'}</div>
                            <div><strong>Speed:</strong> ${s.current_speed} km/h</div>
                            <div><strong>Total Distance:</strong> ${Math.round(s.total_distance_meters)} meters</div>
                            <div><strong>Time Remaining:</strong> ${Math.floor(s.remaining_seconds / 60)}m ${s.remaining_seconds % 60}s</div>
                            <div><strong>Last Update:</strong> ${s.last_updated}</div>
                        </div>
                    </div>
                `;
                marker.bindPopup(popupContent);

                // Draw movement trail polyline if logs exist
                if (s.logs && s.logs.length > 1) {
                    var latLngs = s.logs.map(function(l) { return [l.lat, l.lng]; });
                    L.polyline(latLngs, {
                        color: s.movement_status === 'walking' ? '#3B82F6' : '#EF4444',
                        weight: 4,
                        opacity: 0.8,
                        dashArray: s.movement_status === 'walking' ? null : '6, 6'
                    }).addTo(polylineGroup);
                }
            }

            // Build Table Row
            var isWalking = (s.movement_status === 'walking');
            var remSec = s.remaining_seconds || 0;
            var timeLeftStr = remSec > 0 ? (Math.floor(remSec / 60) + 'm ' + (remSec % 60) + 's') : '<span class="text-muted">Expired</span>';

            tableHtml += `
                <tr>
                    <td>${s.started_at}</td>
                    <td><code>${s.ip_address || 'Unknown'}</code></td>
                    <td>
                        <span class="${isWalking ? 'status-badge-walking' : 'status-badge-stopped'}">
                            ${isWalking ? '🚶 Walking' : '🛑 Stopped'}
                        </span>
                    </td>
                    <td><strong>${s.current_speed.toFixed(1)} km/h</strong></td>
                    <td>${Math.round(s.total_distance_meters)} m</td>
                    <td><small>${s.current_latitude.toFixed(5)}, ${s.current_longitude.toFixed(5)}</small></td>
                    <td><span class="text-primary font-weight-bold">${timeLeftStr}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary focus-patient-btn" data-lat="${s.current_latitude}" data-lng="${s.current_longitude}" data-id="${s.id}">
                            <i class="fe fe-eye"></i> View Path
                        </button>
                    </td>
                </tr>
            `;
        });

        // Update stats
        $('#stat-total-active').text(activeCount);
        $('#stat-walking').text(walkingCount);
        $('#stat-stopped').text(stoppedCount);

        if (tableHtml) {
            $('#sessions-table-body').html(tableHtml);
        } else {
            $('#sessions-table-body').html('<tr><td colspan="8" class="text-center text-muted p-4"><i class="fe fe-info"></i> No patient tracking sessions found for selected filter.</td></tr>');
        }

        // Adjust map bounds if pins exist
        if (bounds.length > 0) {
            map.fitBounds(L.latLngBounds(bounds), { padding: [40, 40], maxZoom: 16 });
        }
    }

    // 3. Filter Buttons
    $('#filter-all').click(function() {
        currentFilter = 'all';
        $('.card-header button').removeClass('active');
        $(this).addClass('active');
        renderSessions(cachedSessions);
    });

    $('#filter-walking').click(function() {
        currentFilter = 'walking';
        $('.card-header button').removeClass('active');
        $(this).addClass('active');
        renderSessions(cachedSessions);
    });

    $('#filter-stopped').click(function() {
        currentFilter = 'stopped';
        $('.card-header button').removeClass('active');
        $(this).addClass('active');
        renderSessions(cachedSessions);
    });

    // 4. Focus Patient & Show Detailed Path History
    $(document).on('click', '.focus-patient-btn', function() {
        var lat = parseFloat($(this).data('lat'));
        var lng = parseFloat($(this).data('lng'));
        var id = $(this).data('id');

        if (lat && lng) {
            map.setView([lat, lng], 17, { animate: true });
            $('html, body').animate({ scrollTop: $('#patient-map').offset().top - 100 }, 400);
        }

        // Fetch full path details for Modal
        $.ajax({
            url: '{{ url("admin/patient-tracking/api/session") }}/' + id,
            method: 'GET',
            success: function(res) {
                if (res.status === 'success') {
                    var s = res.session;
                    $('#modal-session-info').html(`
                        <strong>Session ID:</strong> #${s.id} | 
                        <strong>IP:</strong> ${s.ip_address || 'N/A'} | 
                        <strong>Total Distance:</strong> ${Math.round(s.total_distance_m)}m | 
                        <strong>Status:</strong> ${s.movement_status.toUpperCase()}
                    `);

                    var rows = '';
                    res.breadcrumbs.forEach(function(b) {
                        rows += `
                            <tr>
                                <td>${b.recorded_at}</td>
                                <td>${b.lat.toFixed(6)}, ${b.lng.toFixed(6)}</td>
                                <td><span class="${b.status === 'walking' ? 'text-primary' : 'text-danger'} font-weight-bold">${b.status.toUpperCase()}</span></td>
                                <td>${b.speed.toFixed(1)} km/h</td>
                            </tr>
                        `;
                    });

                    $('#modal-timeline-body').html(rows || '<tr><td colspan="4" class="text-center">No logs recorded yet.</td></tr>');
                    $('#sessionTimelineModal').modal('show');
                }
            }
        });
    });

    // Initial load and set interval for 5-second polling
    fetchAndRenderLiveSessions();
    setInterval(fetchAndRenderLiveSessions, 5000);
});
</script>
@endsection
