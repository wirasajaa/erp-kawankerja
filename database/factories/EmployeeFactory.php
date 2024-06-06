<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);
        $fullname = fake('id_ID')->name($gender);
        $user = User::first();
        return [
            'id' => Str::ulid()->toBase32(),
            'nip' => getNip(),
            'ktp_number' => fake('id_ID')->nik(),
            'fullname' => $fullname,
            'nickname' => explode(" ", $fullname)[0],
            'title_front' => fake()->title($gender),
            'title_back' => fake()->suffix(),
            'whatsapp_number' => fake('id_ID')->e164PhoneNumber(),
            'gender' => strtoupper($gender),
            'religion' => fake()->randomElement(['ISLAM', 'KRISTEN', 'KHATOLIK', 'BUDDHA', 'HINDU', 'KONGHUCU']),
            'marital_status' => fake()->randomElement(['MENIKAH', 'LAJANG', 'CERAI_HIDUP', 'CERAI_MATI']),
            'birthday' => fake()->date('Y-m-d'),
            'birthplace' => fake('id_ID')->city(),
            'blood_type' => fake()->randomElement(['A', 'B', 'AB', 'O']),
            'created_at' => now(),
            'created_by' => $user->id
        ];
    }
}
