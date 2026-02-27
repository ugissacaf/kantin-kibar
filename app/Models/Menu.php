<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'category', 'image', 'daily_quota', 'is_available'];
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    // Cek sisa kuota untuk hari tertentu
    public function getRemainingQuota($date = null)
    {
        $date = $date ?? now()->toDateString();
        
        $orderedQty = OrderItem::where('menu_id', $this->id)
            ->whereHas('order', function($query) use ($date) {
                $query->whereDate('order_date', $date);
            })
            ->sum('quantity');
            
        return $this->daily_quota - $orderedQty;
    }
}
