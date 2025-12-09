<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

// User's meal entry - records what recipe they ate on a specific day
class DailyLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'recipe_id',
        'date',
        'meal_type',
        'servings',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'servings' => 'float',
    ];

    /**
     * Belongs to User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to Recipe relationship
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Calculate nutrition for this log entry
     */
    public function calculateNutrition(): array
    {
        return $this->recipe->calculateNutritionForServings($this->servings);
    }

    /**
     * Scope: Filter by date
     */
    public function scopeForDate($query, string $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeForDateRange($query, string $startDate, string $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope: Filter by meal type
     */
    public function scopeForMealType($query, string $mealType)
    {
        return $query->where('meal_type', $mealType);
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * Get human readable date
     */
    public function getHumanDateAttribute(): string
    {
        return $this->date->format('M j, Y');
    }
}
