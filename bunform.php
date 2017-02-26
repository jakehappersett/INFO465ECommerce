<?php
//$Locked = file_get_contents('/home/tinstructor/AppLock');
//if (trim($Locked) == 'Locked') {
//  $ModTime = date ("l F d, Y  H:i", filemtime('/home/tinstructor/MemberAppLocked'));
//  $FormTemplate = file_get_contents('templatebunform.html');
//  $UI = "<h2>Not Accepting Applications Now</h2>\n\n<p>Applications were locked $ModTime.</p>\n<p>They'll be unlocked when we feel like it.  Try later...</p>";
//  $FormTemplate = str_replace('[[[TheForm]]]',$UI , $FormTemplate); //  echo $FormTemplate;
//  exit;
//}



function MakeTheForm($ValidationErrors) {
  if (isset($_POST['Firstname'])) {
    extract($_POST);
  } else {
    //Set defaults
    //$MAName = '';
    $Firstname = '';
    $Lastname = '';
    $Address = '';
    $Address2 = '';
    $City = '';
    $State = '';
    $Zip = '';
    $MAEmail = '';
    $MASEStatesVisited = '';
    $MASEStateFavorite = '';
    $MAOpinion = '';
    $MAColor = '';
    $MAPass1 = '';
    $MAPass2 = '';
    $Haytype = '';
    $MAOtherStatesVisited = '';
  }
  $RedSplat = " <span class=\"Flag\">* </span> ";
  $TheForm = "<p> Click Submit when you've got it filled out! </p>
   <fieldset>
      <legend>Name &amp; Contact Data</legend>\n";
  if (isset($ValidationErrors['Firstname'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "<p><label for=\"Firstname\">$SplatSlug First Name:</label>
          <input type=\"text\" name=\"Firstname\" id=\"Firstname\" value=\"$Firstname\" placeholder=\"First name\" autofocus />
            </p><br /> \n";
  if (isset($ValidationErrors['Lastname'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "      <p><label for=\"Lastname\">$SplatSlug Last Name:</label>
          <input type=\"text\" name=\"Lastname\" id=\"Lastname\" value=\"$Lastname\" placeholder=\"Lastname\" autofocus />
            </p><br /> \n";
  if (isset($ValidationErrors['Address'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "      <p><label for=\"Address\">$SplatSlug Address:</label>
          <input type=\"text\" name=\"Address\" id=\"Address\" value=\"$Firstname\" placeholder=\"Address\" autofocus />
            </p><br /> \n";
  if (isset($ValidationErrors['Address2'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "      <p><label for=\"Address2\">$SplatSlug Address Line 2:</label>
          <input type=\"text\" name=\"Address2\" id=\"Address2\" value=\"$Firstname\" placeholder=\"\" autofocus />
            </p><br /> \n";
  if (isset($ValidationErrors['City'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "      <p><label for=\"City\">$SplatSlug City:</label>
          <input type=\"text\" name=\"City\" id=\"City\" value=\"$Firstname\" placeholder=\"City\" autofocus />
            </p><br /> \n";
  if (isset($ValidationErrors['Zip'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "      <p><label for=\"Zip\">$SplatSlug Zip Code:</label>
          <input type=\"text\" name=\"Zip\" id=\"Zip\" value=\"$Firstname\" placeholder=\"Zip\" autofocus />
            </p><br /> \n";
  if (isset($ValidationErrors['MAEmail'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "       <p><label for=\"MAEmail\">$SplatSlug Email:</label>
          <input type=\"text\" name=\"MAEmail\" id=\"MAEmail\" value=\"$MAEmail\" placeholder=\"Fictitious is fine!\" />
            </p><br />  \n";
  if (isset($ValidationErrors['MAPass'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "
          <p><label for=\"MAPass1\">$SplatSlug Password:</label>
          <input type=\"text\" name=\"MAPass1\" id=\"MAPass1\" value=\"$MAPass1\" placeholder=\"At least 8 characters...\" />
        </p><br /> \n";
  $TheForm .= "
          <p><label for=\"MAPass2\"> Re-enter Password:</label>
          <input type=\"text\" name=\"MAPass2\" id=\"MAPass2\" value=\"$MAPass2\" placeholder=\"Enter it again, please\" />
        </p><br /> \n";
  $TheForm .= "
   </fieldset>\n";
  $TheForm .= "   <fieldset><legend>Type(s) of Rabbits you own</legend>\n";
  //Make check boxes for MASEStatesVisited[] and radio buttons for FavSEState from file StatesSE
  $StatesSEFile = fopen('/home/jhappersett/buntype','r');
  $FavStateRB = '';
  while ($AState = fgets($StatesSEFile)) {
    $AState = trim($AState);
    $AStateNoSpaces = str_replace(' ','',$AState);  //Used to make id with no spaces so extract() will work
    if (isset($MASEStatesVisited) and $MASEStatesVisited != '' and in_array($AState, $MASEStatesVisited)) {
      $CheckedSlug = 'checked';
    } else {
      $CheckedSlug = '';
    }
    $TheForm .= "       <label for=\"Visited$AStateNoSpaces\" class=\"WideLabel\">
         <input type=\"checkbox\" name=\"MASEStatesVisited[]\" id=\"Visited$AStateNoSpaces\" value=\"$AState\" $CheckedSlug />$AState
       </label>\n";
    if (isset($MASEStateFavorite) and $AState == $MASEStateFavorite) {
      $CheckedSlug = 'checked';
    } else {
      $CheckedSlug = '';
    }
    $FavStateRB .= "       <label for=\"Fav$AStateNoSpaces\" class=\"WideLabel\">
         <input type=\"radio\" name=\"MASEStateFavorite\" id=\"Fav$AStateNoSpaces\" value=\"$AState\" $CheckedSlug />$AState </label>";
  }
  $TheForm .= "    </fieldset> <fieldset><legend>Favorite Type of Rabbit</legend>
$FavStateRB
    </fieldset>";

  $TheForm .= "
    <fieldset>
      <legend>Rabbit Facts</legend>
      <div class=\"Row\">\n";
  if (isset($ValidationErrors['MAOpinion'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "   <div class=\"Col-12\">
          <label for=\"MAOpinion\" class=\"WideLabel\">$SplatSlug Describe the type of hutch you house your rabbit in. </label>
            <textarea name=\"MAOpinion\" id=\"MAOpinion\" >$MAOpinion</textarea>
        </div>
        </div>
      <div class=\"Row\"><br/>";
  //Hard coded small select
  if (isset($ValidationErrors['Haytype'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "
        <div class=\"Col-6\">
           <label for=\"Haytype\" style=\"clear:both;\">$SplatSlug What type of Hay do you feed your rabbit?</label>
           <select name=\"Haytype\" id=\"Haytype\" size=\"4\" >
 ";
  if ($Haytype== 'Timothy') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "            <option value=\"Timothy\" $SelectedSlug>Timothy</option>\n";
  if ($Haytype== 'Orchard') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "             <option value=\"Orchard\" $SelectedSlug>Orchard</option>\n";
  if ($Haytype== 'Thunder') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "             <option value=\"Oat\" $SelectedSlug>Oat</option>\n";
  if ($Haytype== 'Oat') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "             <option value=\"Alfalfa\" $SelectedSlug>Alfalfa</option>\n";
  $TheForm .= "
           </select>
        </div>\n";
  //Another hard coded single select with background-color

  //Multi-select using contents of text file with Options...
  $TheForm .= " <div class=\"Col-6\">
          <label for=\"MAOtherStates\" class=\"WideLabel\">Favorite Rabbit Habitat?<br />
          <span class=\"FinePrint\">(Ctrl-click for multiple)</span></label>
          <select name=\"MAOtherStatesVisited[]\" id=\"MAOtherStatesVisited\" size=\"5\" multiple>\n";
  $rabhab = fopen('/home/jhappersett/rabbithabitat','r');
  while ($AState = fgets($rabhab)) {
    $AState = trim($AState);
    //$AStateNoSpaces = str_replace(' ','',$AState);
    if (isset($MAOtherStatesVisited) and $MAOtherStatesVisited != '' and in_array($AState, $MAOtherStatesVisited)) { $SelectedSlug = 'selected'; } else { $SelectedSlug = ''; }
    $TheForm .= "<option value=\"$AState\" $SelectedSlug >$AState</option>\n";
  }
  $TheForm .= " </select>
        </div>\n";

  $TheForm .= "    </div>\n";
  $TheForm .= " </fieldset>\n";
  return $TheForm;
}

//Mod here to add UpdateMemberApp() to the sample script
function UpdateMemberApp() {
  $FormData = $_POST;
  //For this simple form we can sanitize all the FormData in a loop,
  //the second loop is to sanitize data from checkboxes and selects that return an array
  foreach ($FormData as $FieldName => $FieldValue) {
    if (is_array($FormData[$FieldName])) {
      foreach ($FormData[$FieldName] as $Elt => $EltValue) {
        $FormData[$FieldName][$Elt] = addslashes($EltValue);
      }
    } else {
      $FormData[$FieldName] = addslashes($FieldValue);
    }
  }
  extract($FormData);
  if (isset($Id)) {
    $Verb = 'update';
    $Where = "where Id=$Id";
  } else {
    $Verb = 'insert into';
    $Where = '';
  }
  if (is_array($MASEStatesVisited)) {
    $MASEStatesVisited = implode('|',$MASEStatesVisited);
  }
  if (is_array($MAOtherStatesVisited)) {
    $MAOtherStatesVisited = implode('|',$MAOtherStatesVisited);
  }
  $MAUserAgent = addslashes($_SERVER['HTTP_USER_AGENT']);
  $MAIPAddress = addslashes($_SERVER['REMOTE_ADDR']);
  $SQLStmt = "$Verb MembershipApps set FIRSTNAME ='$Firstname',
			LASTNAME='$Lastname',
			ADDRESS='$Address',
			ADDRESSTWO='$Address2',
			CITY='$City',
			ZIP='$Zip',
			MAEMAIL='$MAEmail',
			MAPass='$MAPass1',
			MASEStatesVisited='$MASEStatesVisited',
			MASEStateFavorite='$MASEStateFavorite',
			MAOpinion='$MAOpinion',
			Haytype='$Haytype',
			MAOtherStatesVisited='$MAOtherStatesVisited',
	      $Where";
  //echo $SQLStmt; exit;
  //$DB = mysql_connect
  $DBCnxn = mysql_connect('localhost', 'jhappersett', 'Jsett') or die("Unable to connect to database");
  $DB = mysql_select_db('jhappersett', $DBCnxn) or die("Unable to select database at this time...");
  mysql_query($SQLStmt) or die("Couldn't update database with '$SQLStmt'...");
  if (isset($Id)) {
    return $Id;
  } else {
    $Id = mysql_insert_id();
  }
  return $Id;
}
//
//Mainline
//Set if initially $PoppedUp or not, then track it, used to control Close Window button
$PoppedUp = isset($_REQUEST['PoppedUp']);
if (!isset($_REQUEST['View'])) {
  $View = 'First';
} else {
  $View = $_REQUEST['View'];
}
if ($View == 'First') {
  //This is their first time at the page, explain stuff and make the form with empty $_POST...
  $UI = "  <h2>Bunny Membership Application</h2>
   <form method=\"POST\" name=\"bunform\" action=\"bunform.php\" onSubmit=\"return ValidateForm();\">";
  if ($PoppedUp) $UI .= "\n<input type=\"hidden\" name=\"PoppedUp\" value=\"Yep\">\n";
  $UI .= MakeTheForm('');
  $UI .= "
     <p> <input type=\"submit\" name=\"View\" value=\"Submit Form\" style=\"position:50%;\">  </p>
     <p>Uncheck the box to disable JS ValidateForm: <input type=\"checkbox\" name=\"RunJS\" id=\"RunJS\" checked=\"checked\"></p>
     <p>Click <a href=\"#\" onClick=\"PopupAbout()\">About the Form</a> to pop up notes about the form, JavaScript, and PHP.</p>
</form>";
} elseif ($View == 'Submit Form') {
  //print_r($_POST,false); exit;
  //They've filled in the form and clicked the Submit button, should be error free unless they've disabled JavaScript
  //on their browser or the content is submitted by a bot.
  $ValidationErrors = '';
  extract($_POST);
  //Validate what came back.
  if (!isset($Firstname) or $Firstname== '') $ValidationErrors['Firstname'] = "First name is missing or empty.  Please enter your first name before clicking Submit.";
  if (!isset($Address) or $Address== '') $ValidationErrors['Lastname'] = "Name is missing or empty.  Please enter your last name before clicking Submit.";
  if (!isset($City) or $City== '') $ValidationErrors['City'] = "City is missing or empty.  Please enter your city before clicking Submit.";
  if (!isset($Zip) or $Zip== '') $ValidationErrors['Zip'] = "Zip is missing or empty.  Please enter your zip before clicking Submit.";
  if (!isset($MAEmail) or $MAEmail == '') {
    $ValidationErrors['MAEmail'] = "The email address is empty.  Please enter your email address before clicking Submit.";
  } elseif (filter_var($MAEmail, FILTER_VALIDATE_EMAIL) === false) {
    $ValidationErrors['MAEmail'] = "The email  is not a valid format.";
  }
  if (!isset($MAOpinion) or strlen($MAOpinion) < 50) $ValidationErrors['MAOpinion'] = "Please write least 50 characters.";
  if (!isset($Haytype) or $Haytype== '') {
    $_POST['Haytype'] = '';
    $ValidationErrors['Haytype'] = "Please select your favorite hay!";
  }
  if (!isset($MASEStateFavorite) or $MASEStateFavorite  == '') $ValidationErrors['MASEStateFavorite'] = "Please select your favorite habitat!";
  if ((!isset($MAPass1) or $MAPass1  == '') or (!isset($MAPass2) or $MAPass2  == '')) {
    $ValidationErrors['MAPass'] = "Enter your password twice, please.";
  } elseif ($MAPass1 != $MAPass2) {
    $ValidationErrors['MAPass'] = "Passwords do not match.";
  }
  //$CountSEStates
  $UI = '';
  if (is_array($ValidationErrors)) {
    $ErrorCount = count($ValidationErrors);
    if ($ErrorCount == 1) {
      $UI .= "<p>Please correct this error, then click Submit Form:</p>\n";
    } else {
      $UI .= "<p>Please correct $ErrorCount errors, then click Submit Form:</p>\n";
    }
  $UI .= "<ul>\n";
    foreach ($ValidationErrors as $AnErrorMessage) {
  $UI .= "   <li>$AnErrorMessage</li>\n ";
    }
  $UI .= "</ul>\n";
  } else {
  $MAID= UpdateMemberApp();
  $UI .= "<p> It worked (hopefully) </p>";
  }
  $UI .= "<form method=\"POST\" name=\"bunform\" action=\"bunform.php\" onSubmit=\"return ValidateForm();\">\n";
  $UI .= "<h2>Bunny Membership Application</h2>\n";
  $UI .= MakeTheForm($ValidationErrors);
  if (isset($MAId)) $UI .= "\n<input type=\"hidden\" name=\"MAId\" value=\"$MAId\" />";
  if ($PoppedUp) $UI .= "\n<input type=\"hidden\" name=\"PoppedUp\" value=\"Yep\" >\n";
  $UI .= " <p>Run JS ValidateForm: <input type=\"checkbox\" name=\"RunJS\" id=\"RunJS\" checked=\"checked\">  Click <input type=\"submit\" name=\"View\" value=\"Submit Form\"> if changes have been made.  </p>
 </form>";
  if ($PoppedUp) {
    $UI .= "<p>Click <input type=button value='Close Window' onclick='window.close()'> to close this window when you're done making changes...</p>";
  } else {
  $UI .= "<p>Use your browser's 'back button' or Alt + Left Arrow to return to the previous page...</p>";
  }
} else {
  $UI = "<p><font color=red>! </font>Somehow we don't know what your next view should be '$View' is not valid...</p>";
}
$FormTemplate = file_get_contents('templatebunform.html');
$FormTemplate = str_replace('[[[form]]]', $UI, $FormTemplate);
echo $FormTemplate;
exit;
?>
