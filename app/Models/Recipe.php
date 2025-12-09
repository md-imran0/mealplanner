<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Recipe - cooking instructions that use multiple ingredients
class Recipe extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass assigned
     */
    protected $fillable = [
        'name',
        'instructions',
        'servings',
        'prep_time_minutes',
        'cook_time_minutes',
        'difficulty',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'servings' => 'integer',
        'prep_time_minutes' => 'integer',
        'cook_time_minutes' => 'integer',
    ];

    /**
     * Many-to-Many relationship with Ingredient
     * A recipe can have many ingredients
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
                    ->withPivot('amount_grams')
                    ->withTimestamps();
    }

    /**
     * One-to-Many relationship with DailyLog
     * A recipe can be logged multiple times
     */
    public function dailyLogs(): HasMany
    {
        return $this->hasMany(DailyLog::class);
    }

    /**
     * Calculate total nutrition for entire recipe
     */
    public function calculateTotalNutrition(): array
    {
        $totals = [
            'calories' => 0,
            'co2' => 0,
            'protein' => 0,
            'fiber' => 0,
            'carbs' => 0,
            'fat' => 0,
            'sugar' => 0,
            'sodium' => 0,
        ];

        foreach ($this->ingredients as $ingredient) {
            $nutrition = $ingredient->calculateNutrition($ingredient->pivot->amount_grams);
            
            foreach ($nutrition as $key => $value) {
                $totals[$key] += $value;
            }
        }

        return $totals;
    }

    /**
     * Calculate nutrition per serving
     */
    public function calculateNutritionPerServing(): array
    {
        $totals = $this->calculateTotalNutrition();
        
        foreach ($totals as $key => $value) {
            $totals[$key] = $value / $this->servings;
        }

        return $totals;
    }

    /**
     * Calculate nutrition for specific number of servings
     */
    public function calculateNutritionForServings(float $servings): array
    {
        $perServing = $this->calculateNutritionPerServing();
        
        foreach ($perServing as $key => $value) {
            $perServing[$key] = $value * $servings;
        }

        return $perServing;
    }

    /**
     * Get total cooking time (prep + cook)
     */
    public function getTotalTimeAttribute(): int
    {
        return ($this->prep_time_minutes ?? 0) + ($this->cook_time_minutes ?? 0);
    }
}
