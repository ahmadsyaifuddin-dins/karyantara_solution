<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'bg_color' => 'required|string|max:50',
            'text_color' => 'required|string|max:50',
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'bg_color' => $request->bg_color,
            'text_color' => $request->text_color,
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil ditambahkan!');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'bg_color' => 'required|string|max:50',
            'text_color' => 'required|string|max:50',
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'bg_color' => $request->bg_color,
            'text_color' => $request->text_color,
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil diperbarui!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil dihapus!');
    }
}