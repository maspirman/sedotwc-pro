<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'status',
        'slug',
        'icon',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the orders for the service.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the active orders for the service.
     */
    public function activeOrders()
    {
        return $this->hasMany(Order::class)->where('status', '!=', 'cancelled');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title') && empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
