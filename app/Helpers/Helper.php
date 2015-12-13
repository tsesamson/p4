<?php

namespace App\Helpers;

class Helper
{
    /*
    |--------------------------------------------------------------------------
    | Helper Methods for this application
    |--------------------------------------------------------------------------
    |
    | This class will store all the custom methods used for this application.
    |
    */

    public static function create()
    {
        $helper = new Helper();

        return $helper;
    }
    
	/*
	 * This method is used to confirm if the string is in a valid duration format (i.e. 00:00:00, 0:00:00, 00:00, 0:00, 00) 
	 */
    public function checkDuration($string)
    {
		// If it is a single number and it is less than 24 then it is just hours
		if(is_numeric($string)) {
			if(intval($string)>0 && intval($string)<24) { return true;}
		}
		
		// Split the text
		$durationArray = explode(":", $_POST['txtInputDuration']);
		
		if(count($durationArray) == 2) {
			if(is_numeric($durationArray[0]) && is_numeric($durationArray[1])) {
				if(intval($durationArray[0])>=0 && intval($durationArray[0])<24) {
					if(intval($durationArray[1])>=0 && intval($durationArray[1])<60) {
						return true;
					}
				}
			}	
		} 
		
		if(count($durationArray) == 3) {
			if(is_numeric($durationArray[0]) && is_numeric($durationArray[1]) && is_numeric($durationArray[2])) {
				if(intval($durationArray[0])>=0 && intval($durationArray[0])<24) {
					if(intval($durationArray[1])>=0 && intval($durationArray[1])<60) {
						if(intval($durationArray[2])>=0 && intval($durationArray[2])<60) {
							return true;
						}
					}
				}
			}				
		}
		
        return false;
    }
	
	public function getDurationInSeconds($string){
		$result = 0;
		
		// If it is a single number and it is less than 24 then it is just hours
		if(is_numeric($string)) {
			if(intval($string)>0 && intval($string)<24) { 
				return intval($string)*60*60; //Convert hours to seconds
			}
		}
		
		// Split the text
		$durationArray = explode(":", $_POST['txtInputDuration']);
		
		if(count($durationArray) == 2) {
			if(is_numeric($durationArray[0]) && is_numeric($durationArray[1])) {
				if(intval($durationArray[0])>=0 && intval($durationArray[0])<24) {
					if(intval($durationArray[1])>=0 && intval($durationArray[1])<60) {
						$result += intval($durationArray[0])*60*60; // Convert hours to seconds
						$result += intval($durationArray[1])*60; // Convert minutes to seconds
						
						return $result;
					}
				}
			}	
		} 
		
		if(count($durationArray) == 3) {
			if(is_numeric($durationArray[0]) && is_numeric($durationArray[1]) && is_numeric($durationArray[2])) {
				if(intval($durationArray[0])>=0 && intval($durationArray[0])<24) {
					if(intval($durationArray[1])>=0 && intval($durationArray[1])<60) {
						if(intval($durationArray[2])>00 && intval($durationArray[2])<60) {
							$result += intval($durationArray[0])*60*60; // Convert hours to seconds
							$result += intval($durationArray[1])*60; // Convert minutes to seconds
							$result += intval($durationArray[2]); // Add final seconds
							
							return $result;
						}
					}
				}
			}				
		}

		return $result;
	}
}
