<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request, ?Category $category = null): View
    {
        if (! Schema::hasTable('products')) {
            return view('welcome', ['products' => collect(), 'categories' => collect()]);
        }

        $products = Product::query()
            ->with('category')
            ->where('status', 'tersedia')
            ->when($request->string('q')->trim()->value(), fn ($query, string $search) => $query->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }))
            ->when($category, fn ($query) => $query->where('category_id', $category->id))
            ->when(! $category && $request->string('category')->trim()->value(), fn ($query, string $slug) => $query->whereHas('category', fn ($query) => $query->where('slug', $slug)))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('welcome', [
            'products' => $products,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function category(Request $request, Category $category): View
    {
        return $this->index($request, $category);
    }
}
