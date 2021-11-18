<?php
    namespace AppC;

class TrataDados
{
    public function vencimento($day_expiration, $lastGeneratedBillet = null)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $array = explode('-', date('Y-m-d'));
        $year = $array[0];
        $month = $array[1];
        $day = $array[2];
        
        if($month == '02' && $day_expiration == '30'){$day_expiration = $day_expiration-2;}
        if(strlen($day_expiration) === 1){ $day_expiration = '0'.$day_expiration;}
        
        if($day_expiration < $day)
        {
            $dif = (((int)$day) - ((int)$day_expiration));
            if($dif >= 15)
            {
                $date = date("Y-m-d", mktime(0, 0, 0, date("m")+1 , $day_expiration, date("Y")));
            }else{
                $date = date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+5, date("Y")));
            }
        }else 
        if($lastGeneratedBillet !== "0000-00-00" && $lastGeneratedBillet !== null && $lastGeneratedBillet !== '')
        {
            $mesGerado = explode('-', $lastGeneratedBillet);
            $newData = $mesGerado[0]."-".$mesGerado[1]."-".$day_expiration;
            $lastGeneraratedDate = new \DateTime($newData);
            $currentDate = new \DateTime(date('Y-m-d'));
            $dife = $lastGeneraratedDate->diff($currentDate);

            // Se gerar após o dia 30 e for vencida
            if($mesGerado[1] !== date('m') && $dife->days < 15){
                $date = date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+5, date("Y")));
            }else{
                $date =  $year."-".$month."-".$day_expiration;
            }            
        }else{
            $date =  $year."-".$month."-".$day_expiration;
        }
        return $date;
    }
}
