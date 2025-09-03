<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of active products with optional filters and sorting.
     *
     * Filters supported via query parameters:
     * - q: search by product name
     * - category: filter by category ID
     * - sort_by: sort products (price_asc, price_desc)
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function home(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $query = Product::query()->where('is_active', true);

        $request->whenFilled('q', fn($q) => $query->where('name', 'like', "%{$q}%"));
        $request->whenFilled('category', fn($c) => $query->where('category_id', $c));

        if ($sort = $request->input('sort_by')) {
            match($sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                default => null,
            };
        }

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Home', [
            'categories' => $categories,
            'products' => $products,
            'filters' => $request->only('q','category','sort_by')
        ]);
    }

    /**
     * Display a listing of active products with optional filters and sorting.
     *
     * Filters supported via query parameters:
     * - q: search by product name
     * - category: filter by category ID
     * - sort_by: sort products (price_asc, price_desc)
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $query = Product::query()->where('is_active', true);

        $request->whenFilled('q', fn($q) => $query->where('name', 'like', "%{$q}%"));
        $request->whenFilled('category', fn($c) => $query->where('category_id', $c));

        if ($sort = $request->input('sort_by')) {
            match($sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                default => null,
            };
        }

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Products/Index', [
            'categories' => $categories,
            'products' => $products,
            'filters' => $request->only('q','category','sort_by')
        ]);
    }

    /**
     * Display the specified product along with related products.
     *
     * @param Request $request
     * @param string $slug The slug identifier of the product
     * @return \Inertia\Response
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return Inertia::render('Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
