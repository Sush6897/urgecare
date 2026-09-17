<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('backend.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('backend.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author'       => 'nullable|string|max:100',
            'category'     => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'author', 'category', 'status', 'published_at']);

        // Slug
        $data['slug'] = $request->filled('slug')
            ? \Illuminate\Support\Str::slug($request->slug)
            : Blog::generateUniqueSlug($request->title);

        // Image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('backend.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author'       => 'nullable|string|max:100',
            'category'     => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'author', 'category', 'status', 'published_at']);

        // Slug
        $data['slug'] = $request->filled('slug')
            ? \Illuminate\Support\Str::slug($request->slug)
            : Blog::generateUniqueSlug($request->title, $blog->id);

        // Image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog deleted successfully.');
    }
}
