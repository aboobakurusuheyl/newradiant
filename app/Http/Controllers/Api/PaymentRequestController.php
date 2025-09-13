<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentRequestController extends Controller
{
    public function index()
    {
        $paymentRequests = PaymentRequest::with(['student.user', 'requestedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($paymentRequests);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
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

        $paymentRequest = PaymentRequest::create([
            'student_id' => $request->student_id,
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
    }

    public function show(PaymentRequest $paymentRequest)
    {
        return response()->json($paymentRequest->load(['student.user', 'requestedBy']));
    }

    public function uploadReceipt(Request $request, PaymentRequest $paymentRequest)
    {
        $validator = Validator::make($request->all(), [
            'receipt' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'parent_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Store the receipt file
        $receiptPath = $request->file('receipt')->store('receipts', 'public');

        $paymentRequest->update([
            'receipt_path' => $receiptPath,
            'parent_notes' => $request->parent_notes,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json([
            'message' => 'Receipt uploaded successfully',
            'payment_request' => $paymentRequest->load(['student.user', 'requestedBy'])
        ]);
    }

    public function verifyPayment(Request $request, PaymentRequest $paymentRequest)
    {
        $validator = Validator::make($request->all(), [
            'verified' => 'required|boolean',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->verified) {
            $paymentRequest->update([
                'status' => 'verified',
                'verified_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);
        } else {
            $paymentRequest->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes,
            ]);
        }

        return response()->json([
            'message' => $request->verified ? 'Payment verified successfully' : 'Payment rejected',
            'payment_request' => $paymentRequest->load(['student.user', 'requestedBy'])
        ]);
    }

    public function getStudentPaymentRequests(Student $student)
    {
        $paymentRequests = $student->paymentRequests()
            ->with(['requestedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($paymentRequests);
    }

    public function getParentPaymentRequests(Request $request)
    {
        $parent = $request->user();
        $guardian = $parent->guardian;

        if (!$guardian) {
            return response()->json([
                'message' => 'Guardian profile not found'
            ], 404);
        }

        $paymentRequests = PaymentRequest::whereHas('student', function ($query) use ($guardian) {
            $query->where('guardian_id', $guardian->id);
        })
        ->with(['student.user', 'requestedBy'])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($paymentRequests);
    }
}