<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'no_hp',
        'program',
        'jumlah',
        'nominal',
        'pesan',
        'keterangan_pesan',
        'order_id',
        'transaction_id',
        'payment_type',
        'bank',
        'transaction_status',
        'transaction_time',
        'settlement_time',
        'status_code',
        'gross_amount',
        'fraud_status',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'nominal' => 'decimal:2',
        'gross_amount' => 'decimal:2',
        'transaction_time' => 'datetime',
        'settlement_time' => 'datetime',
    ];

    /**
     * Accessor untuk no_hp (menggunakan telepon jika no_hp kosong)
     */
    public function getNoHpAttribute($value)
    {
        return $value ? $value : $this->telepon;
    }

    /**
     * Accessor untuk nominal (menggunakan jumlah jika nominal kosong)
     */
    public function getNominalAttribute($value)
    {
        return $value ? $value : $this->jumlah;
    }

    /**
     * Accessor untuk keterangan_pesan (menggunakan pesan jika keterangan_pesan kosong)
     */
    public function getKeteranganPesanAttribute($value)
    {
        return $value ? $value : $this->pesan;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        switch($this->transaction_status) {
            case 'settlement':
                return 'success';
            case 'pending':
                return 'warning';
            case 'expire':
                return 'danger';
            case 'cancel':
                return 'secondary';
            default:
                return 'info';
        }
    }

    /**
     * Accessor untuk mendapatkan bank/payment method dengan format yang lebih baik
     */
    public function getBankDisplayAttribute()
    {
        $bank = $this->bank;
        $paymentType = $this->payment_type;

        // Jika bank sudah ada, format dan return
        if (!empty($bank)) {
            return strtoupper($bank);
        }

        // Jika payment_type ada, extract bank dari payment_type
        if (!empty($paymentType)) {
            // Format payment_type untuk display
            if (strpos($paymentType, 'bca_va') !== false || strpos($paymentType, 'bca') !== false) {
                return 'BCA';
            } elseif (strpos($paymentType, 'bni_va') !== false || strpos($paymentType, 'bni') !== false) {
                return 'BNI';
            } elseif (strpos($paymentType, 'bri_va') !== false || strpos($paymentType, 'bri') !== false) {
                return 'BRI';
            } elseif (strpos($paymentType, 'mandiri_va') !== false || strpos($paymentType, 'echannel') !== false) {
                return 'Mandiri';
            } elseif (strpos($paymentType, 'permata_va') !== false || strpos($paymentType, 'permata') !== false) {
                return 'Permata';
            } elseif (strpos($paymentType, 'bank_transfer') !== false) {
                return 'Bank Transfer';
            } elseif (strpos($paymentType, 'credit_card') !== false) {
                return 'Credit Card';
            } elseif (strpos($paymentType, 'gopay') !== false) {
                return 'GoPay';
            } elseif (strpos($paymentType, 'shopeepay') !== false) {
                return 'ShopeePay';
            } elseif (strpos($paymentType, 'qris') !== false) {
                return 'QRIS';
            } else {
                // Format umum: ubah underscore ke space dan capitalize
                return ucwords(str_replace('_', ' ', $paymentType));
            }
        }

        return '-';
    }
}

