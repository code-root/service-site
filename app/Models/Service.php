<?php

namespace App\Models;

use App\Models\site\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name','title', 'description', 'price','image' ,'category_id','tr_token'];

        
    /**
     * Get the translation language associated with the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function language()
    {
        return $this->belongsTo(Translation::class, 'token', 'tr_token');
    }

    /**
     * Get the category associated with the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class , 'id' , 'category_id');
    }

    public static function txt()
    {
        return [
            'name' => [
                'label' => 'اسم الكاتوجري',
                'type' => 'input', 
                'data_type' => 'string', 
                'icon' => 'fa fa-text-width', 
            ],
   
            'title' => [
                'label' => 'عنوان الكاتوجري',
                'type' => 'input', 
                'data_type' => 'string', 
                'icon' => 'fa fa-language', 
            ],
        ];
    }

    /**
     * Get the translations for the slider.
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }



}
