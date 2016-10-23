<?php
class Html {
    public static function navLi($url,$icon,$tit,$cur=null,$isSub=false)
    {
        $cAct = (strpos($url,$cur)!== false ? "active":"");
        if($isSub){
            echo "<li><a href=\"$url\"><i class=\"icon-$icon\"></i> $tit</a></li>";
        }else {
            echo "<li class=\"$cAct\"><a href=\"$url\"><i class=\"icon-$icon position-left\"></i> $tit</a></li>";
        }
    }


    public static function linkGIcon($action, $icon, $text, $attrs = NULL, $externo=FALSE)
    {
        $text = isNoE($text) ? '' : '&nbsp;'.$text;
        if($externo){
            return "<a href=\"$action\" $attrs target=\"_blank\"><span class=\"glyphicon glyphicon-$icon\"></span>$text</a>";
        }else{
            return '<a href="'."$action\" $attrs ><span class=\"glyphicon glyphicon-$icon\"></span>$text</a>";
        }
    }      
    public static function videoPrev($imgPath, $imgAlt = NULL,$text="", $attrs = NULL)
    {
        if(!$imgAlt){
            $imgAlt = basename($imgPath);
        }
        return '<a href="../'.$imgPath.'" title="' . $imgAlt . '" class="cbox_video" '.$attrs.'><i class="glyphicon glyphicon-facetime-video"></i>&nbsp;'.$text.'</a>';
    }  
    public static function videoOnline($video)
    {
        return '<a href="'.$video.'" class="aVideo"><i class="glyphicon glyphicon-facetime-video"></i>&nbsp; '.$video.'</a>';
    }
    public static function imgPrev($imgPath, $imgAlt = NULL,$text="", $attrs = NULL)
    {
        if(!$imgAlt){
            $imgAlt = basename($imgPath);
        }
        return '<a href="'.$imgPath.'" title="' . $imgAlt . '" class="cbox_single" '.$attrs.'><i class="glyphicon glyphicon-picture"></i>&nbsp;'.$text.'</a>';
    }  
    public static function imgPrevTn($imgPath, $imgTn, $imgAlt = NULL, $attrs = NULL)
    {
        if(!$imgAlt){
            $imgAlt = basename($imgPath);
        }
        return '<a href="'.$imgPath.'" title="' . $imgAlt . '" class="cbox_single" '.$attrs.' style="margin-bottom:0px;"><img src="'.$imgTn.'" style="height:50px;width:50px"></a>';
    }



    public static function hidden($id,$valor)
    {
        echo '<input type="hidden" id="'.$id.'" name="'.$id.'" value="'.$valor.'"/>';
    }
    public static  function fgSelect($id,$options,$valor,$attr='',$lbl = NULL,$req=TRUE,$class='form-control')
    {
        if(empty($lbl)){ $lbl = ucwords($id); }
        echo "<div class=\"form-group\">";
        echo "<label class=\"control-label col-lg-3\">$lbl";
        if($req){ echo "&nbsp;<span class=\"text-danger\">*</span>";}
        echo "</label><div class=\"col-lg-9\">";
        Html::select($id,$options,$valor,$attr,$req,$class);
        echo "</div></div>";
    }
    public static function select($id,$options,$valor,$attr='',$req=TRUE,$class='form-control')
    {
        if(strpos($id, '[') !== false){
            echo '<select name="' . $id . '" class="' . $class . '" ' . ($req ? 'required="required"' : '') . ' ' . $attr . '>';
        }else {
            echo '<select id="' . $id . '" name="' . $id . '" class="' . $class . '" ' . ($req ? 'required="required"' : '') . ' ' . $attr . '>';
        }
        echo '<option value="">--</option>';
        foreach ($options as $k => $v) {
            if(is_array($valor)){
                echo '<option value="' . $k . '" ' . (in_array($k,$valor) ? 'selected="selected"' : '') . '>' . $v . '</option>';
            }else {
                echo '<option value="' . $k . '" ' . ($k == $valor ? 'selected="selected"' : '') . '>' . $v . '</option>';
            }
        }
        echo '</select>';
    }
    public static function fgInput($id,$valor,$attr='',$lbl = NULL,$tipo='text',$req=TRUE)
    {
        if(empty($lbl)){ $lbl = ucwords($id); }
        echo "<div class=\"form-group\">";
        echo "<label class=\"control-label col-lg-3\">$lbl";
        if($req){ echo "&nbsp;<span class=\"text-danger\">*</span>";}
        echo "</label><div class=\"col-lg-9\">";
        Html::input($id,$valor,$attr,$tipo,$req);
        echo "</div></div>";
    }
    public static function input($id,$valor,$attr='',$tipo='text',$req=TRUE)
    {
        if($tipo == 'textarea'){
            echo '<textarea class="form-control" '.($req?'required="required"':'').' rows="5" cols="5" id="'.$id.'" name="'.$id.'" '.$attr.'>'.$valor.'</textarea>';
        }else{
            echo '<input type="'.$tipo.'" id="'.$id.'" name="'.$id.'" value="'.$valor.'" class="form-control" '.($req?'required="required"':'').' '.$attr.'>';
        }
    }
    public static function fgButtons()
    {
        echo "<div class=\"row\"><div class=\"col-lg-6 text-left\"><span class=\"text-danger\">* Campos requeridos.</span></div>";
        echo "<div class=\"col-lg-6 text-right\">";
        echo "<button type=\"button\" class=\"btn btn-default\" id=\"btnCancelar\" onclick=\"cancelar();\"><i class=\"icon-arrow-left13 position-left\"></i>&nbsp;Cancelar</button>";
        echo "<button type=\"reset\" class=\"btn btn-default\" id=\"reset\">Limpiar <i class=\"icon-reload-alt position-right\"></i></button>";
        echo "<button type=\"submit\" class=\"btn btn-primary\">Guardar <i class=\"icon-arrow-right14 position-right\"></i></button>";
        echo "</div></div>";
    }
    public static function alert($msg)
    {
        echo '<div class="alert alert-danger" role="alert">';
        if(is_array($msg)){
            echo '<ul>';
            foreach ($msg as $key => $value) {
                echo "<li>$key: $value</li>";
            }
            echo '</ul>';
        }else{
            echo $msg;
        }
        echo '</div>';
    }
    public static function chkSwitch($id, $valor, $inList=TRUE, $attr='')
    {
        $chkt = $valor == 1 ? 'checked="checked"' : "";
        if($inList) {
            echo "<input type=\"checkbox\" class=\"$id switchery\" $chkt $attr>";
        }else{
            echo "<input id=\"$id\" name=\"$id\" type=\"checkbox\" class=\"switchery\" $chkt $attr>";
        }
    }
    public static function imagen($id, $valor=""){
        echo '<div class="input-group col-sm-12" data-dbval="'.$valor.'">
            <span class="input-group-btn">
                <a class="fancybox fancybox.iframe btn btn-primary" href="filemanager/dialog.php?fldr=img&type=1&field_id='.$id.'">
                    <span class="glyphicon glyphicon-picture"></span>&nbsp;&nbsp;Elegir
                </a>
                <button class="btn btn-warning imgEdit imgCancel" type="button" title="Cancelar Cambios"><span class="glyphicon glyphicon-remove"></span></button>
            </span>
            <input id="'.$id.'" name="'.$id.'" type="text" class="form-control iTxtFile" value="'.$valor.'" readonly="true" maxlength="150" required="required">
        </div>';
    }
    public static function video($id, $valor=""){
        echo '<div class="input-group col-sm-12" data-dbval="'.$valor.'">
            <span class="input-group-btn">
                <a class="fancybox fancybox.iframe btn btn-primary" href="filemanager/dialog.php?fldr=video&type=3&field_id='.$id.'">
                    <span class="glyphicon glyphicon-facetime-video"></span>&nbsp;&nbsp;Elegir
                </a>
                <button class="btn btn-warning imgEdit imgCancel" type="button" title="Cancelar Cambios"><span class="glyphicon glyphicon-remove"></span></button>
            </span>
            <input id="'.$id.'" name="'.$id.'" type="text" class="form-control iTxtFile" value="'.$valor.'" readonly="true" maxlength="150" required="required">
        </div>';
    }
    public static function fgDocto($lbl, $id, $valor=""){
        echo "<div class=\"form-group\">";
        echo "<label class=\"control-label col-lg-3\">$lbl";
        //if($req){ echo "&nbsp;<span class=\"text-danger\">*</span>";}
        echo "</label><div class=\"col-lg-9\">";
        echo '<div class="input-group col-sm-12" data-dbval="'.$valor.'">
            <span class="input-group-btn">
                <a class="fancybox fancybox.iframe btn btn-primary" href="filemanager/dialog.php?fldr=doc&type=2&field_id='.$id.'">
                    <span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Elegir
                </a>
                <button class="btn btn-warning imgEdit imgCancel" type="button" title="Cancelar Cambios"><span class="glyphicon glyphicon-remove"></span></button>
            </span>
            <input id="'.$id.'" name="'.$id.'" type="text" class="form-control iTxtFile" value="'.$valor.'" readonly="true" maxlength="150" required="required">
        </div>';
        echo "</div></div>";
    }


    public static function label($label,$valor)
    {
        echo '<div class="form-group form-group-sm">
          <label class="col-sm-2 control-label" >'.$label.'</label>
          <div class="col-sm-10">'.$valor.'</div></div>';        
    }    



    public static function tdImg($img, $center=true)
    {
        echo ($center ? '<td align="center">' : '<td>').( empty($img) ? "" : Html::imgPrev($img,$img,basename($img))).'</td>';
    }
    public static function tdImgTn($img,$imgTn, $center=true)
    {
        echo ($center ? '<td align="center">' : '<td>').( empty($img) ? "" : Html::imgPrevTn($img,$imgTn)).'</td>';
    }    
    public static function tdLink($link)
    {
        echo '<td align="center">'.( empty($link) ? "" : Html::linkGIcon($link, 'link', $link, null, true)).'</td>';
    }
    public static function tdVid($img)
    {
        echo '<td align="center">'.( empty($img) ? "" : Html::videoPrev($img,$img,basename($img))).'</td>';
    }    
    public static function tdVidYt($idyt, $center=true)
    {
        if(empty($idyt)){
            echo ($center ? '<td align="center">' : '<td>').'&nbsp;</td>';
        }
        else{
            echo ($center ? '<td align="center">' : '<td>').'<a href="//www.youtube.com/embed/'.$idyt.'" class="aVideo"><i class="glyphicon glyphicon-facetime-video"></i>&nbsp;'.$idyt.'</a></td>';
        }        
    }
    public static function tdVidYtTn($idyt,$imgTn, $center=true)
    {
        if(empty($idyt)){
            echo ($center ? '<td align="center">' : '<td>').'&nbsp;</td>';
        }
        else{
            if(!strpos($imgTn,"img.youtube.com")){
                $imgTn = "../".$imgTn;
            }
            echo ($center ? '<td align="center">' : '<td>').'<a href="//www.youtube.com/embed/'.$idyt.'" class="aVideo"><img src="'.$imgTn.'" width="73" height="71"></td>';
        }        
    }    

    public static function tdVidOn($img)
    {
        echo '<td align="center">'.( empty($img) ? "" : Html::videoOnline($img)).'</td>';
    }       
    public static function tdMedia($media)
    {
        if(isImgFile($media)){
            Html::tdImg($media);
        }else{
            Html::tdVid($media);
        }
    }
    public static function liCats($proyCats, $cats)
    {
        $pCats = explode(",", $proyCats);
        if(!empty($proyCats)){
        if(count($pCats)>0 && is_array($cats)){
            echo "<ul>";
            foreach ($pCats as $pC) {
                $cat = Utils::arrayFind($cats, 'id', $pC, TRUE);
                if(!empty($cat)){
                    echo '<li>'.$cat->titulo.'</li>';
                }
            }
            echo "</ul>";
        }else{ 
            echo "";             
        }
        }
    }
    public static function liRels($proyRels, $proys)
    {
        if(!empty($proyRels)){
        $pRels = explode(",", $proyRels);
        if(count($pRels)>0 && is_array($proys)){
            echo "<ul>";
            foreach ($pRels as $pR) {
                $rel = Utils::arrayFind($proys, 'id', $pR, TRUE);
                if(!empty($rel)){
                    echo '<li>['.$rel->id.']&nbsp;'.$rel->titulo.'</li>';
                }
            }
            echo "</ul>";
        }
        }
    } 
    public static function liArray($array,$links=false)
    {
        if(is_array($array)){
            $html = '<ul>';
            foreach ($array as $item) {
                if(!isNoE($item)){
                    if($links){
                    $html.= '<li>'.Html::linkGIcon($item, 'link', $item, null, true).'</li>';    
                    }else{
                    $html.= '<li>'.$item.'</li>';
                    }
                }
            }
            $html .= '</ul>';
            echo($html);        
        }else{
            echo "";
        }
    }

    public static function strSiNo($val){
        echo $val==NULL ? '--' : ($val == 1 ? 'Si' : 'No');
    }
    public static function iconSiNo($val){
        return empty($val) ? '--' : $val == 0 ? '<span class="glyphicon glyphicon-unchecked"></span>' : '<span class="glyphicon glyphicon-ok"></span>';
    }    
    public static function SiNo($name,$label, $valor, $attrs = NULL){
        echo '<div class="form-group form-group-sm">
          <label class="col-sm-2 control-label" for="'.$name.'">'.$label.'</label>
          <div class="col-sm-10">';        
        echo '<div class="btn-group" data-toggle="buttons">&nbsp;&nbsp;&nbsp;';
        echo '<label class="btn btn-sm btn-default '.($valor == 1 ? "active" : "").'">';
        echo "<input type=\"radio\" name=\"$name\" value=\"1\" $attrs ".($valor == 1 ? "checked" : "")."> SI" . PHP_EOL;
        echo '</label>';
        echo '<label class="btn btn-sm btn-default '.($valor == 0 ? "active" : "").'">';
        echo "<input type=\"radio\" name=\"$name\" value=\"0\" $attrs ".($valor == 0 ? "checked" : "")."> NO" . PHP_EOL;
        echo '</label>';                
        echo '</div></div></div>';        
    }
    public static function onSiNo($name,$valor, $attrs = NULL, $lang="es"){
        $opc=array(
            "es"=>array("SI","NO"),
            "en"=>array("YES","NO")
        );
        echo '<div class="btn-group" data-toggle="buttons">';
        echo '<label class="btn btn-xs btn-default '.($valor == 1 ? "active" : "").'">';
        echo "<input type=\"radio\" name=\"$name\" value=\"1\" $attrs ".($valor == 1 ? "checked" : "")."> ".$opc[$lang][0] . PHP_EOL;
        echo '</label>';
        echo '<label class="btn btn-xs btn-default '.($valor == 0 ? "active" : "").'">';
        echo "<input type=\"radio\" name=\"$name\" value=\"0\" $attrs ".($valor == 0 ? "checked" : "")."> ".$opc[$lang][1] . PHP_EOL;
        echo '</label>';                
        echo '</div>';        
    }      
    public static function OffSiNo($name, $valor, $attrs=NULL, $lang="es"){
        $opc=array(
            "es"=>array("SI","NO"),
            "en"=>array("YES","NO")
        );        
        echo '<div class="btn-group" data-toggle="buttons">';
        echo '<label class="btn btn-xs btn-default '.($valor == 0 ? "active" : "").'">';
        echo "<input type=\"radio\" name=\"$name\" value=\"0\" $attrs ".($valor == 0 ? "checked" : "")."> --" . PHP_EOL;
        echo '</label>';
        echo '<label class="btn btn-xs btn-default '.($valor == 1 ? "active" : "").'">';
        echo "<input type=\"radio\" name=\"$name\" value=\"1\" $attrs ".($valor == 1 ? "checked" : "")."> ".$opc[$lang][0] . PHP_EOL;
        echo '</label>';
        echo '<label class="btn btn-xs btn-default '.($valor == 2 ? "active" : "").'">';
        echo "<input type=\"radio\" name=\"$name\" value=\"2\" $attrs ".($valor == 2 ? "checked" : "")."> ".$opc[$lang][1] . PHP_EOL;
        echo '</label>';
        echo '</div>';
    }
    public static function radsMulti($name, $valor, $opciones, $attrs=NULL, $assoc=TRUE){
        if(is_array($opciones)){            
            echo '<div class="btn-group" data-toggle="buttons">';
            foreach ($opciones as $k => $v) {
                if(!$assoc){
                    $v = $k;
                    $k = $opciones[$v];
                }
                echo '<label class="btn btn-xs btn-default '.($valor == $v ? "active" : "").'">';
                echo "<input type=\"radio\" name=\"$name\" value=\"$v\" $attrs ".($valor == $v ? "checked" : "")."> ".$k . PHP_EOL;                
                echo '</label>';                
            }
            echo '</div>';
        }
    }    
    public static function progBar($perc){
        $color = 'progress-bar-info';
        if($perc>=100){
            $color = 'progress-bar-success';
        }
        if($perc<=50){
            $color = 'progress-bar-warning';
        }        
        echo '<div class="progress">
          <div class="progress-bar '.$color.'" role="progressbar" aria-valuenow="'.$perc.'"
          aria-valuemin="0" aria-valuemax="100" style="width:'.$perc.'%">'.$perc.'%</div>
        </div>';        
    }
}
