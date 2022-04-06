<?php

function upload_file($file, $dirname = null)
{
    // generate filename randomly
    $file_name = sha1(uniqid());

    // move file to sever storage
    $file->move(public_path() . '/uploads/' . $dirname, $file_name . "." . $file->getClientOriginalExtension());
    
    // filename with extension
    $local_url = $file_name . "." . $file->getClientOriginalExtension();
    return 'uploads/' . $dirname . '/' . $local_url;
}