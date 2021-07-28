<?php 

use Illuminate\Support\Facades\Storage;

function storeFile($file, $dir = null)
{
    $directory = ($dir ? '/'.$dir.'/' : '/').date('Y').'/'.date('F');
    Storage::makeDirectory($directory, $mode = 0777, true, true);
    return $file->store($directory);
}