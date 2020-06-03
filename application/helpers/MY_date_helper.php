<?php

/* BENX */
if (!function_exists('date_castellanize')) {

    function date_castellanize($fecha) {

        if (strpos($fecha, "January")) {
            $resultado = str_replace("January", "Enero", $fecha);
        }
        if (strpos($fecha, "February")) {
            $resultado = str_replace("February", "Febrero", $fecha);
        }
        if (strpos($fecha, "March")) {
            $resultado = str_replace("March", "Marzo", $fecha);
        }
        if (strpos($fecha, "April")) {
            $resultado = str_replace("April", "Abril", $fecha);
        }
        if (strpos($fecha, "May")) {
            $resultado = str_replace("May", "Mayo", $fecha);
        }
        if (strpos($fecha, "June")) {
            $resultado = str_replace("June", "Junio", $fecha);
        }
        if (strpos($fecha, "July")) {
            $resultado = str_replace("July", "Julio", $fecha);
        }
        if (strpos($fecha, "August")) {
            $resultado = str_replace("August", "Agosto", $fecha);
        }
        if (strpos($fecha, "September")) {
            $resultado = str_replace("September", "Septiembre", $fecha);
        }
        if (strpos($fecha, "October")) {
            $resultado = str_replace("October", "Octubre", $fecha);
        }
        if (strpos($fecha, "November")) {
            $resultado = str_replace("November", "Noviembre", $fecha);
        }
        if (strpos($fecha, "December")) {
            $resultado = str_replace("December", "Diciembre", $fecha);
        }
        return str_replace("th", " ", $resultado);

    }

}
/* BENX */
if (!function_exists('date_castellanize_formato_corto_timestamp')) {

    function date_castellanize_formato_corto_timestamp($timestamp) {
        return date("d/m/Y", mysql_to_unix($timestamp));
    }
}

if (!function_exists('date_castellanize_formato_largo_timestamp')) {

    function date_castellanize_formato_largo_timestamp($timestamp) {
        /*
         * Como al importar, ninguno tenía hora y todos salen ", a las 12:00:00, lo quitamos
         */
        return str_replace(" d ", " de ", date_castellanize(date("j \d F \d Y, \a \l\a\s H:i:s", mysql_to_unix($timestamp))));
        //return str_replace(" d ", " de ", date_castellanize(date("j \d F \d Y", mysql_to_unix($timestamp))));
    }

}

if (!function_exists('date_castellanize_formato_largo_sin_hora_timestamp')) {

    function date_castellanize_formato_largo_sin_hora_timestamp($timestamp) {
        return str_replace(" d ", " de ", date_castellanize(date("j \d F \, Y", mysql_to_unix($timestamp))));
    }

}

function dateDiff($d1, $d2) {
// Return the number of days between the two dates:

    return round(abs(strtotime($d1) - strtotime($d2)) / 86400);
}

if (!function_exists('de_fecha_mysql_a_timestamp_mysql')) {

    function de_fecha_mysql_a_timestamp_mysql($fecha) {
        $parts = explode("-", $fecha);
        $ingres = mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]);
        return $ingres;
    }

}
// end function dateDiff

if (!function_exists('dias_diferencia_entre_hoy_y_timestamp')) {

    function dias_diferencia_entre_hoy_y_timestamp($timestamp) {
        //$dStart = new DateTime(date("Y-m-d H:i:s"));
        $dStart = new DateTime(date("Y-m-d"));

        $dEnd = new DateTime(substr($timestamp, 0, 10));

        $dDiff = $dStart->diff($dEnd);

        return $dDiff->days;
    }

}

if (!function_exists('convertir_en_hora_minuto')) {

    function convertir_en_hora_minuto($num) {

        $res = $num / 60;
        $div = explode('.', $res);
        $hor = $div[0]; //aqui obtienes las horas
        $min = $num - (60 * $hor); //aca obtienes los minutos
        return str_pad($hor, 2, "0", STR_PAD_LEFT) . ":" . str_pad($min, 2, "0", STR_PAD_LEFT);
    }

}

    function dateDifference($startDate, $endDate) {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate)
            return false;

        $years = date('Y', $endDate) - date('Y', $startDate);

        $endMonth = date('m', $endDate);
        $startMonth = date('m', $startDate);

        // Calculate months
        $months = $endMonth - $startMonth;
        if ($months <= 0) {
            $months += 12;
            $years--;
        }
        if ($years < 0)
            return false;

        // Calculate the days
        $offsets = array();
        if ($years > 0)
            $offsets[] = $years . (($years == 1) ? ' year' : ' years');
        if ($months > 0)
            $offsets[] = $months . (($months == 1) ? ' month' : ' months');
        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now';

        $days = $endDate - strtotime($offsets, $startDate);
        $days = date('z', $days);

        return array($years, $months, $days);
    }
    function darFormatoFechaActual(){
        $longMonthArray = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
        $shortMonthArray = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic");
        $dayArray = array("","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
        $ds = (int)date('N');
        $d  = date('d');
        $m  = (int)date('m');
        $y  = date('Y');
        $result = $dayArray[$ds] . ', '. $d." ".$longMonthArray[$m]." de ".$y;
        return $result; // Miércoles, 17 Julio de 2016
    }
?>