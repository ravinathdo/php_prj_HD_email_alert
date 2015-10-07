<?php

/*
  Activate SMTP mail on XAMPP
 */
//https://www.youtube.com/watch?v=TO7MfDcM-Ho
//mail("ravinathp@unionb.com","UBHD Alert","HELPDESK Email Alert","From: helpdesk@unionb.com") or die ("unable to send email");
// From: parameter is mandatory




$headers = 'From: helpdesk@unionb.com' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$message = '
<html>
<head>
  
<style type="text/css">
            body{
                font-size: x-small;
            }
            
        </style>

</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
 
 
<h3>query result</h3>' . getBodyContent() . '</body>
</html>
';







mail("ravinathp@unionb.com", "UBHD Alert", $message, $headers) or die("unable to send email");

function getBodyContent() {
    $r = '<table>
    <tr style="font-size: x-small">
        <td  valign="top">305 xx</td>
        <td  valign="top">WRONG RATE</td>
        <td  valign="top">288</td>
        <td  valign="top">2014-12-23 10:53:14</td>
        <td  valign="top">Feedback</td>
    </tr>
</table>';
    return $r;
}

?>