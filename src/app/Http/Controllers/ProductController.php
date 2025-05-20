<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate(6);

        return view('products.index', [
            'products' => $products,
            'keyword' => '',
            'order' => '',
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $order = $request->input('sort', '');

        $query = Product::query();

        if ($keyword !== '') {
            $query->where('name','LIKE',"%{$keyword}%");
        }

        if ($order === 'high') {
            $query->orderByDesc('price');
        } elseif ($order === 'low') {
            $query->orderBy('price');
        }

        $products = $query->paginate(6)->withQueryString();

        return view('products.index', compact('products', 'keyword', 'order'));
    }

    public function edit(Product $product)
    {
        $seasons = Season::all();

        $product->load('seasons');

        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(ProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);

            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->fill($request->only([
            'name', 'price', 'description'
        ]));

        $product->save();

        $product->seasons()->sync($request->input('season', []));

        return redirect()->route('products.index')
        ->with('success', '商品を更新しました');
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        $seasons = $product->seasons;

        return view('products.show', compact('product', 'seasons'));
    }

    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $request->file('image')->store('public/images'),
            ]);

            $product->seasons()->attach($request->seasons);
        });

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);

        $product->delete();

        return redirect()->route('products.index')
        ->with('success', '商品を削除しました');
    }

}
