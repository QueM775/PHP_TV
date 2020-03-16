
<html lang="en">
    
  <head>
      <meta charset="utf-8">
      <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet" type="text/css">
     <?php require_once('./PHP/lw_lib.php');?>
     <link rel="stylesheet" type="text/css" href="CSS/style.css">
      <title>SmartTV_PHP</title> 
  </head>

  <body>
    
<!-- The Box Div goes across the trop left to right. It is the top container -->
    <div class="box"> 
      <!-- The tLeft Div is the top left Folder Div -->
        <div class="tLeft">
            
              <?php 
                LW (__FILE__, __LINE__, "Hello world");

                $sHomeOSdir = getcwd(); # this statement makes this PHP file 'movable'
                             # PHP code will always start looking for subfolders from current folder
                             # where "current folder" is where this PHP file is located
                 # Read what user gave you
                $sSctiveDirRelative = $_GET["fldr"];
                # Validate what user gave you
                if ($sSctiveDirRelative == "" or !file_exists($sSctiveDirRelative) ){
                # We need to set a default folder path.
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
             /* echo("Dir-1-############################</br>");*/
              $arrSubFolders = fnGetFoldersOnly($sActiveOSdir);
              for ($ii = 0; $ii < count($arrSubFolders); $ii++){
                   $sTmp = fnFldrNameChk($arrSubFolders[$ii]);
                   LW (__FILE__, __LINE__, "ii=$ii sTmp=$sTmp");
                   echo fnFldrName2Link($sTmp) . "</br>";
                   }           
              ?>
        </div><!-- Close tLeft Div -->
        <div class="center">

            <div class="player">
                
            </div>

            <div class="Title">

            </div>
        </div><!-- Close Center Div -->
        <div class="tRight">

           <div class="Icons">

           </div>
        </div>
    </div> <!-- Close Box Div -->

    <div class="Bottom">

        <div class="bLeft">    
              <?php
             /* echo('File-1-############################'.'</br>');*/
              LW (__FILE__, __LINE__, "~~~~~~~~~~~~~~~~~~~~~~~~~~~");
              $arrFiles = fnGetFilesOnly($sActiveOSdir); 

              for ($ii = 0; $ii < count($arrFiles); $ii++){
                  LW (__FILE__, __LINE__, "ii=$ii sub-folder=$arrFiles[$ii]");
                  echo "arrFiles[$ii]=" . fnFileName2Link($arrFiles[$ii]) . "</br>"; 
              }
              
              /*echo('Done-############################'.'</br>'); */
              echo ("</br>");
              ?>   
            <?php 
             include 'PHP/footer.php';
             ?> 
        </div> <!-- Close bLeft Div -->
        <div class="bRight">
        </div>
    </div> <!-- Close Bottom Div -->
    
  </body>
</html>

<?php # We have PHP Functions and Code below?>

<?php
$iLogLvlDebug   =0;
$iLogLvlInfo    =1;
$iLogLvlCritical=2;


function fnGetFoldersOnly($sStartFolder){
  # source https://www.sitepoint.com/community/t/how-to-list-folder-names/4548
  $arrTx = glob($sStartFolder . "/*", GLOB_ONLYDIR);
  $sUpperPath = getcwd() . "/";
  for ($iIndx=0; $iIndx < count($arrTx); $iIndx++){
    $arrTx[$iIndx] = str_replace($sUpperPath, "", $arrTx[$iIndx]);
  }
  return $arrTx;
}

function fnGetFilesOnly($sStartFolder){

  $arrFilesOnly = array();
  $arrAllEntities = glob($sStartFolder . "*");
  $sUpperPath = getcwd() . "/";

  foreach ($arrAllEntities as $onee) {
    if(is_file($onee)){
        LW (__FILE__, __LINE__, ". . . . . . . . . . . . ");
        LW (__FILE__, __LINE__, "sStartFolder=" . $sStartFolder);
        LW (__FILE__, __LINE__, "onee=" . $onee);
        LW (__FILE__, __LINE__, "sUpperPath=" . $sUpperPath);
        LW (__FILE__, __LINE__, "sSctiveDirRelative=" . $sSctiveDirRelative);

      array_push($arrFilesOnly, str_replace($sStartFolder, "", $onee));
    }
  }
  return $arrFilesOnly;
}


/*******************************************************************
This function converts file name ('folder-name1/folder-name2/folder-name3/file-name.ext')
into HTML link
href='folder-name1/folder-name2/folder-name3/file.ext'
text='file.ext'
*******************************************************************/
function fnFileName2Link($sFileName){
  $sResult = "<a href=# onclick=\"alert('@href')\">@Text</a>";
  $sFileName = str_replace("//", "/", $sFileName);
  LW (__FILE__, __LINE__, "Input sFileName=" .  $sFileName);

  $arrTemp = explode("/", $sFileName);
  $sTailFileName = $arrTemp[count($arrTemp) - 1];

  $sResult = str_replace("@href", $sTailFileName, $sResult);
  $sResult = str_replace("@Text", $sFileName, $sResult);
  LW (__FILE__, __LINE__, "sResult =" .  $sResult);

  return $sResult;
}

/*******************************************************************
This function converts folder name ('folder-name1/folder-name2/folder-name3/')
into HTML link
href='folder-name1/folder-name2/folder-name3/'
text='folder-name3'
*******************************************************************/
function fnFldrName2Link($sFolderName){
  $sResult = "<a href=index.php?fldr=@href>@Text</a>";
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

