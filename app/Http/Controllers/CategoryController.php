<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Jobs\LogTotalCategoryJob;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('id')->take(10)->get(); // fetch 10 categories in descending order of id
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        \Log::info("Job executed!");

        $category = Category::create($request->all());

        // Dispatch job
        LogTotalCategoryJob::dispatch();

        return redirect()->back()->with('success', 'Category created successfully!');
    }
}
