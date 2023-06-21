<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartoon extends Model
{
    use HasFactory;
    protected $table = 'cartoons';
    protected $primaryKey = 'cartoon_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cartoon_name',
        'Does not contain elements of violence',
        'Creative',
        'Educating',
        'Entertain',
        'No Pornographic Elements',
        'cartoon_img',
    ];
}
