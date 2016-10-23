<?php
$dbm = new medoo();
$items = $dbm->select('media', '*',
        array(
            "AND"=>array("estatus"=>'0')
            ,'ORDER'=>array("create_date DESC")));