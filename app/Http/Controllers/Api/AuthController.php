<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:student,parent,coach,admin',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            // Student specific fields
            'age_group' => 'required_if:role,student|string|in:U8,U10,U12,U14,U16,U18,Senior',
            'jersey_number' => 'nullable|string|max:10',
            'position' => 'nullable|string|in:goalkeeper,defender,midfielder,forward',
            'medical_notes' => 'nullable|string|max:1000',
            // Guardian specific fields
            'relation' => 'required_if:role,parent|string|in:father,mother,guardian,other',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ]);

        // Create role-specific records
        if ($request->role === 'student') {
            // For students, we need a guardian first
            // This is a simplified version - in production, you'd handle guardian creation separately
            $guardian = Guardian::create([
                'user_id' => $user->id, // This would be the guardian's user_id in real scenario
                'relation' => 'self',
                'phone' => $request->phone,
            ]);

            Student::create([
                'user_id' => $user->id,
                'date_of_birth' => $request->date_of_birth,
                'age_group' => $request->age_group,
                'guardian_id' => $guardian->id,
                'jersey_number' => $request->jersey_number,
                'position' => $request->position,
                'medical_notes' => $request->medical_notes,
            ]);
        } elseif ($request->role === 'parent') {
            Guardian::create([
                'user_id' => $user->id,
                'relation' => $request->relation,
                'phone' => $request->phone,
                'emergency_contact' => $request->emergency_contact,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        
        // Load relationships based on role
        if ($user->isStudent()) {
            $user->load('student.guardian');
        } elseif ($user->isParent()) {
            $user->load('guardian.students');
        }

        return response()->json([
            'user' => $user
        ]);
    }
}
