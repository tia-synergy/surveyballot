<?php
session_start();
if( !isset($_SESSION['email']) )
{
	header("location:index.php");
}

if(isset($_POST["country"]))
{
    // Capture selected country
    $country = $_POST["country"];   
    $state = $_POST["state"];   

    // Define country and city array
    $countryArr = array(
					"United States" => array("Alaska","Alabama","Arkansas","American Samoa","Arizona","California","Colorado","Connecticut","Delaware","District of Columbia","Florida","Georgia","Guam","Hawaii","Indiana","Illinois","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts"),
                    "Canada" => array("Alberta", "British Columbia", "Manitoba","Ontario"),
                );

	// Display city dropdown based on country name
    if($country !== 'Select')
	{
        echo "<select name='states'>";
        foreach($countryArr[$country] as $value){
			$selected = '';
			if($value == $state)
			{
				$selected = ' selected';
			}
			echo "<option value=".$value.$selected.">". $value . "</option>";
        }
        echo "</select>";
    } 
}

?>

<?php /*<select name="usstates">
										<option value="Alaska">Alaska</option>
										<option value="Alabama">Alabama</option>
										<option value="Arkansas">Arkansas</option>
										<option value="American Samoa">American Samoa</option>
										<option value="Arizona">Arizona</option>
										<option value="California">California</option>
										<option value="Colorado">Colorado</option>
										<option value="Connecticut">Connecticut</option>
										<option value="Delaware">Delaware</option>
										<option value="District of Columbia">District of Columbia</option>
										<option value="Florida">Florida</option>
										<option value="Georgia">Georgia</option>
										<option value="Guam">Guam</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Indiana">Indiana</option>
										<option value="Illinois">Illinois</option>
										<option value="Iowa">Iowa</option>
										<option value="Kansas">Kansas</option>
										<option value="Kentucky">Kentucky</option>
										<option value="Louisiana">Louisiana</option>
										<option value="Maine">Maine</option>
										<option value="Maryland">Maryland</option>
										<option value="Massachusetts">Massachusetts</option>
										<option value="Michigan">Michigan</option>
										<option value="Minnesota">Minnesota</option>
										<option value="Missouri">Missouri</option>
										<option value="Montana">Montana</option>
										<option value="Mississippi">Mississippi</option>
										<option value="Northern Mariana Islands">Northern Mariana Islands</option>
										<option value="North Carolina">North Carolina</option>
										<option value="North Dakota">North Dakota</option>
										<option value="Nebraska">Nebraska</option>
										<option value="New Hampshire">New Hampshire</option>
										<option value="New Jersey">New Jersey</option>
										<option value="New Mexico">New Mexico</option>
										<option value="New York">New York</option>
										<option value="Nevada">Nevada</option>
										<option value="Ohio">Ohio</option>
										<option value="Oklahoma">Oklahoma</option>
										<option value="Oregon">Oregon</option>
										<option value="Pennsylvania">Pennsylvania</option>
										<option value="Puerto Rico">Puerto Rico</option>
										<option value="Rhode Island">Rhode Island</option>
										<option value="South Carolina">South Carolina</option>
										<option value="South Dakota">South Dakota</option>
										<option value="Texas">Texas</option>
										<option value="Tennessee">Tennessee</option>
										<option value="Utah">Utah</option>
										<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
										<option value="Vermont">Vermont</option>
										<option value="Virgin Islands">Virgin Islands</option>
										<option value="Virginia">Virginia</option>
										<option value="Washington">Washington</option>
										<option value="Wisconsin">Wisconsin</option>
										<option value="West Virginia">West Virginia</option>
										<option value="Wyoming">Wyoming</option>
									</select>
									<select name="canadastates" style="display:none;">
										<option value="Alberta">Alberta</option>
										<option value="British Columbia">British Columbia</option>
										<option value="Manitoba">Manitoba</option>
										<option value="New Brunswick">New Brunswick</option>
										<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
										<option value="Nova Scotia">Nova Scotia</option>
										<option value="Nunavut">Nunavut</option>
										<option value="Northwest Territories">Northwest Territories</option>
										<option value="Ontario">Ontario</option>
										<option value="Prince Edward Island">Prince Edward Island</option>
										<option value="Quebec">Quebec</option>
										<option value="Saskatchewan">Saskatchewan</option>
										<option value="Yukon Territory">Yukon Territory</option>
									</select>*/?>