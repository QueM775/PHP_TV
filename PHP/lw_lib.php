<?php
$iLogLvlDebug=0;
$iLogLvlInfo=1;
$iLogLvlCritical=2;
$_SESSION['LogLvl'] = 0;
$sLogFileName = './_--PHP_SmartTV.log';
/** 
 * This function writes log data into the given log file
 * The folder (which you are writing in) must be 777 or 7??-for-the-'www-data'-user
 * 
*/
function LW($sFullPhpFileName, $iCodeLine, $sMessage, $iLogLvl=0){
  global $sLogFileName;
  if ($iLogLvl <= $_SESSION['LogLvl']) { // log level
    if (file_exists($sLogFileName)){
      $fpLog = fopen($sLogFileName, 'a') or die("Can't append to the file");
      # Just open for append
      $blnChangeFileMode = 0;
    }
    else{
      # Create for append and change access rights
      $fpLog = fopen($sLogFileName, 'w')  or die("Can't create file");
      $blnChangeFileMode = 1;
    }
    
    fwrite($fpLog,
    date("H:i:s",time()) . // "Y-m-d H:i:s"
    " " .
    substr(session_id(), 0, 4) .
    " " .
    $iLogLvl .
    " " .
    fnShortFileName($sFullPhpFileName) .
    ":" .
    substr("      " . $iCodeLine, -5) .
    " " .
    $sMessage  .
    PHP_EOL
    );
  
    fclose($fpLog);
    if ($blnChangeFileMode == 1){
      chmod($sLogFileName, 0777);
    }
  } // log level
}

function fnShortFileName($sFullPhpFIleName){
  $arrFolders = explode("/", $sFullPhpFIleName);
  return substr( "                                          " . $arrFolders[count($arrFolders) - 1], -20);
}


?>
