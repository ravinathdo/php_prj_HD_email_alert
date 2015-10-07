
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->



<?php

$targetDay = 14;
$colorCode = '#ff5722';

// put your code here
//echo getDelayBugs();

/**
 * Creating email body
 * @return string
 */
function getDelayBugs() {
    $conn = getDBConnection();
    $sql = " SELECT id,summary,DATEDIFF(CURDATE(),FROM_UNIXTIME(date_submitted)) AS datediffer,FROM_UNIXTIME(date_submitted) as date_submitted,mantis_bug_status.description
FROM mantis_bug_table INNER JOIN mantis_bug_status
 WHERE DATEDIFF(CURDATE(),FROM_UNIXTIME(date_submitted)) >= ".$GLOBALS['targetDay']." 
 AND mantis_bug_table.status = mantis_bug_status.status
 AND mantis_bug_table.status != 90 
 ORDER BY datediffer DESC ";


    /*
     * 
      <tr style="font-size: x-small">
      <td  valign="top">305 xx</td>
      <td  valign="top">WRONG RATE</td>
      <td  valign="top">288</td>
      <td  valign="top">2014-12-23 10:53:14</td>
      <td  valign="top">Feedback</td>
      </tr>
     * 
     */






    $msg = '<table> <tr style="font-size: x-small;font-weight:bold;background-color:#CCC">
              <td  valign="top">ID</td>
              <td  valign="top">Status</td>
              <td  valign="top">Submited </td>
              <td  valign="top">Difference</td>
              <td  valign="top">Summary</td>
              </tr>';

    $result = mysqli_query($conn, $sql);
    $bugCount = mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $msg .= '<tr style="font-size: x-small">
              <td  valign="top"><a href="http://192.168.100.244/UBHD/view.php?id=' . $row['id'] . '"/> ' . $row['id'] . '</td>
              <td  valign="top">' . $row['description'] . '</td>
              <td  valign="top">' . $row['date_submitted'] . '</td>
              <td  valign="top">' . $row['datediffer'] . '</td>
              <td  valign="top">' . $row['summary'] . '</td>
              </tr>';
        }
    }
    $msg .= '</table>';

    return $msg;
}

function getDBConnection() {
    include './config_hd.php';
    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die("unable to connect database");
    return $conn;
}

/**
 * Subject for email header
 * @return type
 */
function getFireDate() {

    date_default_timezone_set('Asia/Colombo');
    $date = date('m/d/Y h:i:s a', time());

    return  $date;
}

function getBugCount() {
    $conn = getDBConnection();
    $sql = " SELECT id
FROM mantis_bug_table INNER JOIN mantis_bug_status
 WHERE DATEDIFF(CURDATE(),FROM_UNIXTIME(date_submitted)) >= ".$GLOBALS['targetDay']." 
 AND mantis_bug_table.status = mantis_bug_status.status
 AND mantis_bug_table.status != 90 
 ";

    $result = mysqli_query($conn, $sql);
    $bugCount = mysqli_num_rows($result);

    return '('.$bugCount.') <span style="font-size:x-small">'.getFireDate().'</span>';
}
?>









<?php
$headers = 'From: helpdesk@unionb.com' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$subject = 'UBHD '.$GLOBALS['targetDay'].' Day Alert ' .getFireDate();
$message = '    <!DOCTYPE html>
                <html>
                <head>
                <meta charset="UTF-8">
                


                </head>
                <body>
                    <div style="padding: 1px 16px;color: #fff !important;background-color: '.$GLOBALS['colorCode'].' !important;"> 
                    <p>After '.$GLOBALS['targetDay'].' Day Alert ' . getBugCount() . ' </p>
                    </div>
                ' . getDelayBugs() . '
                <hr>
                <span style="font-size:x-small">
                
<img style="width:100px;height:10px" src="data:image/png;base64,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"/>




                 &nbsp;IT-Development 2015</span>
                </body>
                </html>
            ';

//echo $subject;
//echo "<br>";
//echo $message;
mail("ravinathp@unionb.com", $subject, $message, $headers) or die("unable to send email");
?>
