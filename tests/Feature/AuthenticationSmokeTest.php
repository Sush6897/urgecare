<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationSmokeTest extends TestCase
{
    public function test_admin_dashboard_redirects_guests_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_hospital_dashboard_requires_authentication(): void
    {
        $this->getJson('/hospital/dashboard')->assertUnauthorized();
    }

    public function test_sanctum_api_requires_authentication(): void
    {
        $this->getJson('/api/user')->assertUnauthorized();
    }
}
