<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;

class Employee extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'company_id',
        'name',
        'surname',
        'address',
        'position',
    ];

    protected $searchableFields = ['*'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
