<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'value',
        'unit',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Scope untuk data yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get formatted value with unit
     */
    public function getFormattedValueAttribute()
    {
        return $this->value . ($this->unit ? ' ' . $this->unit : '');
    }

    /**
     * Get numeric value for counter animation
     */
    public function getNumericValueAttribute()
    {
        // Remove non-numeric characters except dots and commas
        return preg_replace('/[^0-9.,]/', '', $this->value);
    }
}