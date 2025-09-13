<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FixtureController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->get('limit', 20);
        
        if ($limit) {
            $fixtures = Fixture::orderBy('match_date', 'desc')
                ->orderBy('match_time', 'desc')
                ->limit($limit)
                ->get();
            
            return response()->json([
                'data' => $fixtures,
                'total' => $fixtures->count()
            ]);
        }
        
        $fixtures = Fixture::orderBy('match_date', 'desc')
            ->orderBy('match_time', 'desc')
            ->paginate(20);
        
        return response()->json($fixtures);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'opponent' => 'required|string|max:255',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'venue' => 'required|string|max:255',
            'type' => 'required|in:home,away,neutral',
            'competition' => 'nullable|string|max:255',
            'age_group' => 'nullable|string|in:U8,U10,U12,U14,U16,U18,Senior',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $fixture = Fixture::create($request->all());

        return response()->json([
            'message' => 'Fixture created successfully',
            'fixture' => $fixture
        ], 201);
    }

    public function show(Fixture $fixture)
    {
        return response()->json($fixture);
    }

    public function update(Request $request, Fixture $fixture)
    {
        $validator = Validator::make($request->all(), [
            'opponent' => 'sometimes|string|max:255',
            'match_date' => 'sometimes|date',
            'match_time' => 'sometimes|date_format:H:i',
            'venue' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:home,away,neutral',
            'competition' => 'nullable|string|max:255',
            'age_group' => 'nullable|string|in:U8,U10,U12,U14,U16,U18,Senior',
            'our_score' => 'nullable|integer|min:0',
            'opponent_score' => 'nullable|integer|min:0',
            'status' => 'sometimes|in:scheduled,in_progress,completed,cancelled,postponed',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $fixture->update($request->all());

        return response()->json([
            'message' => 'Fixture updated successfully',
            'fixture' => $fixture
        ]);
    }

    public function destroy(Fixture $fixture)
    {
        $fixture->delete();
        return response()->json(['message' => 'Fixture deleted successfully']);
    }

    public function updateResult(Request $request, Fixture $fixture)
    {
        $validator = Validator::make($request->all(), [
            'our_score' => 'required|integer|min:0',
            'opponent_score' => 'required|integer|min:0',
            'status' => 'sometimes|in:completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $fixture->update([
            'our_score' => $request->our_score,
            'opponent_score' => $request->opponent_score,
            'status' => 'completed'
        ]);

        return response()->json([
            'message' => 'Match result updated successfully',
            'fixture' => $fixture
        ]);
    }
}
