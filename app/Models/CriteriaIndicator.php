<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaIndicator extends Model
{
    use HasFactory;
    protected $table = 'criteria_indicators';
    protected $primaryKey = 'criteria_indicator_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'criteria_indicator_name',
        'criteria_indicator_value',
    ];
}
