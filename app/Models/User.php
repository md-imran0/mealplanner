<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User Model
 * 
 * Represents a user of the nutrition tracker app.
 * Each user can have multiple goals, daily meal logs, and body measurements.
 * Uses Laravel's built-in authentication system.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * These are the fields that can be filled using create() or update() methods.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',      // User's display name
        'email',     // User's email address (unique)
        'password',  // User's encrypted password
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * One-to-Many relationship with UserGoal
     */
    public function goals(): HasMany
    {
        return $this->hasMany(UserGoal::class);
    }

    /**
     * One-to-Many relationship with DailyLog
     */
    public function dailyLogs(): HasMany
    {
        return $this->hasMany(DailyLog::class);
    }

    /**
     * One-to-Many relationship with Biometric
     */
    public function biometrics(): HasMany
    {
        return $this->hasMany(Biometric::class);
    }

    /**
     * Get active goals only
     */
    public function activeGoals(): HasMany
    {
        return $this->goals()->where('is_active', true);
    }

    /**
     * Get daily nutrition summary for a specific date
     */
    public function getDailyNutrition(string $date): array
    {
        $logs = $this->dailyLogs()
                    ->with(['recipe.ingredients'])
                    ->whereDate('date', $date)
                    ->get();

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

        foreach ($logs as $log) {
            $nutrition = $log->calculateNutrition();
            
            foreach ($nutrition as $key => $value) {
                $totals[$key] += $value;
            }
        }

        return $totals;
    }

    /**
     * Get nutrition summary for date range
     */
    public function getNutritionForPeriod(string $startDate, string $endDate): array
    {
        $logs = $this->dailyLogs()
                    ->with(['recipe.ingredients'])
                    ->whereBetween('date', [$startDate, $endDate])
                    ->get();

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

        foreach ($logs as $log) {
            $nutrition = $log->calculateNutrition();
            
            foreach ($nutrition as $key => $value) {
                $totals[$key] += $value;
            }
        }

        return $totals;
    }

    /**
     * Check all goals for a specific date
     */
    public function checkAllGoals(string $date): array
    {
        $results = [];
        
        foreach ($this->activeGoals as $goal) {
            $results[$goal->metric_name] = $goal->checkDailyProgress($date);
        }

        return $results;
    }
}
