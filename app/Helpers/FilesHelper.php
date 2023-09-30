<?php 
namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FilesHelper{

    public function filePath_to_json($archivos)
    {
        try {
            
            $paths=[];
            foreach ($archivos as $archivo) {
                $mimeType = $archivo->getClientMimeType(); 
                $segmentos = explode("/", $mimeType);
                $extension = $segmentos[1];
                $file_name = Str::uuid(). '.' . $extension;
                $file_path= $archivo->storeAs('events', $file_name);
                $paths[] = $file_path;
            }
            return $paths;
        } catch (\Throwable $th) {
            //throw $th;
            return false; 
        }
            
    }
}