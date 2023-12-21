<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function createCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $category = Category::create($data);
        return response()->json([
            'success' => true,
            'data' => $category,
        ], 200);
    }
}
