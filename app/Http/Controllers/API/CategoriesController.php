<?php

namespace IntelGUA\FoodPoint\Http\Controllers\API;

use Illuminate\Http\Request;
use IntelGUA\FoodPoint\Http\Controllers\Controller;
use IntelGUA\FoodPoint\Models\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);

        if(is_null($categories))
        {
            return response()->json([
                'success' => false,
                'message' => 'No category records found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $categories,
            'message' => 'Categories retrieved successfully.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|unique:categories',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'    => $validator->errors(),
                'message' => 'Something went wrong in the validation of the category resource.',
            ], 406);
        }

        $category = Category::create($data);

        return response()->json([
            'success' => true,
            'data'    => $category->toArray(),
            'message' => 'Category created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    $category = Category::find($id);

    if (is_null($category)) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
    }

        return response()->json([
            'success' => true,
            'data'    => $category->toArray(),
            'message' => 'Category retrieved successfully.',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if (is_null($category)) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|unique:categories',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'    => $validator->errors(),
                'message' => 'Something went wrong in the validation of the category resource.',
            ], 406);
        }

        $category->name         = $data['name'];
        $category->description  = $data['description'];
        $category->save();

        return response()->json([
            'success' => true,
            'data'    => $category->toArray(),
            'message' => 'Category updated successfully.',
        ], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        if (is_null($category)) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'data'    => $category->toArray(),
            'message' => 'Category deleted successfully.',
        ], 204);
    }
}
