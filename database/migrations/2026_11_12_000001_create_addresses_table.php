<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('recipient_name');
            $table->string('phone_number');
            $table->text('address');
            // RajaOngkir/Komerce domestic destination id. Nullable only for rows
            // migrated from the old single-address `customers` table.
            $table->unsignedBigInteger('rajaongkir_destination_id')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
        });

        // Backfill the old single address per customer as the first saved address.
        $now = now();
        $customers = DB::table('customers')
            ->whereNotNull('address')
            ->where('address', '<>', '')
            ->get();

        foreach ($customers as $customer) {
            $user = DB::table('users')->where('id', $customer->user_id)->first();

            DB::table('addresses')->insert([
                'user_id' => $customer->user_id,
                'label' => 'Alamat Utama',
                'recipient_name' => $user->name ?? 'Penerima',
                'phone_number' => $customer->phone_number ?: '-',
                'address' => $customer->address,
                'rajaongkir_destination_id' => null,
                'province' => $customer->province,
                'city' => null,
                'district' => $customer->district,
                'subdistrict' => null,
                'postal_code' => $customer->postal_code,
                'is_default' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
