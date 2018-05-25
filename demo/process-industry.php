<?php
session_start();
if( !isset($_SESSION['email']) )
{
	header("location:index.php");
}

if(isset($_POST["industry"]))
{
    // Capture selected industry
    $industry = $_POST["industry"];   
    $subindustry = $_POST["subindustry"];   

    // Define industry and sub industry array
    $industryArr = array(
					"Advertising & Marketing" => array("Advertising","Marketing","Search Engine Optimization"),
                    "Business Support Services Sector" => array("Bookkeeping", "Business Service Centers & Copy Shops", "Commercial Printing"),
                );

	// Display sub industry dropdown based on industry
    if($industry !== 'Select')
	{
        echo "<select name='industry2'>";
        foreach($industryArr[$industry] as $value){
            $selected = '';
			if($value == $subindustry)
			{
				$selected = ' selected';
			}
			echo "<option value=".$value.$selected.">". $value . "</option>";
        }
        echo "</select>";
    } 
}
?>