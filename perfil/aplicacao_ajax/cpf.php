<?php

function time_diff($dt1,$dt2) {
    $y1 = substr($dt1,0,4);
    $m1 = substr($dt1,5,2);
    $d1 = substr($dt1,8,2);
    $h1 = substr($dt1,11,2);
    $i1 = substr($dt1,14,2);
    $s1 = substr($dt1,17,2);    

    $y2 = substr($dt2,0,4);
    $m2 = substr($dt2,5,2);
    $d2 = substr($dt2,8,2);
    $h2 = substr($dt2,11,2);
    $i2 = substr($dt2,14,2);
    $s2 = substr($dt2,17,2);    

    $r1=date('U',mktime($h1,$i1,$s1,$m1,$d1,$y1));
    $r2=date('U',mktime($h2,$i2,$s2,$m2,$d2,$y2));
    return ($r1-$r2);

}	

function cpf_ok($cpf) {
    $cpf = str_replace(".","",$cpf);
    $cpf = str_replace("-","",$cpf);

    $ativado = mysql_query("SELECT * FROM seis_meses");
    $ativado = mysql_fetch_array($ativado);
    $ativado = $ativado["app"];
    
    if($ativado == 1) {
        $get_cpf = mysql_query("SELECT cpf, data_aplic FROM aplicacoes WHERE cpf = '$cpf' ORDER BY data_aplic DESC");
        if(mysql_num_rows($get_cpf) == 0) {
            return true;
        } else {
            $get_cpf = mysql_fetch_array($get_cpf);
            $the_cpf = $get_cpf["cpf"];
            $the_data = $get_cpf["data_aplic"];
            $hoje = date("Y-m-d H:i:s");
            if($the_cpf == $cpf) {
                $tempo_seg = time_diff($hoje,$the_data);
                //15552000 são 6 meses em seg
                if($tempo_seg <= 15552000) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
    } else {
        return true;
    }
}
?>