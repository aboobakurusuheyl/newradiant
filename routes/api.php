<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PaymentRequestController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\FixtureController;
use App\Http\Controllers\EnrollmentController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public enrollment form
Route::post('/enrollments', [EnrollmentController::class, 'store']);

// Public content routes
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{news}', [NewsController::class, 'show']);
Route::get('/fixtures', [FixtureController::class, 'index']);
Route::get('/fixtures/{fixture}', [FixtureController::class, 'show']);
Route::get('/players', [PlayerController::class, 'index']);
Route::get('/players/{player}', [PlayerController::class, 'show']);
Route::get('/players/position/{position}', [PlayerController::class, 'getByPosition']);
Route::get('/players/team/stats', [PlayerController::class, 'getTeamStats']);
Route::get('/hero-sections', [ContentController::class, 'getPublicHeroSections']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/coaching-staff', function (Request $request) {
    $coaches = \App\Models\User::where('role', 'coach')->get();
    return response()->json($coaches);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Member routes
    Route::get('/my-students', function (Request $request) {
        $user = $request->user();
        $students = \App\Models\Student::where('user_id', $user->id)
            ->with(['user', 'assignedCoach', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($students);
    });
    
    // Users (for coach selection)
    Route::get('/users', function (Request $request) {
        $role = $request->query('role');
        $query = \App\Models\User::query();
        
        if ($role) {
            $query->where('role', $role);
        }
        
        return response()->json($query->get());
    });
    
    // Student enrollment (Parents only) - Must come before apiResource
    Route::middleware(['role:parent'])->group(function () {
        Route::post('/students/enroll', [StudentController::class, 'enroll']);
        Route::get('/students/my-children', [StudentController::class, 'myChildren']);
        Route::get('/payment-requests/my-requests', [PaymentRequestController::class, 'getParentPaymentRequests']);
        Route::post('/payment-requests/{paymentRequest}/upload-receipt', [PaymentRequestController::class, 'uploadReceipt']);
    });
    
    // Student management (Admin/Coach only)
    Route::middleware(['role:admin,coach'])->group(function () {
        Route::apiResource('students', StudentController::class);
        Route::get('/students/{student}/ratings', [StudentController::class, 'ratings']);
        Route::post('/students/{student}/request-payment', [StudentController::class, 'requestPayment']);
        Route::post('/students/{student}/approve', [StudentController::class, 'approveStudent']);
        Route::post('/students/{student}/assign-coach', [StudentController::class, 'assignCoach']);
    });

    // Payment requests management (Admin/Coach only)
    Route::middleware(['role:admin,coach'])->group(function () {
        Route::apiResource('payment-requests', PaymentRequestController::class);
        Route::post('/payment-requests/{paymentRequest}/verify', [PaymentRequestController::class, 'verifyPayment']);
        Route::get('/students/{student}/payment-requests', [PaymentRequestController::class, 'getStudentPaymentRequests']);
    });

    // Store management (Admin only)
    Route::middleware(['role:admin'])->group(function () {
        // Admin-only product management routes
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        Route::get('/products/categories', [ProductController::class, 'categories']);
        Route::post('/products/{product}/stock', [ProductController::class, 'updateStock']);
        
        Route::apiResource('orders', OrderController::class);
        Route::get('/orders/statistics', [OrderController::class, 'statistics']);
        Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus']);
        Route::post('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus']);
    });

    // Content management (Admin only)
    Route::middleware(['role:admin'])->group(function () {
        // News management
        Route::get('/content/news', [ContentController::class, 'getNews']);
        Route::post('/content/news', [ContentController::class, 'createNews']);
        Route::put('/content/news/{news}', [ContentController::class, 'updateNews']);
        Route::delete('/content/news/{news}', [ContentController::class, 'deleteNews']);
        
        // Hero sections management
        Route::get('/content/hero-sections', [ContentController::class, 'getHeroSections']);
        Route::post('/content/hero-sections', [ContentController::class, 'createHeroSection']);
        Route::put('/content/hero-sections/{heroSection}', [ContentController::class, 'updateHeroSection']);
        Route::delete('/content/hero-sections/{heroSection}', [ContentController::class, 'deleteHeroSection']);
        
        // Content statistics
        Route::get('/content/stats', [ContentController::class, 'getContentStats']);
        
        // Enrollment management
        Route::get('/enrollments', [EnrollmentController::class, 'index']);
        Route::get('/enrollments/{enrollment}', [EnrollmentController::class, 'show']);
        Route::put('/enrollments/{enrollment}', [EnrollmentController::class, 'update']);
        Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy']);
    });

    // First team management (Admin only)
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/players', [PlayerController::class, 'store']);
        Route::put('/players/{player}', [PlayerController::class, 'update']);
        Route::delete('/players/{player}', [PlayerController::class, 'destroy']);
        Route::post('/players/{player}/captain', [PlayerController::class, 'updateCaptainStatus']);
    });
    
    // Schedule management (Admin/Coach only)
    Route::middleware(['role:admin,coach'])->group(function () {
        Route::apiResource('schedules', ScheduleController::class);
    });
    
    // Payment management
    Route::apiResource('payments', PaymentController::class);
    Route::post('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid']);
    
    // Rating management (Admin/Coach only)
    Route::middleware(['role:admin,coach'])->group(function () {
        Route::apiResource('ratings', RatingController::class);
    });
    
    // News management (Admin/Coach only)
    Route::middleware(['role:admin,coach'])->group(function () {
        Route::post('/news', [NewsController::class, 'store']);
        Route::put('/news/{news}', [NewsController::class, 'update']);
        Route::delete('/news/{news}', [NewsController::class, 'destroy']);
        Route::post('/news/{news}/publish', [NewsController::class, 'publish']);
    });
    
    // Fixture management (Admin/Coach only)
    Route::middleware(['role:admin,coach'])->group(function () {
        Route::post('/fixtures', [FixtureController::class, 'store']);
        Route::put('/fixtures/{fixture}', [FixtureController::class, 'update']);
        Route::delete('/fixtures/{fixture}', [FixtureController::class, 'destroy']);
        Route::post('/fixtures/{fixture}/update-result', [FixtureController::class, 'updateResult']);
    });
    
    // Dashboard data
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();
        
        $data = [
            'user' => $user,
            'role' => $user->role,
        ];
        
        if ($user->isStudent()) {
            $data['student'] = $user->student;
            $data['upcoming_schedules'] = Schedule::where('age_group', $user->student->age_group)
                ->where('date', '>=', now())
                ->orderBy('date')
                ->limit(5)
                ->get();
            $data['recent_ratings'] = $user->student->ratings()
                ->with('coach')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            $data['pending_payments'] = $user->student->payments()
                ->where('status', 'pending')
                ->get();
        } elseif ($user->isParent()) {
            $data['students'] = $user->guardian->students;
            $data['upcoming_schedules'] = Schedule::whereIn('age_group', $user->guardian->students->pluck('age_group'))
                ->where('date', '>=', now())
                ->orderBy('date')
                ->limit(5)
                ->get();
        } elseif ($user->isCoach() || $user->isAdmin()) {
            $data['students_count'] = Student::count();
            $data['upcoming_schedules'] = Schedule::where('coach_id', $user->id)
                ->where('date', '>=', now())
                ->orderBy('date')
                ->limit(5)
                ->get();
            $data['recent_ratings'] = Rating::with(['student', 'coach'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        return response()->json($data);
    });
});
