<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Player::query();

        // Filter by position
        if ($request->has('position') && $request->position !== 'all') {
            $query->byPosition($request->position);
        }

        // Filter by active status
        if ($request->has('active')) {
            if ($request->active === 'true') {
                $query->active();
            } elseif ($request->active === 'false') {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%")
                  ->orWhere('jersey_number', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'jersey_number');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $players = $query->paginate($request->get('per_page', 25));

        return response()->json($players);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'jersey_number' => 'required|integer|min:1|max:99|unique:players,jersey_number',
            'position' => 'required|string|in:Goalkeeper,Defender,Midfielder,Forward',
            'position_detail' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'nationality' => 'required|string|max:255',
            'height' => 'nullable|integer|min:100|max:250',
            'weight' => 'nullable|integer|min:30|max:150',
            'preferred_foot' => 'nullable|string|in:Left,Right,Both',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biography' => 'nullable|string',
            'career_stats' => 'nullable|array',
            'achievements' => 'nullable|array',
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date|after:contract_start',
            'is_active' => 'boolean',
            'is_captain' => 'boolean',
            'is_vice_captain' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('players', 'public');
        }

        // Ensure only one captain
        if ($request->is_captain) {
            Player::where('is_captain', true)->update(['is_captain' => false]);
        }

        // Ensure only one vice captain
        if ($request->is_vice_captain) {
            Player::where('is_vice_captain', true)->update(['is_vice_captain' => false]);
        }

        $player = Player::create($data);

        return response()->json([
            'message' => 'Player created successfully',
            'player' => $player
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return response()->json($player);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'jersey_number' => 'sometimes|required|integer|min:1|max:99|unique:players,jersey_number,' . $player->id,
            'position' => 'sometimes|required|string|in:Goalkeeper,Defender,Midfielder,Forward',
            'position_detail' => 'nullable|string|max:255',
            'date_of_birth' => 'sometimes|required|date|before:today',
            'nationality' => 'sometimes|required|string|max:255',
            'height' => 'nullable|integer|min:100|max:250',
            'weight' => 'nullable|integer|min:30|max:150',
            'preferred_foot' => 'nullable|string|in:Left,Right,Both',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biography' => 'nullable|string',
            'career_stats' => 'nullable|array',
            'achievements' => 'nullable|array',
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date|after:contract_start',
            'is_active' => 'boolean',
            'is_captain' => 'boolean',
            'is_vice_captain' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($player->photo) {
                Storage::disk('public')->delete($player->photo);
            }
            $data['photo'] = $request->file('photo')->store('players', 'public');
        }

        // Ensure only one captain
        if ($request->is_captain && !$player->is_captain) {
            Player::where('is_captain', true)->update(['is_captain' => false]);
        }

        // Ensure only one vice captain
        if ($request->is_vice_captain && !$player->is_vice_captain) {
            Player::where('is_vice_captain', true)->update(['is_vice_captain' => false]);
        }

        $player->update($data);

        return response()->json([
            'message' => 'Player updated successfully',
            'player' => $player->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        // Delete photo if exists
        if ($player->photo) {
            Storage::disk('public')->delete($player->photo);
        }

        $player->delete();

        return response()->json(['message' => 'Player deleted successfully']);
    }

    /**
     * Get players by position
     */
    public function getByPosition($position)
    {
        $players = Player::active()
            ->byPosition($position)
            ->ordered()
            ->get();

        return response()->json($players);
    }

    /**
     * Get team statistics
     */
    public function getTeamStats()
    {
        $stats = [
            'total_players' => Player::count(),
            'active_players' => Player::active()->count(),
            'goalkeepers' => Player::active()->byPosition('Goalkeeper')->count(),
            'defenders' => Player::active()->byPosition('Defender')->count(),
            'midfielders' => Player::active()->byPosition('Midfielder')->count(),
            'forwards' => Player::active()->byPosition('Forward')->count(),
            'captain' => Player::captains()->active()->first(),
            'vice_captain' => Player::where('is_vice_captain', true)->active()->first(),
            'average_age' => Player::active()->get()->avg('age'),
        ];

        return response()->json($stats);
    }

    /**
     * Update player captain status
     */
    public function updateCaptainStatus(Request $request, Player $player)
    {
        $validator = Validator::make($request->all(), [
            'is_captain' => 'required|boolean',
            'is_vice_captain' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ensure only one captain
        if ($request->is_captain) {
            Player::where('is_captain', true)->update(['is_captain' => false]);
        }

        // Ensure only one vice captain
        if ($request->is_vice_captain) {
            Player::where('is_vice_captain', true)->update(['is_vice_captain' => false]);
        }

        $player->update([
            'is_captain' => $request->is_captain,
            'is_vice_captain' => $request->is_vice_captain,
        ]);

        return response()->json([
            'message' => 'Captain status updated successfully',
            'player' => $player->fresh()
        ]);
    }
}
