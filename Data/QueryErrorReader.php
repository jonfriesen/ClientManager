<?php
/* Provides a non-breaking API for returning an empty data set if a query fails */
class QueryErrorReader implements IDataReader
{
	public function Read()
	{
		return false;
	}
	public function Close()
	{
	}
}
?>