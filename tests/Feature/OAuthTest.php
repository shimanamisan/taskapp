<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OAuthTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->providerName = 'twitter';
    }

    /**
     * @test
     */
    public function twitterの認証画面を表示できる()
    {
        // URLをコール
        $this->get(route('/login/{provider}', ['provider' => $this->providerName]))
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function twitterアカウントでユーザー登録できる()
    {
        // URLをコール
        $this->get(route('/login/{provider}/callback', ['provider' => $this->providerName]))
            ->assertStatus(200);
    }
}
