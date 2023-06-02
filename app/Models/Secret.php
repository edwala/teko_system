<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class Secret extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use Auditable;

    protected $fillable = ['company_id', 'name', 'description', 'secret'];

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
