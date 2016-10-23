<?php
class basePaginate
{
    public $items;
    public $next;
    public $prev;
    public $page;
    public $total;
    public $count;
    public $per_page;
    public $error = array();    
    
    public function __construct($table, $where=array(), $page = 1, $per_page = 10)
    {       
        $dbm = new medoo();
        if ($page < 1 || $per_page < 1) {
            $this->error[] = "La página $page no existe en el páginador";
        }
        $start = $per_page * ($page - 1);
        $n = $dbm->count($table, $where);
        if ($page > 1 && $start >= $n) {
            $this->error[] = "La página $page no existe en el páginador";
        }                
        $this->items = $dbm->select($table,'*',array_merge($where,array("LIMIT"=>array($start,$per_page))));        
        //echo var_dump($dbm);
        //exit(0);         
        $this->next = ($start + $per_page) < $n ? ($page + 1) : false;
        $this->prev = ($page > 1) ? ($page - 1) : false;
        $this->page = $page;
        $this->total = ceil($n / $per_page);
        $this->count = $n;
        $this->per_page = $per_page;
    }     
    public function showBasic()
    {
        if($this->total > 1){
            $show = $this->per_page;
            $half = floor($show/2);
            // Calculando el inicio de paginador centrado
            if ($this->page <= $half) {
                $start = 1;
            } 
            elseif (($this->total - $this->page)<$half) 
            {
                $start = $this->total - $show + 1;
                if($start < 1){
                    $start = 1;               
                }
            } 
            else 
            {
                $start = $this->page - $half;
            }       
            echo '<ul>';           
            //echo '<li><a href="javascript:redirectParams({page: 1 })"><<</a></li>';
            if($this->prev){
                echo '<li><a href="javascript:redirectParams({page: '.$this->prev.' })"><</a></li>';
            }
            if($start==1){ //se coloca el link sin número de página para la página 1
                $start = 2;
                $show -= 1;
                if($this->page==1){
                    echo '<li><a href="#" class="active">1</a></li>';
                }
                else{
                    echo '<li><a href="javascript:redirectParams({page: 1 })">1</a></li>';
                }
            }

            for($i=$start; $i<=$this->total && $i<($start + $show); $i++){
               if($i==$this->page){
                   echo '<li><a href="#" class="active">'.$i.'</a></li>';
               }
               else{
                   echo '<li><a href="javascript:redirectParams({page: '.$i.' })">'.$i.'</a></li>';
               }
            }            
            if($this->next){
                echo '<li><a href="javascript:redirectParams({page: '.$this->next.' })">></a></li>';
            }
            //echo '<li><a href="javascript:redirectParams({page: '.$this->total.' })">>></a></li>';
            echo '</ul>';
        }  
        //ELSE echo '<ul><li><a href="#" class="active">1</a></li></ul>';
    }
}
class paginate extends basePaginate
{
    public $find;
    public $url;

    public function __construct($url, $table, $where=array(), $page = 1, $per_page = 10, $search = "")
    {
        parent::__construct($table, $where, $page, $per_page);         
        $this->find = $search;
        $this->url = $url;
    }
    public function showHeader()
    {
        echo "<form action=\"\" method=\"get\" id=\"pageForm\" name=\"pageForm\">";
        echo "<input type=\"hidden\" id=\"page\" name=\"page\" value=\"1\"/>";
        echo "<div class=\"dataTables_filter\"><label><span>Buscar:</span>";
        echo "<input type=\"text\" id=\"search\" name=\"search\" value=\"$this->find\" placeholder=\"Capture busqueda...\" maxlength='25'></label>";
        echo "<button class=\"btn bg-teal-400\" title=\"Buscar\"><span class=\"icon icon-search4\"></span></button>";
        echo "<a href=\"$this->url\" class=\"btn btn-default\" title=\"Limpiar\"><span class=\"icon icon-reload-alt\"></span></a></div>";
        echo "<div class=\"dataTables_length\"><label><span>Mostar:</span>";
        echo '<select id="ppage" name="ppage" onchange="document.getElementById(\'pageForm\').submit();">';
        $pps = array(5,10,25,50,100,250,500);
        foreach ($pps as $p) {
            echo '<option value="'.$p.'" '.($this->per_page == $p?'selected':'').'>'.$p.'</option>';
        }
        echo "</select>";
        echo "</label></div></form>";
    }
    public function showFooter()
    {
        $s_item = $this->per_page*($this->page-1) + 1;
        $e_item = $s_item + count($this->items) - 1;
        echo "<div class=\"dataTables_info\" role=\"status\">Página <strong>$this->page</strong> de $this->total&nbsp;|&nbsp;Registro <strong>$s_item al $e_item</strong> de $this->count</div>";
        echo "<div class=\"dataTables_paginate paging_simple_numbers\">";
        if($this->total == 1){
            echo "<span><a class=\"paginate_button current\" tabindex=\"0\">1</a></span>";
        }else{
            $show = $this->per_page;
            $half = floor($show/2);
            // Calculando el inicio de paginador centrado
            if ($this->page <= $half) {
                $start = 1;
            }
            elseif (($this->total - $this->page)<$half)
            {
                $start = $this->total - $show + 1;
                if($start < 1){
                    $start = 1;
                }
            }
            else
            {
                $start = $this->page - $half;
            }
            // DOM
            echo Html::linkGIcon("$this->url&page=1&ppage=$this->per_page&search=$this->find",'step-backward', '', 'title="Ir a la primer página" class="paginate_button "');
            if($this->prev){
                echo Html::linkGIcon("$this->url&page=$this->prev&ppage=$this->per_page&search=$this->find",'backward', '', 'title="Ir a la página anterior" class="paginate_button"');
            }
            echo "<span>";
            if($start==1){ //se coloca el link sin número de página para la página 1
                $start = 2;
                $show -= 1;
                echo $this->page==1 ? '<a class="paginate_button current">1</a>' : '<a href="'.$this->url.'&page=1&ppage='.$this->per_page.'&search='.$this->find.'" class="paginate_button">1</a>';
            }

            for($i=$start; $i<=$this->total && $i<($start + $show); $i++){
                echo $i==$this->page ? '<a class="paginate_button current">'.$i.'</a>' : '<a href="'.$this->url.'&page='.$i.'&ppage='.$this->per_page.'&search='.$this->find.'" class="paginate_button">'.$i.'</a>';
            }
            echo "</span>";
            if($this->next){
                echo Html::linkGIcon("$this->url&page=$this->next&ppage=$this->per_page&search=$this->find",'forward', '', 'title="Ir a la pág. siguiente" class="paginate_button"');
            }
            echo Html::linkGIcon("$this->url&page=$this->total&ppage=$this->per_page&search=$this->find",'step-forward', '', 'title="Ir a la última página" class="paginate_button"');

        }
        echo "</div>";
    }
    public function showExtended($pholder = "Buscar",$filters=array())
    {
        $s_item = $this->per_page*($this->page-1) + 1;
        $e_item = $s_item + count($this->items) - 1;
        
        echo '<div class="paginator">';
        echo '<form action="" method="get" id="pageForm" name="pageForm">';
        echo '<input type="hidden" id="page" name="page" value="1"/>';
        if(count($filters)>0){
            echo 'Filtrar por:&nbsp;';
            foreach ($filters as $key => $value) {
                $cK = Input::getHasVal($key) ? Input::get($key) : 0;
                echo '<select id="'.$key.'" name="'.$key.'" onchange="document.getElementById(\'pageForm\').submit();">';
                echo '<option value="" '.($cK == 0?'selected':'').'>-'.$key.'-</option>';
                foreach ($value as $k => $v) {
                    echo '<option value="'.$k.'" '.($cK == $k?'selected':'').'>'.$v.'</option>';
                }
                echo '</select>&nbsp;';
            }
            echo '|&nbsp;';
        }
        echo '<input type="text" id="search" name="search" value="'.$this->find.'" placeholder="'.$pholder.'" />';
        echo '<button class="btn btn-success btn-xs" title="Buscar"><span class="glyphicon glyphicon-search"></span>&nbsp;Buscar</button>&nbsp;|&nbsp;&nbsp;';
        echo '<select id="ppage" name="ppage" onchange="document.getElementById(\'pageForm\').submit();">';
        $pps = array(5,10,25,50,100,250,500);
        foreach ($pps as $p) {
            echo '<option value="'.$p.'" '.($this->per_page == $p?'selected':'').'>'.$p.'</option>';
        }
        echo '</select>&nbsp;x Pág&nbsp;|&nbsp;';
        if($this->prev){
            echo Html::linkGIcon("$this->url&page=$this->prev&ppage=$this->per_page&search=$this->find","backward", '', 'title="Ir a la pág. anterior" class="nextprev" rel="prev"');
            echo '&nbsp;|&nbsp;';
        }
        echo 'Pág. <strong>'.$this->page.'</strong> / '.$this->total.
             '&nbsp;|&nbsp;Registro <strong>'.$s_item.' al '.$e_item.'</strong> de '.$this->count.'&nbsp;|&nbsp;';
        if($this->next){
            echo Html::linkGIcon("$this->url&page=$this->next&ppage=$this->per_page&search=$this->find",'forward', '', 'title="Ir a la pág. siguiente" class="nextprev" rel="next"');
        }
        echo '</form></div>';
    }
    public function showClassic()
    { 
        if($this->total == 1){
            echo '<ul class="pagination pagination-sm"><li class="active"><span>1</span></li></ul>';
        }
        else{
            $show = $this->per_page;
            $half = floor($show/2);
            // Calculando el inicio de paginador centrado
            if ($this->page <= $half) {
                $start = 1;
            } 
            elseif (($this->total - $this->page)<$half) 
            {
                $start = $this->total - $show + 1;
                if($start < 1){
                    $start = 1;               
                }
            } 
            else 
            {
                $start = $this->page - $half;
            }       
            echo '<ul class="pagination pagination-sm">';
            echo '<li>'. Html::linkGIcon("$this->url&page=1&ppage=$this->per_page&search=$this->find",'step-backward', '', 'title="Ir a la primer página" class="nextprev" rel="prev"') .'</li><li>';
            if($this->prev){
                echo Html::linkGIcon("$this->url&page=$this->prev&ppage=$this->per_page&search=$this->find",'backward', '', 'title="Ir a la página anterior" class="nextprev" rel="prev"');
            }
            echo '</li>';
            if($start==1){ //se coloca el link sin número de página para la página 1
                $start = 2;
                $show -= 1;
                echo $this->page==1 ? '<li class="active"><span>1</span></li>' : '<li><a href="'.$this->url.'&page=1&ppage='.$this->per_page.'&search='.$this->find.'">1</a></li>';
            }

            for($i=$start; $i<=$this->total && $i<($start + $show); $i++){
               echo $i==$this->page ? '<li class="active"><span>'.$i.'</span></li>' : '<li><a href="'.$this->url.'&page='.$i.'&ppage='.$this->per_page.'&search='.$this->find.'">'.$i.'</a></li>';
            }
            echo '<li>';
            if($this->next){
                echo Html::linkGIcon("$this->url&page=$this->next&ppage=$this->per_page&search=$this->find",'forward', '', 'title="Ir a la pág. siguiente" class="nextprev" rel="next"');
            }
            echo '</li><li>'.Html::linkGIcon("$this->url&page=$this->total&ppage=$this->per_page&search=$this->find",'step-forward', '', 'title="Ir a la última página" class="nextprev" rel="prev"').'</li></ul>';
        }
    }
}
