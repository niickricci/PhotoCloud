<?php
function dateFR($time) {
    //Documentation : https://www.php.net/manual/fr/intldateformatter.format
    $formatter = new IntlDateFormatter(
        'fr_CA',                      
        IntlDateFormatter::FULL,      
        IntlDateFormatter::FULL,      
        'America/New_York',           
        IntlDateFormatter::GREGORIAN, 
        "EEEE 'le' d MMMM '@' HH:mm:ss" // format
    );

    $date = $formatter->format($time);

    //Mettre en majuscule la premiere lettre
    $date = mb_strtoupper(mb_substr($date, 0, 1, "UTF-8")) . mb_substr($date, 1, null, "UTF-8");;

    return $date;
}
?>