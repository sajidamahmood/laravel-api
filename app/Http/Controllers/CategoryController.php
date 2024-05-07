<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;




 class CategoryController extends Controller
{

    /**
 * @OA\Post(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Create a new category",
 *     description="Create a new category with the provided title and description.",
 *     operationId="createCategory",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "description"},
 *             @OA\Property(property="title", type="string", example="New Category"),
 *             @OA\Property(property="description", type="string", example="Description of the new category")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Category created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Category created successfully")
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */


    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
  {$request->validate([
    'title' => 'required|string',
    'description' => 'nullable|string',
   
  ]);
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }


/**
 * @OA\Get(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Get category by ID",
 *     description="Retrieve the category information by its ID.",
 *     operationId="getCategoryById",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the category to retrieve",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Category not found"
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */

 
    public function show($id)
    {
        return Category::findOrFail($id);
    }


/**
 * @OA\Put(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Update an existing category",
 *     description="Update the category with the provided ID, title, and description.",
 *     operationId="updateCategory",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the category to update",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "description"},
 *             @OA\Property(property="title", type="string", example="Updated Category"),
 *             @OA\Property(property="description", type="string", example="Updated description of the category")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Category updated successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Category not found"
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
 
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return $category;
    }

    /**
 * @OA\Delete(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Delete an existing category",
 *     description="Delete the category with the provided ID.",
 *     operationId="deleteCategory",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the category to delete",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Category deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Category not found"
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return 204;
    }
}


