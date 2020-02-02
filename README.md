
Database to CSV to Database

This requires: 
	PHP, MySQL, SQLCMD command line utilities (created with version 15.0)

Designed for Windows Server 2016

Requires setup in dbCommand.bat and index.php to download database tables as CSV files then re-upload them to MySQL database of your choosing. 

Multiple lines can be used in dbCommand.bat in order to download multiple tables as CSV.
exec_timer.vbs can be run to find out the time it takes to execute dbCommand.bat
