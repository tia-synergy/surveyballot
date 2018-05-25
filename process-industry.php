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
   // $subindustry = $_POST["subindustry"];   

    // Define industry and sub industry array
    $industryArr = array(
					"Advertising & Marketing" => array("Industry","Accounting","Airlines/Aviation","Alternative Dispute Resolution","Alternative Medicine","Animation","Apparel/Fashion","Architecture/Planning","Arts/Crafts","Automotive","Aviation/Aerospace","Banking/Mortgage","Biotechnology/Greentech","Broadcast Media","Building Materials","Business Supplies/Equipment","Capital Markets/Hedge Fund/Private Equity","Chemicals","Civic/Social Organization","Civil Engineering","Commercial Real Estate","Computer Games","Computer Hardware","Computer Networking","Computer Software/Engineering","Computer/Network Security","Construction","Consumer Electronics","Consumer Goods","Consumer Services","Cosmetics","Dairy","Defense/Space","Design","E-Learning","Education Management","Electrical/Electronic Manufacturing","Entertainment/Movie Production","Environmental Services","Events Services","Executive Office","Facilities Services","Farming","Financial Services","Fine Art","Fishery","Food Production","Food/Beverages","Fundraising","Furniture","Gambling/Casinos","Glass/Ceramics/Concrete","Government Administration","Government Relations","Graphic Design/Web Design","Health/Fitness","Higher Education/Acadamia","Hospital/Health Care","Hospitality","Human Resources/HR","Import/Export","Individual/Family Services","Industrial Automation","Information Services","Information Technology/IT","Insurance","International Affairs","International Trade/Development","Internet","Investment Banking/Venture","Investment Management/Hedge Fund/Private Equity","Judiciary","Law Enforcement","Law Practice/Law Firms","Legal Services","Legislative Office","Leisure/Travel","Library","Logistics/Procurement","Luxury Goods/Jewelry","Machinery","Management Consulting","Maritime","Market Research","Marketing/Advertising/Sales","Mechanical or Industrial Engineering","Media Production","Medical Equipment","Medical Practice","Mental Health Care","Military Industry","Mining/Metals","Motion Pictures/Film","Museums/Institutions","Music","Nanotechnology","Newspapers/Journalism","Non-Profit/Volunteering","Oil/Energy/Solar/Greentech","Online Publishing","Other Industry","Outsourcing/Offshoring","Package/Freight Delivery","Packaging/Containers","Paper/Forest Products","Performing Arts","Pharmaceuticals","Philanthropy","Photography","Plastics","Political Organization","Primary/Secondary Education","Printing","Professional Training","Program Development","Public Relations/PR","Public Safety","Publishing Industry","Railroad Manufacture","Ranching","Real Estate/Mortgage","Recreational Facilities/Services","Religious Institutions","Renewables/Environment","Research Industry","Restaurants","Retail Industry","Security/Investigations","Semiconductors","Shipbuilding","Sporting Goods","Sports","Staffing/Recruiting","Supermarkets","Telecommunications","Textiles","Think Tanks","Tobacco","Translation/Localization","Transportation","Utilities","Venture Capital/VC","Veterinary","Warehousing","Wholesale","Wine/Spirits","Wireless","Writing/Editing"),
                    "Business Support Services Sector" => array("Please Select","Bookkeeping", "Business Service Centers & Copy Shops", "Commercial Printing"),
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
			//echo "<option value=".$value.$selected.">". $value . "</option>";
			echo "<option value='".$value."' '".$selected.">". $value . "</option>";
        }
        echo "</select>";
    } 
}
?>