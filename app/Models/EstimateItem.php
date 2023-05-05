<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimateItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'estimate_id',
        'name',
        'item_cost',
        'count',
        'total_cost',
        'vat',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'estimate_items';

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
