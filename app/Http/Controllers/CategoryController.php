<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a list of active categories along with the first active product of each category.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->with(['products' => function($query) {
                $query->where('is_active', true)
                    ->orderBy('created_at', 'asc')
                    ->limit(1);
            }])
            ->get();

        return Inertia::render('Categories/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Display a specific category and paginate its active products.
     *
     * @param Request $request
     * @param string $slug The slug identifier of the category
     * @return \Inertia\Response
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(Request $request, $slug)
    {
        // Find the category by slug with active products
        $category = Category::where('slug', $slug)
            ->with(['products' => function($query) {
                $query->where('is_active', true)
                    ->orderBy('created_at', 'asc');
            }])
            ->firstOrFail();

        // Paginate the products of the category
        $products = $category->products()
            ->where('is_active', true)
            ->orderBy('created_at', 'asc')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Categories/Show', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
