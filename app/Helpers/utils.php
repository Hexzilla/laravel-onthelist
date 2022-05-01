<?php

function upload_file($file, $dirname = null)
{
    // generate filename randomly
    $file_name = sha1(uniqid());

    // move file to sever storage
    $path = $file->store('uploads/' . $dirname, 'public');
    
    // filename with extension
    return $path;
}