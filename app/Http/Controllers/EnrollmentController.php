<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    /**
     * Show the enrollment form
     */
    public function create()
    {
        return view('enrollment.create');
    }

    /**
     * Store a new enrollment submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:M,F',
            'id_number' => 'nullable|string|max:255',
            'home_address' => 'required|string|max:1000',
            'telephone_no' => 'required|string|max:20',
            'nationality' => 'required|string|max:255',
            'school_attended' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_telephone' => 'required|string|max:20',
            'photograph' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heard_about' => 'required|in:newspaper,family_friends,social_media,other',
            'heard_about_other' => 'required_if:heard_about,other|nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            
            // Handle photograph upload
            if ($request->hasFile('photograph')) {
                $photographPath = $request->file('photograph')->store('enrollment-photos', 'public');
                $data['photograph_path'] = $photographPath;
            }

            $enrollment = Enrollment::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment application submitted successfully! We will contact you soon.',
                'enrollment_id' => $enrollment->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your application. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: List all enrollments
     */
    public function index(Request $request)
    {
        $query = Enrollment::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%");
            });
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($enrollments);
    }

    /**
     * Admin: Show specific enrollment
     */
    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment);
    }

    /**
     * Admin: Update enrollment status
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected',
            'application_received_by' => 'nullable|string|max:255',
            'reg_no' => 'nullable|string|max:255',
            'squad' => 'nullable|string|max:255',
            'centre' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $enrollment->update($request->only([
            'status',
            'application_received_by',
            'reg_no',
            'squad',
            'centre',
            'remarks'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Enrollment updated successfully',
            'enrollment' => $enrollment
        ]);
    }

    /**
     * Admin: Delete enrollment
     */
    public function destroy(Enrollment $enrollment)
    {
        // Delete photograph if exists
        if ($enrollment->photograph_path) {
            Storage::disk('public')->delete($enrollment->photograph_path);
        }

        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully'
        ]);
    }
}
