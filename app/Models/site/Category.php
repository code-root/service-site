<?php

namespace App\Models\site;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'icon',
        'color_class',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the galleries for the category.
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

       /**
     * Get the language associated with the subject.
     */
    public function language()
    {
        return $this->belongsTo(Translation::class, 'token', 'tr_token');
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
