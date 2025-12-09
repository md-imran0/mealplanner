<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

// Store body measurements: weight, height, body fat percentage
class Biometric extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass assigned
     */
    protected $fillable = [
        'user_id',
        'measurement_date',
        'weight',
        'height',
        'body_fat_percentage',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'measurement_date' => 'date',
        'weight' => 'float',
        'height' => 'float',
        'body_fat_percentage' => 'float',
    ];

    /**
     * Belongs to User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Filter by measurement type
     */
    public function scopeForType($query, string $type)
    {
        return $query->where('measurement_type', $type);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeForDateRange($query, string $startDate, string $endDate)
    {
        return $query->whereBetween('measured_at', [$startDate, $endDate]);
    }

    /**
     * Scope: Order by measurement date (latest first)
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('measured_at', 'desc');
    }

    /**
     * Get formatted value with unit
     */
    public function getFormattedValueAttribute(): string
    {
        return number_format($this->value, 1) . ' ' . $this->unit;
    }

    /**
     * Get human readable measurement date
     */
    public function getHumanDateAttribute(): string
    {
        return $this->measured_at->format('M j, Y g:i A');
    }

    /**
     * Check if measurement is recent (within last 7 days)
     */
    public function getIsRecentAttribute(): bool
    {
        return $this->measured_at->isAfter(Carbon::now()->subDays(7));
    }
}
