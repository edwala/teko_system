<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'name',
        'item_cost',
        'count',
        'total_cost',
        'vat',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'invoice_items';

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
