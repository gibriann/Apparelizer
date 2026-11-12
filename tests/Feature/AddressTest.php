<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    private function customer(): User
    {
        return User::factory()->create(['role_id' => 3]);
    }

    private function address(User $user, array $overrides = []): Address
    {
        return Address::create(array_merge([
            'user_id' => $user->id,
            'label' => 'Rumah',
            'recipient_name' => 'Budi',
            'phone_number' => '081234567890',
            'address' => 'Jl. Merdeka No. 1',
            'rajaongkir_destination_id' => '17732',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran',
            'subdistrict' => 'Senayan',
            'postal_code' => '12190',
            'is_default' => false,
        ], $overrides));
    }

    public function test_guest_cannot_see_saved_addresses(): void
    {
        $this->get('/account')->assertRedirect();
    }

    public function test_customer_sees_only_their_own_addresses(): void
    {
        $me = $this->customer();
        $other = $this->customer();

        $this->address($me, ['label' => 'Milik Saya']);
        $this->address($other, ['label' => 'Milik Orang']);

        $response = $this->actingAs($me)->get('/account');

        $response->assertOk();
        $response->assertSee('Milik Saya');
        $response->assertDontSee('Milik Orang');
    }

    public function test_address_can_be_created(): void
    {
        $me = $this->customer();

        $response = $this->actingAs($me)->postJson('/account/addresses', [
            'label' => 'Kantor',
            'recipient_name' => 'Budi',
            'phone_number' => '081234567890',
            'address' => 'Jl. Sudirman No. 2',
            'rajaongkir_destination_id' => '6523',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'district' => 'Gubeng',
            'subdistrict' => 'Airlangga',
            'postal_code' => '60286',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('addresses', [
            'user_id' => $me->id,
            'label' => 'Kantor',
        ]);
    }

    public function test_customer_cannot_edit_someone_elses_address(): void
    {
        $me = $this->customer();
        $other = $this->customer();
        $theirs = $this->address($other);

        $response = $this->actingAs($me)->putJson("/account/addresses/{$theirs->id}", [
            'label' => 'Dibajak',
            'recipient_name' => 'X',
            'phone_number' => '0800',
            'address' => 'Jl. X',
        ]);

        $response->assertNotFound();
        $this->assertDatabaseMissing('addresses', ['label' => 'Dibajak']);
    }

    public function test_customer_cannot_delete_someone_elses_address(): void
    {
        $me = $this->customer();
        $other = $this->customer();
        $theirs = $this->address($other);

        $this->actingAs($me)->delete("/account/addresses/{$theirs->id}");

        $this->assertDatabaseHas('addresses', ['id' => $theirs->id]);
    }

    public function test_setting_default_unsets_the_previous_one(): void
    {
        $me = $this->customer();
        $first = $this->address($me, ['is_default' => true]);
        $second = $this->address($me, ['label' => 'Kantor']);

        $this->actingAs($me)->post("/account/addresses/{$second->id}/default");

        $this->assertFalse($first->fresh()->is_default);
        $this->assertTrue($second->fresh()->is_default);
    }

    public function test_address_without_destination_is_not_shippable(): void
    {
        $me = $this->customer();
        $this->address($me, ['label' => 'Tanpa Tujuan', 'rajaongkir_destination_id' => null]);

        $shippable = Address::where('user_id', $me->id)->shippable()->get();

        $this->assertTrue($shippable->isEmpty());
    }

    public function test_shipping_picker_renders_selectable_cards(): void
    {
        $me = $this->customer();
        $this->address($me, ['is_default' => true, 'label' => 'Rumah']);

        $html = view('pages.partials.address-card-account', [
            'address' => Address::where('user_id', $me->id)->first(),
            'selectable' => true,
        ])->render();

        $this->assertStringContainsString('address-option', $html);
        $this->assertStringContainsString('type="radio"', $html);
        $this->assertStringNotContainsString('fa-pen', $html);
    }

    public function test_account_card_renders_action_buttons(): void
    {
        $me = $this->customer();
        $this->address($me, ['is_default' => true, 'label' => 'Rumah']);

        $html = view('pages.partials.address-card-account', [
            'address' => Address::where('user_id', $me->id)->first(),
        ])->render();

        $this->assertStringContainsString('fa-pen', $html);
        $this->assertStringNotContainsString('type="radio"', $html);
    }
}
