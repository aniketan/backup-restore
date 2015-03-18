<?php 
//  http://buffernow.com/backup-and-restore-class-mysql-database-using-php-script/

require_once('backup_restore.class.php');

/** config. php **/
$db_host ="localhost";
$db_user = "rcatest";
$db_pass ="";
$db_name ="rcatest";
/****************/

if(isset($_REQUEST['backup'])){
    $newImport = new backup_restore($db_host,$db_name,$db_user,$db_pass);
    
    $fileName = $db_name . "_" . date("Y-m-d_H-i-s") . ".sql";    
    // Header description Taken from http://stackoverflow.com/a/10766725
    header("Content-disposition: attachment; filename=".$fileName);
    header("Content-Type: application/force-download");
    //header("Content-Transfer-Encoding: application/zip;\n");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
    header("Expires: 0");

    //call of backup function
    echo $newImport -> backup(); die();
    
}

if(isset($_REQUEST['restore'])){
    $newImport = new backup_restore($db_host,$db_name,$db_user,$db_pass);
    $filetype = $_FILES['rfile']['type'];
    $filename = $_FILES['rfile']['tmp_name'];
    $error = ($_FILES['rfile']['tmp_name'] == 0)? false:true ;
    if ($filetype == "application/octetstream" && !$error) {
        //call of restore function
        $message = $newImport -> restore ($filename);
        echo $message;
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"  dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Buffer Now (Back up And Restore Script)</title>
</head>
<body>
    <form name="import" action="" method="POST" enctype="multipart/form-data">
        <label>File to Restore from: </label><input type="file" name="rfile" />
        <p>
            <input type="submit"  name="backup" value="Backup">
            <input type="submit" name="restore" value="Restore">
        </p>
    </form>
</body>