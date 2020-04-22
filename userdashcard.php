<?php
    require_once "db/dbcon.php";
    require_once "getuserstats.php";

    $pnotecount = $pfilecount = $urlcount = $notecount = $filecount = 0;
    
    try
    {
        $notecount = getCounts('note');
        $pnotecount = getCounts('pnote');
        $filecount = getCounts('file');
        $pfilecount = getCounts('pfile');
        $urlcount = getCounts('url');
    }
    catch(Error $e)
    {

    }
?>
<div class="user-dash-card">
    <div class="name-plate">
        <?php echo $name = isset($user) ? $user['name'] : '-'; ?>
    </div>
    <div class="plan">
        Basic
    </div>
    <div class="usage">
        <div class="usage-in">
            <!-- Total Private Notes: -->
            <div class="note-count">
                Total Notes : <span id="notecount"><?php echo $notecount; ?></span>
            </div>
            <div class="note-count">
                Private Notes : <span id="pnotecount"><?php echo $pnotecount; ?></span>/50
            </div>
            <div class="prog-bar">
                <div class="prog-val" id='noteprog'></div>
            </div>
        </div>
        <div class="usage-in">
            <!-- Total Files: -->
            <div class="file-count">
                Total Files : <span id="filecount"><?php echo $filecount; ?></span>/50
            </div>
            <div class="file-count">
                Private Files : <span id="pfilecount"><?php echo $pfilecount; ?></span>
            </div>
            <div class="prog-bar">
                <div class="prog-val" id='fileprog'></div>
            </div>
        </div>
        <div class="usage-in">
            <!-- Total URLs: -->
            <div class="url-count">
                Short URLs : <span id="urlcount"><?php echo $urlcount; ?></span>/50
            </div>
            <div class="prog-bar">
                <div class="prog-val" id='urlprog'></div>
            </div>
        </div>
    </div>
    <div class="upgrade">
        <a href="" class="upgrade-button">UPGRADE</a>
    </div>
</div>