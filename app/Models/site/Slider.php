<?php

namespace App\Models\site;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = 'sliders';
    protected $primaryKey = 'id';

    protected $fillable = [
            'image',
            'name',
            'description',
            'title',
            'button_text',
            'tr_token',
            'button_url',
            'status',
    ];

    public static function txt()
    {
        return [
            'name' => [
                'label' => 'Slider Name',
                'type' => 'input',
                'data_type' => 'string',
                'icon' => 'fa fa-text-width',
            ],
            'description' => [
                'label' => 'Slider Description',
                'type' => 'textarea',
                'data_type' => 'string',
                'icon' => 'fa fa-align-left',
            ],

            'title' => [
                'label' => 'title',
                'type' => 'input',
                'data_type' => 'string',
                'icon' => 'fa fa-language',
            ],


            'button_text' => [
                'label' => 'button_text',
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

    public function language()
    {
        return $this->belongsTo(Translation::class, 'token', 'tr_token');
    }
}
