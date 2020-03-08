<?php
$iLogLvlDebug   =0;
$iLogLvlInfo    =1;
$iLogLvlCritical=2;

require_once('lw_lib.php');
LW (__FILE__, __LINE__, "Hello world");

$sHomeOSdir = getcwd(); # this statement makes this PHP file 'movable'
                             # PHP code will always start looking for subfolders from current folder
                             # where "current folder" is where this PHP file is located
# Read what user gave you
$sSctiveDirRelative = $_GET["fldr"];
# Validate what user gave you
if ($sSctiveDirRelative == "" or !file_exists($sSctiveDirRelative) ){
  # If it is no input from user or folder name does not exist
  # set the default folder 
  $sSctiveDirRelative = "Data";
}

$sActiveOSdir = fnFldrNameChk($sHomeOSdir) . fnFldrNameChk($sSctiveDirRelative);
LW (__FILE__, __LINE__, "sHomeOSdir        =$sHomeOSdir"); 
LW (__FILE__, __LINE__, "sSctiveDirRelative=$sSctiveDirRelative"); 
LW (__FILE__, __LINE__, "sActiveOSdir      =$sActiveOSdir");
echo ( "sHomeOSdir=" . $sHomeOSdir . "</br>");
echo ( "sActiveOSdir=" . $sActiveOSdir . "</br>");




LW (__FILE__, __LINE__, "~~~~~~~~~~~~~~~~~~~~~~~~~~~"); 
echo("Dir-1-############################</br>");
$arrSubFolders = fnGetFoldersOnly($sActiveOSdir);
for ($ii = 0; $ii < count($arrSubFolders); $ii++){
  $sTmp = fnFldrNameChk($arrSubFolders[$ii]);
  LW (__FILE__, __LINE__, "ii=$ii sTmp=$sTmp");
  echo fnFldrName2Link($sTmp) . "</br>";
}

echo("</br>File-1-############################</br>");
LW (__FILE__, __LINE__, "~~~~~~~~~~~~~~~~~~~~~~~~~~~");
$arrFiles = fnGetFilesOnly($sActiveOSdir);
for ($ii = 0; $ii < count($arrFiles); $ii++){
  LW (__FILE__, __LINE__, "ii=$ii sub-folder=$arrFiles[$ii]");
  echo "arrFiles[$ii]=" . $arrFiles[$ii] . "</br>";
}

echo("Done-############################</br>");












function fnGetFoldersOnly($sStartFolder){
  # source https://www.sitepoint.com/community/t/how-to-list-folder-names/4548
  $arr = glob($sStartFolder. "/*", GLOB_ONLYDIR);
  $sUpperPath = getcwd() . "/";
  for ($iIndx=0; $iIndx < count($arr); $iIndx++){
    $arr[$iIndx] = str_replace($sUpperPath, "", $arr[$iIndx]);
  }
  return $arr;
}

function fnGetFilesOnly($sStartFolder){
  $arrFilesOnly = array();
  $arrAllEntities = glob($sStartFolder. "/*");
  $sUpperPath = getcwd() . "/";

  foreach ($arrAllEntities as $onee) {
    if(is_file($onee)){
      array_push($arrFilesOnly, str_replace($sUpperPath, "", $onee));
    }
  }
  return $arrFilesOnly;
}

function fnFldrName2Link($sFolderName){
  $sResult = "<a href=step002.php?fldr=@href>@Text</a>";
  $sFolderName = fnFldrNameChk($sFolderName);
  
  $arrTemp = explode("/", $sFolderName);
  $sTailFolderName = $arrTemp[count($arrTemp) - 2];

  $sResult = str_replace("@href", $sFolderName, $sResult);
  $sResult = str_replace("@Text", $sTailFolderName, $sResult);
  return $sResult;
}

function fnFldrNameChk($sInputFolderName){
  if ( substr($sInputFolderName, -1, 1) != "/"){
    $sInputFolderName = $sInputFolderName . "/";
  }
  $sInputFolderName = str_replace("//", "/", $sInputFolderName);
  return $sInputFolderName;
}
?>