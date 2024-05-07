<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Category",
 *     title="Category",
 *     description="Category model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the category"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the category"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the category"
 *     ),
 *     example={"id": 1, "title": "Category Name", "description": "Category Description"}
 * )
 */


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    
    ];

    public function posts()
    {
        return $this->belongsToMany(Product::class, 'categories_products', 'product_id', 'category_id')->withTimestamps();
    }
}


