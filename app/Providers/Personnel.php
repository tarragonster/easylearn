<?php
/**
 * Created by PhpStorm.
 * User: tarragonster
 * Date: 6/21/19
 * Time: 11:44 AM
 */

namespace App\Providers;


class Personnel
{

    private $name = 'Vu Van A';
    private $age = 32;

    public $request;
    /**
     * @param $request
     * @param $filename
     * @return string
     */
    public function uploadFile($request, $filename)
    {

        //todo upload

        //Get filename with extension
        $fileNameWithExt = $request->file('update_image')->getClientOriginalName();
        //Get just filename
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //Get just extension
        $extension = $request->file('update_image')->guessClientExtension();
        //Upload image
        $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
        $nameToDisplay = '/storage/update_images/' . $fileNameToStore;
        //Upload images
        $path = $request->file('update_image')->storeAs('public/update_images/', $fileNameToStore);


        return $path;
    }

    public function uploadVideo(){

    }
}
