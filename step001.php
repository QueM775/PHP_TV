<?php
$iLogLvlDebug   =0;
$iLogLvlInfo    =1;
$iLogLvlCritical=2;

require_once('lw_lib.php');
LW (__FILE__, __LINE__, "Hello world");

$sHomeHtmlFolder = getcwd(); # this statement makes this PHP file 'movable'
                             # PHP code will always start looking for subfolders from current folder
                             # where "current folder" is where this PHP file is located
$sAcriveDirectory = $sHomeHtmlFolder;
LW (__FILE__, __LINE__, "sAcriveDirectory=" . $sAcriveDirectory);




LW (__FILE__, __LINE__, "~~~~~~~~~~~~~~~~~~~~~~~~~~~"); 
echo("Dir-1-############################</br>");
$arrSubFolders = fnGetFoldersOnly($sAcriveDirectory);
for ($ii = 0; $ii < count($arrSubFolders); $ii++){
  LW (__FILE__, __LINE__, "ii=$ii sub-folder=$arrSubFolders[$ii]");
  echo "arrSubFolders[$ii]=" . $arrSubFolders[$ii] . "</br>";
}

echo("</br>Dir-2-############################</br>");
$arrSubFolders = fnGetFoldersOnly($sAcriveDirectory . "/Data");
for ($ii = 0; $ii < count($arrSubFolders); $ii++){
  LW (__FILE__, __LINE__, "ii=$ii sub-folder=$arrSubFolders[$ii]");
  echo "arrSubFolders[$ii]=" . $arrSubFolders[$ii] . "</br>";
}

echo("</br>Dir-3-############################</br>");
$arrSubFolders = fnGetFoldersOnly($sAcriveDirectory . "/Data/Links-orig.LNK");
for ($ii = 0; $ii < count($arrSubFolders); $ii++){
  LW (__FILE__, __LINE__, "ii=$ii sub-folder=$arrSubFolders[$ii]");
  echo "arrSubFolders[$ii]=" . $arrSubFolders[$ii] . "</br>";
}

echo("</br>File-1-############################</br>");
LW (__FILE__, __LINE__, "~~~~~~~~~~~~~~~~~~~~~~~~~~~");
$arrFiles = fnGetFilesOnly($sAcriveDirectory);
for ($ii = 0; $ii < count($arrFiles); $ii++){
  LW (__FILE__, __LINE__, "ii=$ii sub-folder=$arrFiles[$ii]");
  echo "arrFiles[$ii]=" . $arrFiles[$ii] . "</br>";
}

echo("Done-############################</br>");



function fnGetFoldersOnly($sStartFolder){
  # source https://www.sitepoint.com/community/t/how-to-list-folder-names/4548
  $arr = glob($sStartFolder. "/*", GLOB_ONLYDIR);
  $sUpPath = getcwd() . "/";
  for ($iIndx=0; $iIndx < count($arr); $iIndx++){
    $arr[$iIndx] = str_replace($sUpPath, "", $arr[$iIndx]);
  }
  return $arr;
}

function fnGetFilesOnly($sStartFolder){
  $arrFilesOnly = array();
  $arrAllEntities = glob($sStartFolder. "/*");
  $sUpPath = getcwd() . "/";

  foreach ($arrAllEntities as $onee) {
    if(is_file($onee)){
      array_push($arrFilesOnly, str_replace($sUpPath, "", $onee));
    }
  }
  return $arrFilesOnly;
}

?>