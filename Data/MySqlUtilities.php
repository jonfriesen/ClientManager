<?php
function mysqli_escape ( $text ) 
{
	if(is_numeric($text))
		$text = $text;
	else
		$text = "'".mysql_escape_string($text)."'";
	return $text;
}
function convert_datetime($str)
{
	list($date, $time) = explode(' ', $str);
	list($year, $month, $day) = explode('-', $date);
	list($hour, $minute, $second) = explode(':', $time);

	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	return $timestamp;
}
function is_date($date)
    {
        $date = str_replace(array('\'', '-', '.', ','), '/', $date);
        $date = explode('/', $date);

        if(    count($date) == 1 // No tokens
            and    is_numeric($date[0])
            and    $date[0] < 20991231 and
            (    checkdate(substr($date[0], 4, 2)
                        , substr($date[0], 6, 2)
                        , substr($date[0], 0, 4)))
        )
        {
            return true;
        }
       
        if(    count($date) == 3
            and    is_numeric($date[0])
            and    is_numeric($date[1])
            and is_numeric($date[2]) and
            (    checkdate($date[0], $date[1], $date[2]) //mmddyyyy
            or    checkdate($date[1], $date[0], $date[2]) //ddmmyyyy
            or    checkdate($date[1], $date[2], $date[0])) //yyyymmdd
        )
        {
            return true;
        }
       
        return false;
    } 
?>