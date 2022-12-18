<?php
function fileUpload($path, $image)
{
    $imageName = time() . mt_rand(1, 50000) . '.' . $image->extension();
    $image->move(public_path('images/' . $path), $imageName);
    return  $imageName;
}

function fieldRequired()
{
    return "<span style='color:red'> * </span>";
}

function timeSlot()
{
    return [
        "08-09 AM",
        "09-10 AM",
        "10-11 AM",
        "11-12 AM",
        "12-01 PM",
        "01-02 PM",
        "02-03 PM",
        "03-04 PM",
        "04-05 PM",
        "05-06 PM",
        "06-07 PM",
        "07-08 PM",
    ];
}
