<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// User's health goal - calorie targets, protein goals, weight loss, etc
class UserGoal extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass assigned
     */
    protected $fillable = [
        'user_id',
        'metric_name',
        'target_value',
        'direction',
        'is_active',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'target_value' => 'float',
        'is_active' => 'boolean',
    ];
    
    /**
     * Belongs to User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if daily intake meets this goal
     */
    public function checkDailyProgress(string $date): array
    {
        
        $user = $this->user;
        $dailyNutrition = $user->getDailyNutrition($date);
        $actualValue = $dailyNutrition[$this->metric_name] ?? 0;

        $goalMet = match($this->direction) {
            'max' => $actualValue >= $this->target_value, // "At least" this much
            'min' => $actualValue <= $this->target_value, // "Don't exceed" this much
            default => false
        };

        $percentage = $this->target_value > 0 
            ? round(($actualValue / $this->target_value) * 100, 1)
            : 0;

        return [
            'goal_met' => $goalMet,
            'actual_value' => round($actualValue, 2),
            'target_value' => $this->target_value,
            'percentage' => $percentage,
            'difference' => round($actualValue - $this->target_value, 2),
            'direction' => $this->direction,
        ];
    }

    /**
     * Get the remaining amount needed to meet the goal
     */
    public function getRemainingForDate(string $date): float
    {
        $user = $this->user;
        $dailyNutrition = $user->getDailyNutrition($date);
        $actualValue = $dailyNutrition[$this->metric_name] ?? 0;

        return match($this->direction) {
            'max' => max(0, $this->target_value - $actualValue), // How much more needed
            'min' => max(0, $actualValue - $this->target_value), // How much over limit
            default => 0
        };
    }
}
