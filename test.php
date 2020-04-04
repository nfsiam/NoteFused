<?php
    function fileNameExtender($oldName,$extension)
    {
        $pos = strrpos($oldName,'.');
        if($pos===false)
        {
            $newName = $filename.'_'.$fileID;
            return $newName;
        }
        else
        {
            $newName = substr_replace($oldName, '_'.$extension, $pos, 0);
            return $newName;
        }
    }

    echo fileNameExtender('abcdef.txt.txt.',5);
?>