Subscription form.\n
The following person would like to subscribe to <?=$packages[$_POST['package']][2]; ?> with options to ".$_POST['pdfoption']."

-------------------------------
Email:       ".$_POST['Email'].
Name:        ".stripslashes($_POST['First_Name'])." ".stripslashes($_POST['Last_Name']).
Position:    ".stripslashes($_POST['Position']).
Company:     ".stripslashes($_POST['Company']).
Phone:       ".$_POST['Phone']
Address:     ".stripslashes($_POST['Address1']).
             ".stripslashes($_POST['Address2']).
City:        ".stripslashes($_POST['City'])."
Province:    ".stripslashes($_POST['Province']).
Postal Code: ".$_POST['PostalCode']."
Country:     ".stripslashes($_POST['Country'])
How did you\nhear about us: ".$_POST['Hear']
-------------------------------
Promised first edition: ".date("F jS", $next_delivery)." 