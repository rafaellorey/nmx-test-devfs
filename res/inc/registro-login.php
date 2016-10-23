<?php
//chk session
if(Session::has('CMS_id')){
    Utils::redirectTo("admin.php");
}