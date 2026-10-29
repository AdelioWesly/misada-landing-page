<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiHealthTest extends TestCase
{
    public function test_versioned_health_endpoint_returns_a_success_payload(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response
            ->assertOk()
            ->assertJsonPath('data.status', 'ok')
            ->assertJsonPath('message', 'MISADA API is running.');
    }

    public function test_admin_identity_endpoint_rejects_anonymous_requests(): void
    {
        $this->getJson('/api/v1/admin/me')->assertUnauthorized();
    }
}
