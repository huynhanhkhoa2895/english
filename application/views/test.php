<?php 
$str = "g fmnc wms bgblr rpylqjyrc gr zw fylb. rfyrq ufyr amknsrcpq ypc dmp. bmgle grgl zw fylb gq glcddgagclr ylb rfyr'q ufw rfgq rcvr gq qm jmle.";
function giaiMa($str){
    $string = "";
    foreach(str_split($str) as $it){
        $char="";
        switch($it){
            case "m" : $char = "k";
            break; 
            case "q" : $char = "o";
            break; 
            case "g" : $char = "e";
            break; 
            default : $char = $it;
            break;
        }
        $string .= $char;
    }
    return $string;
}
echo giaiMa($str);
?>
