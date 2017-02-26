<?php
$DBCnxn = mysql_connect('localhost', 'tinstructor', 'ABC') or die("Unable to connect to database");
$DB = mysql_select_db('tinstructor', $DBCnxn) or die("Unable to select database at this time...");
$SQLStmt = "select MAName, MASMS, MASEStatesVisited, MASEStateFavorite, MAOpinion, MAOtherStatesVisited
	    from MembershipApps
	    order by MAId desc ";
$MAResults = mysql_query($SQLStmt) or die("Can't do '$SQLStmt'...");
$MACount = mysql_num_rows($MAResults);
if ($MACount == 0) {
  $UI = "<h2>Nothing to report...</h2>\n";
} else {
  $UI = "<h2>Recent Applicants</h2>\n";
  if ($MACount == 1) {
    $UI .= "There is one applicant at " . date('H:i Y-m-d') . ':';
  } else {
    $UI .= "There are $MACount applicants at " .  date('H:i Y-m-d') . ':';
  }
  $UI .= "\n\n<br /><br />\n<div class=\"Row Centering\">\n<table class=\"Centered\">\n";
  $UI .= "   <tr class=\"Bottom1px\" valign=\"top\" ><th>Name</th>
      <th align=\"center\">SE States Visited</th>
      <th align=\"center\">Favorite SE State</th>
   </tr>\n";
  while ($AMA = mysql_fetch_assoc($MAResults)) {
    extract($AMA);
    $MASEStatesVisited = str_replace('|','<br />',$MASEStatesVisited);
    $UI .= "   <tr valign=\"top\" ><td class=\"AlphaData Bottom1px\" >$MAName</td>
      <td class=\"AlphaData Bottom1px\">$MASEStatesVisited</td>
      <td class=\"AlphaData Bottom1px\">$MASEStateFavorite</td>
   </tr>\n
   ";
  }
  $UI .= "</table>\n</div>\n\n<br /><br /><p>This is an incomplete listing, please show more...</p>";
}
$FormTemplate = file_get_contents('TemplateSeSDoCForm.html');
$FormTemplate = str_replace('[[[TheForm]]]', $UI, $FormTemplate);
echo $FormTemplate;
exit;
?>
