<?php 
    if(empty($vocabulary)){
?>
    <h3 class="text-center" style="color : #ccc;margin-top: 10px">HIỆN TẠI KHÔNG CÓ DỮ LIỆU</h3>
<?php
    }else{
 ?>
<table class="table table-bordered table-primary">
    <?php foreach($vocabulary as $vol){ ?>                      
        <tr class="row-vocabulary" data-id="<?=$vol['id']?>" data-type="<?php if(!empty($vol['type'])) echo $vol['type'];?>" data-e="<?=$vol['e_name']?>" data-v="<?=$vol['v_name']?>" data-class="<?=$vol['class']?>">
            <td><?=$vol['e_name']?> <?php if(!empty($vol['type'])) echo '('.$vol['type'].')';?></td>
            <td><?=$vol['v_name']?></td>
        </tr>
    <?php } ?>
</table>
<?php        
    }
?>