 <?php
//$Locked = file_get_contents('/home/tinstructor/AppLock');
//if (trim($Locked) != 'UnLocked') {
//  $ModTime = date ("l F d, Y  H:i", filemtime('/home/tinstructor/MemberAppLocked'));
//  $FormTemplate = file_get_contents('/home/jake/templatebunform.html');
//  $UI = "<h2>Not Accepting Applications Now</h2>
//
//<p>Applications were locked $ModTime.</p>
//<p>They'll be unlocked when we feel like it.  Try later...</p>";
//  $FormTemplate = str_replace('[[[form]]]',$UI , $FormTemplate);
//  echo $FormTemplate;
//  exit;
//}

//
//create the form in the function each part of the function is strings 
//put all the strings together
//return the strings 
//
//create a new variable that contains your set of strings 
//call strreplace on those strings with the formtemplate file
//echo the form template file 

//function MakeTheForm($ValidationErrors) {
//  if (isset($_POST['MAName'])) {
//    extract($_POST);
//  } else {
//	  $firstname = '';
//	  $lastname = '';
//	  $email = '';
//  }
//  $red = "<span class=\"Flagi\"> * <\span>";
//  $form = "<p> complete this form </p>";
//  if (isset($ValidationErrors['MAName'])) { $SplatSlug = $RedSplat; } else { $SplatSlug = ''; }
//  $form .= "<p><label for="firstname">$SplatSlug Name:</label> <input type="text" name="firstname" id="firstname" value="$firstname" placeholder="first name" autofocus /> </p><br />";


 
function formmake() {
//declare variables
if (isset($_POST['fname'])) {
	extract($_POST);
}
else {
	$fname = '';
	$lname = '';
}
	
	$red = " <span class=\"Flag\">* </span> ";


//begin form 
	$form = "<p> Please fill out the sections of this form </p> 
		<fieldset> <legend> Name and Contact </legend> \n";

	$form .= "      <p><label for=\"name\"> $sred Name:</label>
          <input type=\"text\" name=\"MAName\" id=\"MAName\" value=\"$fname\" placeholder=\"First name\" autofocus /></p><br /> \n";	

	$form .= "      <p><label for=\"name\"> $sred Name:</label>
          <input type=\"text\" name=\"lname\" id=\"MAName\" value=\"$lname\" placeholder=\"First name\" autofocus /></p><br /> \n";	
}




$form = formmake();

$formtemplate = file_get_contents('templatebunform.html');
$formtemplate = str_replace('[[[form]]]', $form, $formtemplate);
echo $formtemplate;
exit;
?>
