<?php
$Locked = file_get_contents('/home/tinstructor/AppLock');
if (trim($Locked) != 'UnLocked') {
  $ModTime = date ("l F d, Y  H:i", filemtime('/home/tinstructor/MemberAppLocked'));
  $FormTemplate = file_get_contents('TemplateSeSDoCForm.html');
  $UI = "<h2>Not Accepting Applications Now</h2>\n\n<p>Applications were locked $ModTime.</p>\n<p>They'll be unlocked when we feel like it.  Try later...</p>";
  $FormTemplate = str_replace('[[[TheForm]]]',$UI , $FormTemplate);
  echo $FormTemplate;
  exit;
}

  
function MakeTheForm($ValidationErrors) {
  if (isset($_POST['MAName'])) {
    extract($_POST);
  } else {
    //Set defaults
    $MAName = '';
    $MAEmail = '';
    $MASMS = '';
    $MASEStatesVisited = '';
    $MASEStateFavorite = '';
    $MAOpinion = '';
    $MAColor = '';
    $MAPass1 = '';
    $MAPass2 = '';
    $MALeastFavoriteWeather = '';
    //$MAStatesVisited = '';
    $MAOtherStatesVisited = '';
  }
  $RedSplat = " <span class=\"Flag\">* </span> ";
  $TheForm = "<p>Complete all sections of the form and
     click Submit Form when you're done... </p>
    <fieldset>
      <legend>Name &amp; Contact Data</legend>\n";
  if (isset($ValidationErrors['MAName'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  //$TheForm .= "\n  <ul>\n";
  $TheForm .= "      <p><label for=\"MAName\">$SplatSlug Name:</label>
          <input type=\"text\" name=\"MAName\" id=\"MAName\" value=\"$MAName\" placeholder=\"As you'd prefer to be addressed\" autofocus />
            </p><br /> \n";
  if (isset($ValidationErrors['MAEmail'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "       <p><label for=\"MAEmail\">$SplatSlug Email:</label>
          <input type=\"text\" name=\"MAEmail\" id=\"MAEmail\" value=\"$MAEmail\" placeholder=\"Fictitious is fine!\" />
            </p><br />  \n";
  if (isset($ValidationErrors['MASMS'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "      <p><label for=\"MASMS\">$SplatSlug MASMS#:</label>
          <input type=\"text\" name=\"MASMS\" id=\"MASMS\" value=\"$MASMS\" placeholder=\"10 digits like 123 123 1234\" />
          </p>  <br />   \n";
  if (isset($ValidationErrors['MAPass'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "      
          <p><label for=\"MAPass1\">$SplatSlug Password:</label>
          <input type=\"text\" name=\"MAPass1\" id=\"MAPass1\" value=\"$MAPass1\" placeholder=\"At least 8 characters...\" />
        </p><br /> \n";
  $TheForm .= "      
          <p><label for=\"MAPass2\">MAPassword, again:</label>
          <input type=\"text\" name=\"MAPass2\" id=\"MAPass2\" value=\"$MAPass2\" placeholder=\"Enter it again, please\" />
        </p><br /> \n";
  $TheForm .= "        
   </fieldset>\n";
  $TheForm .= "   <fieldset><legend>Southeastern States Visited</legend>\n";
  //Make check boxes for MASEStatesVisited[] and radio buttons for FavSEState from file StatesSE
  $StatesSEFile = fopen('/home/tinstructor/OptionsStatesSE','r');
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
         <input type=\"radio\" name=\"MASEStateFavorite\" id=\"Fav$AStateNoSpaces\" value=\"$AState\" $CheckedSlug />$AState
       </label>";         
  }
  $TheForm .= "    </fieldset>
    <fieldset><legend>Favorite Southeastern State</legend>
$FavStateRB
    </fieldset>";

  $TheForm .= "
    <fieldset>
      <legend>Opinions</legend>
      <div class=\"Row\">\n";
  if (isset($ValidationErrors['MAOpinion'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "   <div class=\"Col-12\">       
          <label for=\"MAOpinion\" class=\"WideLabel\">$SplatSlug What's your opinion of the Southeast?</label>      
            <textarea name=\"MAOpinion\" id=\"MAOpinion\" placeholder=\"Your opinion is very important to us as we consider your application...\">$MAOpinion</textarea>
        </div>
        </div>
      <div class=\"Row\"><br />";
  //Hard coded small select           
  if (isset($ValidationErrors['MALeastFavoriteWeather'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "
        <div class=\"Col-4\">
           <label for=\"MALeastFavoriteWeather\" class=\"WideLabel\">$SplatSlug Least Favorite Southeastern Weather?</label>
           <select name=\"MALeastFavoriteWeather\" id=\"MALeastFavoriteWeather\" size=\"5\">
 ";
  if ($MALeastFavoriteWeather == 'Heat') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "            <option value=\"Heat\" $SelectedSlug>Heat</option>\n";
  if ($MALeastFavoriteWeather == 'Humidity') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "             <option value=\"Humidity\" $SelectedSlug>Humidity</option>\n";
  if ($MALeastFavoriteWeather == 'Thunder') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "             <option value=\"Thunder\" $SelectedSlug>Thunder</option>\n";
  if ($MALeastFavoriteWeather == 'Rain') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "             <option value=\"Rain\" $SelectedSlug>Rain</option>\n";
  if ($MALeastFavoriteWeather == 'Snow') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "             <option value=\"Snow\" $SelectedSlug>Snow</option>";
  $TheForm .= "
           </select>
        </div>\n";
  //Another hard coded single select with background-color           
  if (isset($ValidationErrors['MAColor'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
  $TheForm .= "
        <div class=\"Col-4\">\n           <label for=\"MAColor\" class=\"WideLabel\">$SplatSlug Favorite Color of Southeastern Rainbows?</label>
             <select name=\"MAColor\" id=\"MAColor\" size=\"7\">\n";
  if (!isset($MAColor)) $MAColor = '';
  if ($MAColor == 'Red') { $SelectedSlug = "selected "; } else { $SelectedSlug = ''; }    	
  $TheForm .= "              <option value=\"Red\" style=\"background-color: red;\" $SelectedSlug>Red</option>\n";
  if ($MAColor == 'Orange') { $SelectedSlug = "selected "; } else { $SelectedSlug = ''; }    	
  $TheForm .= "              <option value=\"Orange\" style=\"background-color: orange;\" $SelectedSlug>Orange</option>\n";
  if ($MAColor == 'Yellow') { $SelectedSlug = "selected "; } else { $SelectedSlug = ''; }    	
  $TheForm .= "              <option value=\"Yellow\" style=\"background-color: yellow;\" $SelectedSlug>Yellow</option>\n";
  if ($MAColor == 'Green') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "              <option value=\"Green\" style=\"background-color: green;\"  $SelectedSlug>Green</option>\n";
  if ($MAColor == 'Blue') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "              <option value=\"Blue\" style=\"color:white; background-color: blue;\"  $SelectedSlug>Blue</option>\n";
  if ($MAColor == 'Indigo') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "              <option value=\"indigo\" style=\"color:white; background-color: indigo;\"  $SelectedSlug>Indigo</option>\n";
  if ($MAColor == 'Violet') { $SelectedSlug = "selected"; } else { $SelectedSlug = ''; }
  $TheForm .= "              <option value=\"violet\" style=\"background-color: violet;\"  $SelectedSlug>Violet</option>
            </select>
        </div>\n";

  //Multi-select using contents of text file with Options...
  $TheForm .= "
        <div class=\"Col-4\">
          <label for=\"MAOtherStates\" class=\"WideLabel\">Favorite Other States?<br />
          <span class=\"FinePrint\">(Ctrl-click for multiple)</span></label>
          <select name=\"MAOtherStatesVisited[]\" id=\"MAOtherStatesVisited\" size=\"12\" multiple>\n";
  $StatesNotSEFile = fopen('/home/tinstructor/OptionsStatesNotSE','r');
  while ($AState = fgets($StatesNotSEFile)) {
    $AState = trim($AState);
    //$AStateNoSpaces = str_replace(' ','',$AState);
    if (isset($MAOtherStatesVisited) and $MAOtherStatesVisited != '' and in_array($AState, $MAOtherStatesVisited)) { $SelectedSlug = 'selected'; } else { $SelectedSlug = ''; }
    $TheForm .= "             <option value=\"$AState\" $SelectedSlug >$AState</option>\n";
  }
  $TheForm .= "          </select>
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
  if (isset($MAId)) {
    $Verb = 'update';
    $Where = "where MAId=$MAId";
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
  $SQLStmt = "$Verb MembershipApps set MAName='$MAName',
			MASMS='$MASMS',
			MASEStatesVisited='$MASEStatesVisited',
			MASEStateFavorite='$MASEStateFavorite',
			MAOpinion='$MAOpinion',
			MAColor='$MAColor',
			MAPass='$MAPass1',
			MALeastFavoriteWeather='$MALeastFavoriteWeather',
			MAOtherStatesVisited='$MAOtherStatesVisited',
			MAUserAgent='$MAUserAgent',
			MAIPAddress='$MAIPAddress'
	      $Where";
  //echo $SQLStmt; exit;
  //$DB = mysql_connect
  $DBCnxn = mysql_connect('localhost', 'tinstructor', 'ABC') or die("Unable to connect to database");
  $DB = mysql_select_db('tinstructor', $DBCnxn) or die("Unable to select database at this time...");
  mysql_query($SQLStmt) or die("Couldn't update database with '$SQLStmt'...");
  if (isset($MAId)) {
    return $MAId;
  } else {
    $MAId = mysql_insert_id();
  }
  return $MAId;
}

//Set if initially $PoppedUp or not, then track it, used to control Close Window button
$PoppedUp = isset($_REQUEST['PoppedUp']);
if (!isset($_REQUEST['View'])) {
  $View = 'First';
} else {
  $View = $_REQUEST['View'];
}
if ($View == 'First') {
  //This is their first time at the page, explain stuff and make the form with empty $_POST...
  $UI = "  <h2>SeSDoC Membership Application</h2>
   <p>Click <a href=\"#\" onClick=\"PopupAbout()\">About the Form</a> to pop up notes about the form, JavaScript, and PHP.</p>
   <form method=\"POST\" name=\"SeSDoCForm\" action=\"SeSDoCForm.php\" onSubmit=\"return ValidateForm();\">";
  if ($PoppedUp) $UI .= "\n<input type=\"hidden\" name=\"PoppedUp\" value=\"Yep\">\n";
  $UI .= MakeTheForm('');
  $UI .= " 
     <p>Click <input type=\"submit\" name=\"View\" value=\"Submit Form\"> to submit your completed form to SeSDoC.  </p>
     <p>Uncheck the box to disable JS ValidateForm: <input type=\"checkbox\" name=\"RunJS\" id=\"RunJS\" checked=\"checked\"></p>
     <p>Click <a href=\"#\" onClick=\"PopupAbout()\">About the Form</a> to pop up notes about the form, JavaScript, and PHP.</p>
</form>";
} elseif ($View == 'Submit Form') {
  //They've filled in the form and clicked the Submit button, should be error free unless they've disabled JavaScript
  //on their browser or the content is submitted by a bot.  
  $ValidationErrors = '';
  extract($_POST);
  //Validate what came back.
  if (!isset($MAName) or $MAName == '') $ValidationErrors['MAName'] = "Name is missing or empty.  Please enter your name before clicking Submit.";
  if (!isset($MAEmail) or $MAEmail == '') { 
    $ValidationErrors['MAEmail'] = "The email address is empty.  Please enter your email address before clicking Submit.";
  } elseif (filter_var($MAEmail, FILTER_VALIDATE_EMAIL) === false) {
    $ValidationErrors['MAEmail'] = "The email  is not a valid format.";
  }
  if (!isset($MASMS) or strlen($MASMS) < 10) $ValidationErrors['MASMS'] = "Please enter the 10-digit number where you receive text messages."; 
  if (!isset($MAOpinion) or strlen($MAOpinion) < 50) $ValidationErrors['MAOpinion'] = "Please opine for at least 50 characters. Your opinion weighs heavily on our decision to accept you into the society."; 
  if (!isset($MALeastFavoriteWeather) or $MALeastFavoriteWeather == '') {
    $_POST['MALeastFavoriteWeather'] = '';
    $ValidationErrors['MALeastFavoriteWeather'] = "Please select your least favorite weather.";
  }
  if (!isset($MAColor) or $MAColor == '') $ValidationErrors['MAColor'] = "Please select your favorite, or least un-favorite, color.";
  if (!isset($MASEStateFavorite) or $MASEStateFavorite  == '') $ValidationErrors['MASEStateFavorite'] = "You must select your favorite Southeastern state to have your application considered.";
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
    //Mod here to call UpdateMemberApp which will return the MAId for the changed record
    $MAId = UpdateMemberApp();
    $UI .= "<p>Your form appears correct and has been saved in our database.  
    If any corrections are needed please make them and click Submit Form...</p>";
  }
  $UI .= "<form method=\"POST\" name=\"SeSDoCForm\" action=\"SeSDoCForm.php\" onSubmit=\"return ValidateForm();\">\n";
  $UI .= "<h2>SeSDoC Membership Application</h2>\n";
  $UI .= MakeTheForm($ValidationErrors);
  //Mod here to stick MAId into a hidden field if it is set -- it will be empty on the original submit, is used by
  //UpdateMemberApp to determine if it needs to insert or update a record
  if (isset($MAId)) $UI .= "\n<input type=\"hidden\" name=\"MAId\" value=\"$MAId\" />"; 
  if ($PoppedUp) $UI .= "\n<input type=\"hidden\" name=\"PoppedUp\" value=\"Yep\" >\n";
  $UI .= " <p>Run JS ValidateForm: <input type=\"checkbox\" name=\"RunJS\" id=\"RunJS\" checked=\"checked\">  Click <input type=\"submit\" name=\"View\" value=\"Submit Form\"> if changes have been made.  </p>
     <p>Click <a href=\"#\" onClick=\"PopupAbout()\">About the Form</a> to pop up notes about the form, JavaScript, and PHP.</p>
 </form>";
  if ($PoppedUp) {
    $UI .= "<p>Click <input type=button value='Close Window' onclick='window.close()'> to close this window when you're done making changes...</p>";
  } else {
    $UI .= "<p>Use your browser's 'back button' or Alt + Left Arrow to return to the previous page...</p>";
  } 
} else {
  $UI = "<p><font color=red>! </font>Somehow we don't know what your next view should be '$View' is not valid...</p>";
} 
$FormTemplate = file_get_contents('TemplateSeSDoCForm.html');
$FormTemplate = str_replace('[[[TheForm]]]', $UI, $FormTemplate);
echo $FormTemplate;
exit;
?>
