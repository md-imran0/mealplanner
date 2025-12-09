<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Basic food item - stores nutrition info per 100g (calories, protein, carbs, fat, fiber, CO2)
class Ingredient extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass assigned
     */
    protected $fillable = [
        'name',
        'calories_per_100g',
        'co2_per_100g',
        'protein_per_100g',
        'fiber_per_100g',
        'carbs_per_100g',
        'fat_per_100g',
        'sugar_per_100g',
        'sodium_per_100g',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'calories_per_100g' => 'float',
        'co2_per_100g' => 'float',
        'protein_per_100g' => 'float',
        'fiber_per_100g' => 'float',
        'carbs_per_100g' => 'float',
        'fat_per_100g' => 'float',
        'sugar_per_100g' => 'float',
        'sodium_per_100g' => 'float',
    ];

    /**
     * Many-to-Many relationship with Recipe
     * An ingredient can be used in many recipes
     */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients')
                    ->withPivot('amount_grams')
                    ->withTimestamps();
    }

    /**
     * Helper method to calculate nutrition for given amount
     */
    public function calculateNutrition(float $grams): array
    {
        $factor = $grams / 100; // Convert from per-100g to actual amount
        
        return [
            'calories' => $this->calories_per_100g * $factor,
            'co2' => $this->co2_per_100g * $factor,
            'protein' => $this->protein_per_100g * $factor,
            'fiber' => $this->fiber_per_100g * $factor,
            'carbs' => ($this->carbs_per_100g ?? 0) * $factor,
            'fat' => ($this->fat_per_100g ?? 0) * $factor,
            'sugar' => ($this->sugar_per_100g ?? 0) * $factor,
            'sodium' => ($this->sodium_per_100g ?? 0) * $factor,
        ];
    }
}
