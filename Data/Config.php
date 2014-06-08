
<?php
/*
Todo: update this with error handling
Todo: Add complexity so no reload unless specified
*/
class Config 
{
	public static function Get($section)
	{
		return parse_ini_file("Config.ini", true)[$section];
	}
}

?>
