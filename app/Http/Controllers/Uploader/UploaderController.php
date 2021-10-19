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

    /** @OA\Info(title="Radimart ecommerce Image CDN", version="1.0") */

    /**
     * Image Upload
     * 
     * @OA\Post(
     *     path="/uploader",
     *     tags={"image"},
     *     @OA\Response(
     *         response=201,
     *         description="success"
     *     ),
     *     @OA\MediaType(mediaType="multipart/form-data"),
    *      @OA\Parameter(
    *         name="accept",
    *         in="header",
    *         description="test",
    *         @OA\Schema(
    *             type="string",
    *             default="multipart/form-data" 
    *         )
    *       ),
    *       @OA\Parameter(
    *         name="imageType",
    *         in="header",
    *         description="test",
    *         @OA\Schema(
    *             type="string",
    *             default="product" 
    *         )
    *       ),
    *       @OA\RequestBody(
    *       @OA\MediaType(
    *           mediaType="multipart/form-data",
    *           @OA\Schema(
    *               type="object", 
    *               @OA\Property(
    *                  property="image",
    *                  type="file",
    *                  
    *               ),
    *           ),
    *       )
    *     ),   
    * )
    */

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
            $img->save(storage_path('/app/public/'.$imageType).'/'.$name);
            
            // delete temporary file
            unlink($destinationPath.'/'.$name);

            $imageUrl = url('').'/p/'.$imageType.'/'.$name;
            return $this->success('success', $imageUrl);
            
        }
    }
}
