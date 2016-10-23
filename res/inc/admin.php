<?php
$dbm = new medoo();
$items = $dbm->select('media', '*',
        array('ORDER'=>array("create_date DESC")));