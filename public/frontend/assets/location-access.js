(function () {
    'use strict';

    var script = document.currentScript;
    var hasSessionLocation = script && script.dataset.hasLocation === 'true';

    function hasSavedLocation() {
        if (hasSessionLocation) return true;

        try {
            var latitude = localStorage.getItem('latitude');
            var longitude = localStorage.getItem('longitude');
            return latitude !== null && longitude !== null &&
                latitude.trim() !== '' && longitude.trim() !== '' &&
                Number.isFinite(Number(latitude)) && Number.isFinite(Number(longitude)) &&
                Math.abs(Number(latitude)) <= 90 && Math.abs(Number(longitude)) <= 180;
        } catch (error) {
            // Storage may be unavailable in private browsing.
            return false;
        }
    }

    window.showLocationPromptIfNeeded = async function () {
        if (!navigator.geolocation || !document.getElementById('locationModal')) return;

        if (navigator.permissions && navigator.permissions.query) {
            try {
                var permission = await navigator.permissions.query({ name: 'geolocation' });
                // Granted users need no reminder; blocked users must change browser settings.
                if (permission.state === 'granted' || permission.state === 'denied') return;
            } catch (error) {
                // Some browsers do not support querying geolocation permission.
            }
        }

        if (!hasSavedLocation()) {
            window.jQuery('#locationModal').modal('show');
        }
    };
}());
