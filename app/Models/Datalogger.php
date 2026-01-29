<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Datalogger extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datalogger';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data1',
        'data2',
        'logged_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data1' => 'float',
        'data2' => 'float',
        'logged_at' => 'datetime',
    ];

    /**
     * Get formatted data1 value
     */
    public function getFormattedData1Attribute()
    {
        return number_format($this->data1, 2);
    }

    /**
     * Get formatted data2 value
     */
    public function getFormattedData2Attribute()
    {
        return number_format($this->data2, 2);
    }

    /**
     * Scope a query to order by logged_at.
     */
    public function scopeOrderByLoggedAt($query, $direction = 'desc')
    {
        return $query->orderBy('logged_at', $direction);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('logged_at', [$startDate, $endDate]);
    }
}
