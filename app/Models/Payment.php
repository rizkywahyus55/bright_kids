<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'payment_code',
        'method',
        'amount',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'paid_at',
        'recorded_by',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'recorded_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'lunas' => 'Lunas',
            'kedaluwarsa' => 'Kedaluwarsa',
            'batal' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getMethodLabelAttribute(): string
    {
        return match(strtolower($this->method ?? '')) {
            'midtrans', 'online' => 'Online',
            'manual', 'tunai'    => 'Tunai',
            default              => ($this->method ? ucfirst($this->method) : 'Tunai'),
        };
    }

    public function getPaymentMethodAttribute(): string
    {
        return $this->method_label;
    }

    public function getPaymentTypeAttribute(): string
    {
        return $this->notes ?: 'Biaya Awal Bimbel';
    }
}
