<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageContent extends Model
{
    protected $table = 'landing_page_contents';

    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
        'sort_order',
        'is_active',
    ];
}
