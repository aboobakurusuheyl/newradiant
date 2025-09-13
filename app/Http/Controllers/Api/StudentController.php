<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Guardian;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'guardian.user', 'paymentRequests', 'assignedCoach'])->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:500',
            'age_group' => 'required|string|in:U8,U10,U12,U14,U16,U18,Senior',
            'jersey_number' => 'nullable|string|max:10',
            'position' => 'nullable|string|in:goalkeeper,defender,midfielder,forward',
            'medical_notes' => 'nullable|string|max:1000',
            'guardian_id' => 'required|exists:guardians,id',
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
            'password' => bcrypt($request->password),
            'role' => 'student',
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'date_of_birth' => $request->date_of_birth,
            'age_group' => $request->age_group,
            'guardian_id' => $request->guardian_id,
            'jersey_number' => $request->jersey_number,
            'position' => $request->position,
            'medical_notes' => $request->medical_notes,
        ]);

        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student->load(['user', 'guardian.user'])
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json($student->load(['user', 'guardian.user', 'payments', 'ratings.coach']));
    }

    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'age_group' => 'sometimes|string|in:U8,U10,U12,U14,U16,U18,Senior',
            'jersey_number' => 'nullable|string|max:10',
            'position' => 'nullable|string|in:goalkeeper,defender,midfielder,forward',
            'medical_notes' => 'nullable|string|max:1000',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update user data
        $student->user->update($request->only(['name', 'email', 'phone', 'address']));

        // Update student data
        $student->update($request->only([
            'age_group', 'jersey_number', 'position', 'medical_notes', 'is_active'
        ]));

        return response()->json([
            'message' => 'Student updated successfully',
            'student' => $student->load(['user', 'guardian.user'])
        ]);
    }

    public function destroy(Student $student)
    {
        $student->user->delete(); // This will cascade delete the student
        return response()->json(['message' => 'Student deleted successfully']);
    }

    public function ratings(Student $student)
    {
        $ratings = $student->ratings()->with('coach')->orderBy('created_at', 'desc')->get();
        return response()->json($ratings);
    }

    public function enroll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'childName' => 'required|string|max:255',
            'dateOfBirth' => 'required|date|before:today',
            'gender' => 'required|string|in:male,female',
            'ageGroup' => 'required|string|in:U-12,U-15,U-18',
            'preferredPosition' => 'nullable|string|in:goalkeeper,defender,midfielder,forward,any',
            'jerseyNumber' => 'nullable|integer|min:1|max:99',
            'experience' => 'nullable|string|max:1000',
            'medicalConditions' => 'nullable|string|max:1000',
            'emergencyContactName' => 'required|string|max:255',
            'emergencyContactPhone' => 'required|string|max:20',
            'emergencyContactRelation' => 'required|string|in:parent,guardian,grandparent,sibling,other',
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'transaction_reference' => 'nullable|string|max:100',
            'payment_date' => 'required|date',
            'payment_notes' => 'nullable|string',
            'receipt' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get the current parent user
            $parent = $request->user();
            $guardian = $parent->guardian;

            if (!$guardian) {
                return response()->json([
                    'message' => 'Guardian profile not found'
                ], 404);
            }

            // Create a temporary email for the child (will be updated when approved)
            $tempEmail = 'temp_' . time() . '_' . strtolower(str_replace(' ', '', $request->childName)) . '@newradiant.mv';

            // Create user account for the child
            $childUser = User::create([
                'name' => $request->childName,
                'email' => $tempEmail,
                'password' => bcrypt('temp_password_' . time()), // Temporary password
                'role' => 'student',
                'date_of_birth' => $request->dateOfBirth,
                'is_active' => false, // Will be activated when approved
            ]);

            // Create student record
            $student = Student::create([
                'user_id' => $childUser->id,
                'date_of_birth' => $request->dateOfBirth,
                'age_group' => $request->ageGroup,
                'guardian_id' => $guardian->id,
                'jersey_number' => $request->jerseyNumber,
                'position' => $request->preferredPosition === 'any' ? null : $request->preferredPosition,
                'medical_notes' => $request->medicalConditions,
                'experience' => $request->experience,
                'emergency_contact_name' => $request->emergencyContactName,
                'emergency_contact_phone' => $request->emergencyContactPhone,
                'emergency_contact_relation' => $request->emergencyContactRelation,
                'enrollment_status' => 'pending', // New field for enrollment status
                'is_active' => false,
            ]);

            // Handle receipt upload
            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('receipts', 'public');
            }

            // Create payment request
            $paymentRequest = PaymentRequest::create([
                'student_id' => $student->id,
                'requested_by' => $parent->id, // Parent who submitted
                'amount' => $request->payment_amount,
                'currency' => 'MVR',
                'description' => 'Academy enrollment fee - ' . $request->childName,
                'account_number' => 'N/A', // Will be updated by admin
                'bank_name' => 'N/A', // Will be updated by admin
                'due_date' => now()->addDays(30), // 30 days from now
                'status' => 'paid', // Mark as paid since parent uploaded receipt
                'receipt_path' => $receiptPath,
                'paid_at' => $request->payment_date,
                'parent_notes' => $request->payment_notes,
            ]);

            return response()->json([
                'message' => 'Child enrolled successfully with payment. You will be notified once the enrollment and payment are reviewed.',
                'student' => $student->load(['user', 'guardian.user', 'paymentRequests']),
                'payment_request' => $paymentRequest
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to submit enrollment. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function myChildren(Request $request)
    {
        try {
            $parent = $request->user();
            $guardian = $parent->guardian;

            if (!$guardian) {
                return response()->json([
                    'message' => 'Guardian profile not found'
                ], 404);
            }

            $children = Student::where('guardian_id', $guardian->id)
                ->with(['user'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($children);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to load children',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function requestPayment(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'description' => 'required|string|max:1000',
            'account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:100',
            'due_date' => 'required|date|after:today',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paymentRequest = PaymentRequest::create([
                'student_id' => $student->id,
                'requested_by' => $request->user()->id,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'description' => $request->description,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'due_date' => $request->due_date,
                'admin_notes' => $request->admin_notes,
            ]);

            return response()->json([
                'message' => 'Payment request created successfully',
                'payment_request' => $paymentRequest->load(['student.user', 'requestedBy'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create payment request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approveStudent(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'approval_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if payment is verified
            $verifiedPayment = $student->paymentRequests()
                ->where('status', 'verified')
                ->exists();

            if (!$verifiedPayment) {
                return response()->json([
                    'message' => 'Cannot approve student without verified payment'
                ], 400);
            }

            $student->update([
                'enrollment_status' => 'approved',
                'is_active' => true,
                'approved_at' => now(),
                'approval_notes' => $request->approval_notes,
            ]);

            return response()->json([
                'message' => 'Student approved successfully',
                'student' => $student->load(['user', 'guardian.user', 'assignedCoach'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to approve student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function assignCoach(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'coach_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $coach = User::find($request->coach_id);
            
            if (!$coach->isCoach()) {
                return response()->json([
                    'message' => 'Selected user is not a coach'
                ], 400);
            }

            $student->update([
                'assigned_coach_id' => $request->coach_id,
            ]);

            return response()->json([
                'message' => 'Coach assigned successfully',
                'student' => $student->load(['user', 'guardian.user', 'assignedCoach'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to assign coach',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
