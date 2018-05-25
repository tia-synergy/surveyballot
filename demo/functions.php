<?php

function get_month($month)
{
	if($month==1)
	{
		$monthString = "Jan";
	}
	elseif($month==2)
	{
		$monthString = "Feb";
	}
	elseif($month==3)
	{
		$monthString = "Mar";
	}
	elseif($month==4)
	{
		$monthString = "Apr";
	}
	elseif($month==5)
	{
		$monthString = "May";
	}
	elseif($month==6)
	{
		$monthString = "Jun";
	}
	elseif($month==7)
	{
		$monthString = "Jul";
	}
	elseif($month==8)
	{
		$monthString = "Aug";
	}
	elseif($month==9)
	{
		$monthString = "Sep";
	}
	elseif($month==10)
	{
		$monthString = "Oct";
	}
	elseif($month==11)
	{
		$monthString = "Nov";
	}
	elseif($month==12)
	{
		$monthString = "Dec";
	}
	
	return $monthString;
}

function date_difference($datetime)
{
	$currdatetime = date('Y-m-d H:i:s');
	
	$time_one = strtotime($currdatetime);
	$time_two = strtotime($datetime);
	
	$seconds = $time_one - $time_two;
	
	if($seconds>59)
	{
		$minute = floor($seconds/60);
		
		if($minute>59)
		{
			$hours = floor($seconds / 3600);
			
			if($hours>23)
			{
				
			}
			else
			{
				$timediff = "about ".$hours." hours ago";
			}
		}
		else
		{
			$timediff = "about ".$minute." minutes ago";
		}
	}
	else
	{
		$timediff = "about ".$seconds." seconds ago";
	}
	
	return $timediff;
}