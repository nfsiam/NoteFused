<?php
    require_once "userstatmodule.php";
    require_once "planmodule.php";
    
    if(isset($_POST['ustats']))
    {
        $data = array();
        $pnotecount = $pfilecount = $urlcount = $notecount = $filecount = -1;

        $notecount = getCounts('note');
        $pnotecount = getCounts('pnote');
        $filecount = getCounts('file');
        $pfilecount = getCounts('pfile');
        $urlcount = getCounts('url');

        $totalfilesize  = getFileSize();

        $data['currentplan'] = getCurrentPlan();

        $data['notecount'] = is_int($notecount)? $notecount : -1;
        $data['pnotecount'] = is_int($pnotecount)? $pnotecount : -1;
        $data['filecount'] = is_int($filecount)? $filecount : -1;
        $data['pfilecount'] = is_int($pfilecount)? $pfilecount : -1;
        $data['urlcount'] = is_int($urlcount)? $urlcount : -1;
        $data['totalfilesize'] = is_int($totalfilesize)? $totalfilesize : -1;

        echo json_encode($data);

    }

?>