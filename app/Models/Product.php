<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /**
     * Attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = ['images'];

    /**
     * Accessor for the images attribute.
     * Returns an array containing the main image.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function images(): Attribute
    {
        return Attribute::get(fn () => [$this->image]);
    }

    /**
     * Get the category that the product belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
