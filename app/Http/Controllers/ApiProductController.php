<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;




class ApiProductController extends Controller
{
 

  public function index(){$products = Product::all();
      return response()->json($products);}

    
/**
 * @OA\Post(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Create a new product",
 *     description="Create a new product with the specified details.",
 *     operationId="index",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Product details",
 *         @OA\JsonContent(
 *             required={"name", "description", "price", "stock", "timestamp"},
 *             @OA\Property(property="name", type="string", example="Product Name", description="Product name"),
 *             @OA\Property(property="description", type="string", example="Product Description", description="Product description"),
 *             @OA\Property(property="price", type="number", format="float", example=10.99, description="Product price"),
 *             @OA\Property(property="stock", type="integer", example=100, description="Product stock"),
 *             @OA\Property(property="timestamp", type="string", format="date-time", example="2024-05-06 12:00:00", description="Timestamp")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Product created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Product created successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object", example={
 *                 "name": {"The name field is required."},
 *                 "description": {"The description field is required."},
 *                 "price": {"The price field is required."},
 *                 "stock": {"The stock field is required."},
 *                 "timestamp": {"The timestamp field is required."}
 *             })
 *         )
 *     )
 * )
 */
  public function store(Request $request)
  {$request->validate([
    'name' => 'required|string',
    'description' => 'nullable|string',
    'price' => 'required|numeric',
    'stock' => 'required|integer',// Add validation rules for other fields]);
    'categories' => 'required|array',
  ]);
        $product = Product::create($request->all());

        $product->categories()->attach($request['categories']);
        
    return response()->json(['product' => $product->load('categories')], 201);
    }
  
/**
 * @OA\Get(
 *     path="/api/Products/{id}",
 *     tags={"Products"},
 *     summary="Get product by ID",
 *     description="Retrieve the product information by its ID.",
 *     operationId="getProductById",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the product to retrieve",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="product not found"
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */


    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        return response()->json(['product' => $product]);
    }
    

    /**
     * @OA\Put(
      *     path="/api/products/{id}",
      *     tags={"Products"},
      *     summary="Update an existing product",
      *     description="Update an existing product with the specified details.",
      *     operationId="updateProduct",
      *     @OA\Parameter(
      *         name="id",
      *         in="path",
      *         required=true,
      *         description="ID of the product to update",
      *         @OA\Schema(type="integer", format="int64")
      *     ),
      *     @OA\RequestBody(
      *         required=true,
      *         description="Product details",
      *         @OA\JsonContent(
      *             @OA\Property(property="name", type="string", example="Updated Product Name", description="Product name"),
      *             @OA\Property(property="description", type="string", example="Updated Product Description", description="Product description"),
      *             @OA\Property(property="price", type="number", format="float", example=19.99, description="Product price"),
      *             @OA\Property(property="stock", type="integer", example=50, description="Product stock"),
      *             @OA\Property(property="timestamp", type="string", format="date-time", example="2024-05-06 12:00:00", description="Timestamp")
      *         )
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="Product updated successfully",
      *         @OA\JsonContent(
      *             @OA\Property(property="message", type="string", example="Product updated successfully")
      *         )
      *     ),
      *     @OA\Response(
      *         response=404,
      *         description="Product not found"
      *     ),
      *     @OA\Response(
      *         response=422,
      *         description="Validation error",
      *         @OA\JsonContent(
      *             @OA\Property(property="message", type="string", example="The given data was invalid."),
      *             @OA\Property(property="errors", type="object", example={
      *                 "name": {"The name field is required."},
      *                 "description": {"The description field is required."},
      *                 "price": {"The price field is required."},
      *                 "stock": {"The stock field is required."},
      *                 "timestamp": {"The timestamp field is required."}
      *             })
      *         )
      *     )
      * )
      */
     
  public function update(Request $request, $id)
  {$request->validate([
    'name' => 'string',
    'description' => 'nullable|string',
    'price' => 'numeric',
    'stock' => 'integer',// Add validation rules for other fields]);
    'categories' => 'required|array',

  ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());

        if (isset($request['categories'])) {
          $product->categories()->sync($request['categories']);
      }

        return response()->json($product, 200);
    }


    /**
     *  @OA\Delete(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Delete a product",
 *     description="Delete a product based on the provided ID.",
 *     operationId="deleteProduct",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the product to delete",
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Product deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 */
  public function destroy($id){$product = Product::findOrFail($id);$product->delete();
      return response()->json(null, 204);
    }

    public function filterByCategory(Request $request)
{
    $categoryIds = $request->input('category_ids');

    $products = Product::whereHas('categories', function ($query) use ($categoryIds) {
        $query->whereIn('id', $categoryIds);
    })->get();

    return response()->json($products);
}

}