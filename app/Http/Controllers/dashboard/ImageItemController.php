<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;

use App\Models\Avatar;
use App\Models\ImageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ImageItemController extends Controller
{



    public function store(Request $request)
    {
        $imagesData = [];
        $status = 200; // الافتراضي: نجاح الرفع
        if (ImageItem::where('table_name', $request->table_name)
            ->where('token', $request->token_image)->exists()
        ) {
            $status = 100; // في حال كانت الصور موجودة مسبقًا
        } else {
            $allowedImageTypes = ['jpg', 'jpeg', 'png', 'svg'];
            $this->validate($request, ['image.*' => 'required|mimes:' . implode(',', $allowedImageTypes)]);
            foreach ($request->file('image') as $image) {
                $originalName = $image->getClientOriginalName();
                $ii = $this->uploadImage($image, $originalName, $request->username, $request->table_name, $request->token_image, 'normal');
                $blurImage = $this->blurImage($ii, $originalName, $request->table_name, $request->token_image);
                $imagesData[] = [
                    'image' => $ii['path'] ?? '',
                    'blur' => $blurImage ?? '',
                ];
            }
        }
        $message = ($status === 200) ? 'Images uploaded successfully' : 'Images already exist for this table and token';
        return response()->json([
            'message' => $message,
            'images' => $imagesData,
            'status' => $status,
        ]);
    }




    public function uploadImage($image, $original_name, $username, $table_name, $token, $type = 'normal', $table_id = 0)
    {
        $imageName = trim($table_id . '-' . $token . '-' . now() . '.' . $image->getClientOriginalExtension());
        $path = 'assets/' . $table_name . '/' . $table_id;
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        $image->move($path, $imageName);
        $d =  ImageItem::create([
            'url' => $path . '/' . $imageName,
            'original_name' => $original_name,
            'table_name' => $table_name,
            'table_id' => $table_id,
            'token' => $token,
            'image_size' => 00,
            'type' => $type, // نوع الصورة: 'normal' أو 'blurred' على سبيل المثال
        ]);

        return [
            'path' => '/' . $path . '/' . $imageName,
            'id' => $d->id,
            'extension' => $image->getClientOriginalExtension() ?? '',

        ];
    }


    public function  delete(Request $request)
    {
        ImageItem::where('id', $request->image_id)->delete();
        return 200;
    }
}
