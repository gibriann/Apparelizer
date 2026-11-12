<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // the picker calls @error, which needs the shared error bag
        $this->withViewErrors([]);
    }

    public function test_missing_avatar_falls_back_to_default(): void
    {
        $user = new User(['avatar' => '']);

        $this->assertStringEndsWith('images/default.png', $user->avatar_url);
    }

    public function test_unknown_avatar_file_falls_back_to_default(): void
    {
        $user = User::factory()->create(['avatar' => 'tidak-ada.png']);

        $this->assertStringEndsWith('images/default.png', $user->avatar_url);
    }

    public function test_default_avatar_resolves_to_the_bundled_image(): void
    {
        $user = User::factory()->create(['avatar' => 'default.png']);

        $this->assertStringEndsWith('images/default.png', $user->avatar_url);
        $this->assertFileExists(public_path('images/default.png'));
    }

    public function test_uploaded_avatar_resolves_to_storage(): void
    {
        $user = User::factory()->create(['avatar' => 'public/avatars/foto.jpg']);

        $this->assertStringContainsString('storage/avatars/foto.jpg', $user->avatar_url);
        $this->assertTrue($user->hasCustomAvatar());
    }

    public function test_default_avatar_is_not_treated_as_custom(): void
    {
        $user = User::factory()->create(['avatar' => 'default.png']);

        $this->assertFalse($user->hasCustomAvatar());
    }

    public function test_avatar_picker_renders_upload_button(): void
    {
        $user = User::factory()->create(['avatar' => 'default.png']);

        $html = view('pages.partials.avatar-picker', ['user' => $user])->render();

        $this->assertStringContainsString('avatar-dropzone', $html);
        $this->assertStringContainsString('Unggah Foto', $html);
        $this->assertStringContainsString('data-avatar-picker', $html);
    }

    public function test_avatar_picker_shows_change_label_when_avatar_exists(): void
    {
        $user = User::factory()->create(['avatar' => 'public/avatars/foto.jpg']);

        $html = view('pages.partials.avatar-picker', ['user' => $user])->render();

        $this->assertStringContainsString('Ganti Foto', $html);
        $this->assertStringNotContainsString('Unggah Foto', $html);
    }
}
