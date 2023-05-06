<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estimate extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'client_id',
        'sum',
        'name',
        'due_date',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'due_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function estimateItems()
    {
        return $this->hasMany(EstimateItem::class);
    }
}
