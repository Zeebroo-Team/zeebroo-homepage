<?php

namespace App\Http\Controllers\Admin\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class DocImageController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:create docs|edit docs'),
        ];
    }

    // POST /admin/docs/images — a screenshot for the docs editor's "Screenshot" button; returns its site-relative URL
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $path = $request->file('image')->store('docs', 'public');

        return response()->json(['url' => parse_url(Storage::disk('public')->url($path), PHP_URL_PATH)]);
    }
}
