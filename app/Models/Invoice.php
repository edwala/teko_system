<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'client_id',
        'number',
        'name',
        'due_date',
        'datum_vystaveni',
        'datum_zdanitelneho_plneni',
        'is_paid',
        'paid_at',
        'is_sent',
        'sent_at',
        'is_reminded',
        'reminded_at',
        'is_overdue',
        'overdue_at',
        'is_cancelled',
        'cancelled_at',
        'is_archived',
        'archived_at',
        'is_printed',
        'printed_at',
    ];

    protected $searchableFields = ['*'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }

    protected $casts = [
        'due_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
