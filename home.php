<!-- Copyright (c) Microsoft. All rights reserved. Licensed under the MIT license. See full license at the bottom of this file. -->
<?php
// create an array to set page-level variables
$page = array();
$page['title'] = 'Home';

// include the page header
include('common/header.php');
require('o365/Office365Service.php');
error_reporting(0);

// Check if there is user info in the session.
$loggedIn = !is_null($_SESSION['userName']);

// If the user is not logged in, the buttons will not say "Add to Calendar", but will
// instead say "Connect to my Calendar".
if (!$loggedIn) {
  $redirectUri = "http://localhost/php-calendar/o365/authorize.php";
  $loginUrl = Office365Service::getLoginUrl($redirectUri);
}


$events = "";
if(isset(($_SESSION['accessToken']))){
    $events = Office365Service::getEventsForDate($_SESSION['accessToken']);
    $events = $events['value'];
    
}
?>

<h1>Welcome to php-calendar!</h1>
<div>Here are the upcoming shows for our Shakespearean Festival.</div>
<div><span id="table-title">Upcoming Shows</span></div>
<table class="show-list">
  <tr>
    <th class="button"></th>
    <th>Performance</th>
    <th>Location</th>
    <th>Voucher Required?</th>
    <th>Date</th>
    <th>Start</th>
    <th>End</th>
  </tr>

<?php

$altRow = false;

foreach($events as $key => $event) {

  $start_date=date($event['Start']);
  $end_date = date($event['End']);
?>
  <tr<?php if ($altRow) echo ' class="alt"'; $altRow = !$altRow ?>>
    <td><?php echo $event['Subject'] ?></td>
    <td><?php echo $event['BodyPreview'] ?></td>
    <td><?php echo $event['WebLink'] ?></td>
    <td><?php echo $start_date;?></td>
    <td><?php echo $end_date; ?></td>
  </tr>

<?php
}
?>

</table>

<?php
// include the page footer
include('common/footer.php');
?>

<!--
 MIT License: 
 
 Permission is hereby granted, free of charge, to any person obtaining 
 a copy of this software and associated documentation files (the 
 ""Software""), to deal in the Software without restriction, including 
 without limitation the rights to use, copy, modify, merge, publish, 
 distribute, sublicense, and/or sell copies of the Software, and to 
 permit persons to whom the Software is furnished to do so, subject to 
 the following conditions: 
 
 The above copyright notice and this permission notice shall be 
 included in all copies or substantial portions of the Software. 
 
 THE SOFTWARE IS PROVIDED ""AS IS"", WITHOUT WARRANTY OF ANY KIND, 
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF 
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION 
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION 
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->