<?php
foreach($option as $key=>$val){
    echo '<option value="'.$val['menu_id'].'">'.$val['menu_name'].'</option>';
}
?>