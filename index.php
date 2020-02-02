<?php

	//Local Database connection via MAMP defaults
	$conn = mysqli_connect("localhost", "root", "root", "test");

	//Array of CSV file names that exist / database file names to be created
	$DBS = array( "db1" , "db2" , "db3");

	//Loop through all CSV to database conversions
	foreach ($DBS as $varyingName){

	echo "Operation: " . $varyingName . "<br><br>"; //HTML shows current file

	$file = fopen("path\\".$varyingName.".csv","r"); //Path of CSVs

	echo "Dropping Table: " . $varyingName . "<br><br>";

	$sqlInsert = "DROP TABLE IF EXISTS `$varyingName`";
	$result = mysqli_query($conn, $sqlInsert);

//DYNAMIC TABLE NAME CREATION WITH ROW HEADERS BASED ON CSV
$row = 0;
$headers = NULL;
while ($data = fgetcsv($file))
{
    if (($row==0)&&($row<1))//Grab only row 0 aka first row
    {
				$arrayItem = 0;
				$sqlInsert = "CREATE TABLE ".$varyingName." ( " ;
        foreach ($data as $cell)
        {
					 if( $arrayItem < (sizeof($data)-1) ) //For all but last item format as varchar for mysql
					 {
					 $sqlInsert = $sqlInsert . rtrim($cell) . " VARCHAR(30) NOT NULL, \n" ;
					 $headers[] = "`". rtrim($cell)."`";
					 $arrayItem++;
				 	} else {		//For last item format as varchar for mysql
					 $sqlInsert = $sqlInsert . $cell . " VARCHAR(30) NOT NULL \n" ;
					 $headers[] = "`". rtrim($cell)."`";
					 $arrayItem++;
				 }

			 }//end for each data from csv
    }//end grabbing row headers from csv
    else if ($row>=1)
    {
        break;
    }
		$row++;
}//end reading csv

			$sqlInsert = $sqlInsert . ")" ; //close syntax for mysql command
			echo "First Row Insert SQL Command: <br>" . $sqlInsert . "<br><br>";
	    $result = mysqli_query($conn, $sqlInsert); //Actual data insertion
			echo "CSV to Table Insert <br> ";

         while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
					 $temparray = NULL;
					 for ($x = 0; $x <= sizeof($column); $x++) {	//trim and format row item for each column
								$temparray[] = "'". rtrim($column[$x])."'";
						} //end for loop

						//insert into database at row header from csv 1 row item (this while loops)
					 	$sqlInsert = "INSERT INTO ".$varyingName." (". implode(",",$headers) . ") VALUES (" . implode(",",$temparray) ;
					 	$sqlInsert = substr($sqlInsert, 0, -3) . ")"; //eliminate extraneous quotes caused by row array implode
						$result = mysqli_query($conn, $sqlInsert); //Actual data insertion

						//Below IF Else doesn't actually appear in HTML... its a return message leftover from a form submit version of CSV to database upload
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        } // end while
				echo "Completed Insert <br> END <br> <br> -------------------- <br> <br>";
			}//end for each
?>
