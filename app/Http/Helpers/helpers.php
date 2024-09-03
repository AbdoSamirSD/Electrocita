<?php

use App\Models\Language;

function getActivatedLanguages(){
    $activeLangs = Language::where('active', 1)->get();
    return $activeLangs;
}

// function saveimg($folder, $img){
//     $img->store('/', $folder);
//     $filename = $img->hashname();
//     $path = 'images/' . $folder . '/' . $filename;
//     return $path;
// }