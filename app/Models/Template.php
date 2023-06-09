<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'content',
        'file',
    ];

    protected $searchableFields = ['*'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
