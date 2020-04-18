<?php
    if(filter_var('http://www.siam.com', FILTER_VALIDATE_URL))
    {
        echo "in";
    }
?>