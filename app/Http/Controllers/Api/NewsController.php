<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        
        if ($limit) {
            $news = News::published()
                ->with('author')
                ->orderBy('published_at', 'desc')
                ->limit($limit)
                ->get();
            
            return response()->json([
                'data' => $news,
                'total' => $news->count()
            ]);
        }
        
        $news = News::published()
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return response()->json($news);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,academy,match,announcement',
            'featured_image' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'type' => $request->type,
            'featured_image' => $request->featured_image,
            'is_published' => $request->is_published ?? false,
            'published_at' => $request->published_at ?? now(),
            'author_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'News created successfully',
            'news' => $news->load('author')
        ], 201);
    }

    public function show(News $news)
    {
        return response()->json($news->load('author'));
    }

    public function update(Request $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'type' => 'sometimes|in:general,academy,match,announcement',
            'featured_image' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['title', 'content', 'type', 'featured_image', 'is_published', 'published_at']);
        
        if ($request->has('title')) {
            $data['slug'] = Str::slug($request->title);
        }

        $news->update($data);

        return response()->json([
            'message' => 'News updated successfully',
            'news' => $news->load('author')
        ]);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(['message' => 'News deleted successfully']);
    }

    public function publish(News $news)
    {
        $news->update([
            'is_published' => true,
            'published_at' => now()
        ]);

        return response()->json([
            'message' => 'News published successfully',
            'news' => $news
        ]);
    }
}
