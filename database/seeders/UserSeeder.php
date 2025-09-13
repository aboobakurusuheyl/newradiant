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

        // Create Head Coach
        $coach = User::create([
            'name' => 'Sobah Mohamed',
            'email' => 'coach@newradiant.mv',
            'password' => Hash::make('password'),
            'role' => 'coach',
            'phone' => '+960 987-6543',
            'address' => 'Malé, Maldives',
        ]);

        // Create Guardian
        $guardianUser = User::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed.ali@example.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
            'phone' => '+960 555-1234',
            'address' => 'Malé, Maldives',
        ]);

        $guardian = Guardian::create([
            'user_id' => $guardianUser->id,
            'relation' => 'father',
            'phone' => '+960 555-1234',
            'emergency_contact' => '+960 555-5678',
        ]);

        // Create Students
        $student1 = User::create([
            'name' => 'Mohamed Ahmed',
            'email' => 'mohamed.ahmed@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+960 555-1111',
            'date_of_birth' => '2010-05-15',
            'address' => 'Malé, Maldives',
        ]);

        Student::create([
            'user_id' => $student1->id,
            'date_of_birth' => '2010-05-15',
            'age_group' => 'U14',
            'guardian_id' => $guardian->id,
            'jersey_number' => '10',
            'position' => 'midfielder',
            'medical_notes' => 'No known allergies',
        ]);

        $student2 = User::create([
            'name' => 'Ibrahim Hassan',
            'email' => 'ibrahim.hassan@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+960 555-2222',
            'date_of_birth' => '2012-08-20',
            'address' => 'Malé, Maldives',
        ]);

        Student::create([
            'user_id' => $student2->id,
            'date_of_birth' => '2012-08-20',
            'age_group' => 'U12',
            'guardian_id' => $guardian->id,
            'jersey_number' => '7',
            'position' => 'forward',
            'medical_notes' => 'Asthma - carry inhaler',
        ]);

        // Create another Guardian
        $guardian2User = User::create([
            'name' => 'Aminath Ibrahim',
            'email' => 'aminath.ibrahim@example.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
            'phone' => '+960 555-3333',
            'address' => 'Malé, Maldives',
        ]);

        $guardian2 = Guardian::create([
            'user_id' => $guardian2User->id,
            'relation' => 'mother',
            'phone' => '+960 555-3333',
            'emergency_contact' => '+960 555-4444',
        ]);

        $student3 = User::create([
            'name' => 'Ali Mohamed',
            'email' => 'ali.mohamed@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+960 555-5555',
            'date_of_birth' => '2008-12-10',
            'address' => 'Malé, Maldives',
        ]);

        Student::create([
            'user_id' => $student3->id,
            'date_of_birth' => '2008-12-10',
            'age_group' => 'U16',
            'guardian_id' => $guardian2->id,
            'jersey_number' => '1',
            'position' => 'goalkeeper',
            'medical_notes' => 'No medical issues',
        ]);
    }
}
