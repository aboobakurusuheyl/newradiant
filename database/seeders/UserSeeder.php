<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@newradiant.mv',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+960 123-4567',
            'address' => 'Malé, Maldives',
        ]);

        // Create Demo Member (for testing)
        $demoMember = User::create([
            'name' => 'Demo Member',
            'email' => 'demo@newradiant.mv',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'phone' => '+960 123-4567',
            'date_of_birth' => '1990-01-01',
            'address' => 'Malé, Maldives',
        ]);

        // Create Guardian for demo member
        $guardian = Guardian::create([
            'user_id' => $demoMember->id,
            'relation' => 'parent',
            'phone' => '+960 123-4567',
            'emergency_contact' => '+960 987-6543',
        ]);

        // Create Students for demo member
        Student::create([
            'user_id' => $demoMember->id,
            'date_of_birth' => '2010-05-15',
            'age_group' => 'U-15',
            'guardian_id' => $guardian->id,
            'jersey_number' => '10',
            'position' => 'Midfielder',
            'medical_notes' => 'No known allergies',
            'is_active' => true,
            'enrollment_status' => 'approved',
            'assigned_coach_id' => $admin->id,
            'approved_at' => now(),
        ]);

        Student::create([
            'user_id' => $demoMember->id,
            'date_of_birth' => '2012-08-20',
            'age_group' => 'U-12',
            'guardian_id' => $guardian->id,
            'jersey_number' => '7',
            'position' => 'Forward',
            'medical_notes' => 'Asthma - carry inhaler',
            'is_active' => true,
            'enrollment_status' => 'approved',
            'assigned_coach_id' => $admin->id,
            'approved_at' => now(),
        ]);

        Student::create([
            'user_id' => $demoMember->id,
            'date_of_birth' => '2014-03-10',
            'age_group' => 'U-10',
            'guardian_id' => $guardian->id,
            'jersey_number' => '3',
            'position' => 'Defender',
            'medical_notes' => 'No medical issues',
            'is_active' => false,
            'enrollment_status' => 'pending',
        ]);

        // Create additional members for variety
        $member1 = User::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed.ali@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '+960 555-1234',
            'date_of_birth' => '1985-06-15',
            'address' => 'Malé, Maldives',
        ]);

        $guardian1 = Guardian::create([
            'user_id' => $member1->id,
            'relation' => 'father',
            'phone' => '+960 555-1234',
            'emergency_contact' => '+960 555-5678',
        ]);

        Student::create([
            'user_id' => $member1->id,
            'date_of_birth' => '2011-03-20',
            'age_group' => 'U-14',
            'guardian_id' => $guardian1->id,
            'jersey_number' => '5',
            'position' => 'Defender',
            'medical_notes' => 'No known allergies',
            'is_active' => true,
            'enrollment_status' => 'approved',
            'assigned_coach_id' => $admin->id,
            'approved_at' => now(),
        ]);
    }
}
