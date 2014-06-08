<?php
require_once('Data/Data.php');
echo '<pre>';
print_r(Connection::Query('GetRecentServiceCalls', 5));
?>