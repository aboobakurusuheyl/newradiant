<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    // News Management Methods
    
    /**
     * Get all news articles
     */
    public function getNews(Request $request)
    {
        $query = News::with('author');

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->featured();
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by published status
        if ($request->has('published')) {
            if ($request->published === 'true') {
                $query->published();
            } elseif ($request->published === 'false') {
                $query->where('is_published', false);
            }
        }

        $news = $query->ordered()->paginate($request->get('per_page', 15));

        return response()->json($news);
    }

    /**
     * Create a new news article
     */
    public function createNews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['author_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']);

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news = News::create($data);

        return response()->json([
            'message' => 'News article created successfully',
            'news' => $news->load('author')
        ], 201);
    }

    /**
     * Update a news article
     */
    public function updateNews(Request $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'nullable|string|max:100',
            'category' => 'sometimes|required|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Update slug if title changed
        if ($request->has('title') && $request->title !== $news->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news->update($data);

        return response()->json([
            'message' => 'News article updated successfully',
            'news' => $news->fresh()->load('author')
        ]);
    }

    /**
     * Delete a news article
     */
    public function deleteNews(News $news)
    {
        // Delete image if exists
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return response()->json(['message' => 'News article deleted successfully']);
    }

    // Hero Section Management Methods

    /**
     * Get all hero sections
     */
    public function getHeroSections(Request $request)
    {
        $query = HeroSection::query();

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Filter by active status
        if ($request->has('active')) {
            if ($request->active === 'true') {
                $query->active();
            } elseif ($request->active === 'false') {
                $query->where('is_active', false);
            }
        }

        $heroSections = $query->ordered()->paginate($request->get('per_page', 15));

        return response()->json($heroSections);
    }

    /**
     * Create a new hero section
     */
    public function createHeroSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'type' => 'required|string|in:hero,announcement,promotion',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero-sections', 'public');
        }

        $heroSection = HeroSection::create($data);

        return response()->json([
            'message' => 'Hero section created successfully',
            'hero_section' => $heroSection
        ], 201);
    }

    /**
     * Update a hero section
     */
    public function updateHeroSection(Request $request, HeroSection $heroSection)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'type' => 'sometimes|required|string|in:hero,announcement,promotion',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($heroSection->image) {
                Storage::disk('public')->delete($heroSection->image);
            }
            $data['image'] = $request->file('image')->store('hero-sections', 'public');
        }

        $heroSection->update($data);

        return response()->json([
            'message' => 'Hero section updated successfully',
            'hero_section' => $heroSection->fresh()
        ]);
    }

    /**
     * Delete a hero section
     */
    public function deleteHeroSection(HeroSection $heroSection)
    {
        // Delete image if exists
        if ($heroSection->image) {
            Storage::disk('public')->delete($heroSection->image);
        }

        $heroSection->delete();

        return response()->json(['message' => 'Hero section deleted successfully']);
    }

    /**
     * Get public hero sections (for frontend display)
     */
    public function getPublicHeroSections(Request $request)
    {
        $query = HeroSection::active();

        // Filter by type if specified
        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Get limit if specified (for carousel)
        if ($request->has('limit')) {
            $heroSections = $query->ordered()->limit($request->get('limit'))->get();
        } else {
            $heroSections = $query->ordered()->get();
        }

        return response()->json([
            'data' => $heroSections,
            'total' => $heroSections->count()
        ]);
    }

    /**
     * Get content statistics
     */
    public function getContentStats()
    {
        $stats = [
            'total_news' => News::count(),
            'published_news' => News::published()->count(),
            'featured_news' => News::featured()->count(),
            'total_hero_sections' => HeroSection::count(),
            'active_hero_sections' => HeroSection::active()->count(),
            'news_categories' => News::select('category')->distinct()->pluck('category'),
            'hero_types' => HeroSection::select('type')->distinct()->pluck('type'),
        ];

        return response()->json($stats);
    }
}
