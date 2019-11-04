<?php 

$mysql_host = "localhost";
$mysql_user = "mblea780_junaid";
$mysql_pass = "Junachop123";
$mysql_database = "mblea780_bl";
$backup_folder = "/home/mblea780/Backups/";
$mysql_backup_file_name="mysql_backup_mbl.sql";
//$mysql_backup_file_name="mysql_backup_".date('d-m-Y');

$return_var = NULL;
$output = NULL;
$command = "/usr/bin/mysqldump -u $mysql_user -h localhost -p$mysql_pass $mysql_database > $backup_folder".$mysql_backup_file_name;
exec($command, $output, $return_var);



$folder_to_backup = "/home/mblea780/public_html";
$backup_folder = "/home/mblea780/Backups/";
$zipped_file_name="site_files_backup_mbl.tar.gz";
$path_to_save=$backup_folder.$zipped_file_name;


exec("tar -cvzf $path_to_save $folder_to_backup/* --exclude='$folder_to_backup/*.gz'", $results, $result_value);

?>