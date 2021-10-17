<?php

namespace App\Http\Controllers\Uploader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\RespondsWithHttpStatus;
use Validator;
use Helper;
use Image;
use URL;

class UploaderController extends Controller
{   
    use RespondsWithHttpStatus;

    public function uploader(Request $request){
        
        $validator = Validator::make($request->all(),[
            'image' => 'required'
        ]);

        if($validator->fails()){
            return $this->failure(Helper::VALIDATOR_FAIL_MESSAGE, Helper::validateErrorMsg($validator->errors()));
        }

        $imageType = $request->get('imageType');
        $extension = $request->get('extension');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = Helper::randomNumber(25).'.'.$extension;
            $destinationPath = public_path('/');
            $image->move($destinationPath, $name);

            $img = Image::make(public_path('/').'/'.$name);
            $img->save(public_path('/storage/'.$imageType).'/'.$name);
            
            // delete temporary file
            unlink($destinationPath.'/'.$name);

            return url('').'/images/'.$imageType.'/'.$name;
        }
    }
}
