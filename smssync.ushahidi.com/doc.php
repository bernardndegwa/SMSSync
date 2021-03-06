<!DOCTYPE html> 
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SMSSync by Ushahidi</title>
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<link href="../libs/js/google-code-prettify/prettify.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="../js/fancybox/query.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="../js/screenshots.js"></script>
<script src="libs/js/google-code-prettify/prettify.js"></script>
</head>
<body style="padding-top:40px;" onload="prettyPrint()">
<div class="topbar" data-scrollspy="scrollspy" >
    <div class="fill">
        <div class="container">
            <div id="logo">
                <h3>
                    <a href="#">SMSSync</a>
                </h3>
            </div>
            <ul class="nav">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="../releases/">Releases</a></li>
                <li><a href="../download/">Download</a></li>
                <li><a href="../doc/">Documentation</a></li>
                <li><a href="../features/">Features</a></li>
                <li><a href="../screenshots/">Screenshots</a></li>
                <li><a href="http://forums.ushahidi.com/forum/ushahidi-apps">Support</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="hero-unit">
        <h2>The free and open source SMS gateway for Android</h2>
    </div>
</div>
<div class="container">
<div class="page-header">
<h1>Documentation <small>This documents how to integrate SMSSync into your project.</small></h1>
</div>

<div class="row">
<div class="span8 columns">
<h2>Instructions</h2>
<ul>
<li>
SMSSync uses the <a href="http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol">HTTP</a> and <a href="http://en.wikipedia.org/wiki/HTTPS">HTTPS</a> protocols for communication.
                    <p>To start the SMSSync Gateway, you'll need to specify a callback URL. This URL is where all incoming SMS will be transmitted to. 
                    Remember to enter the full URL including the filename. A typical example will be <code>http://somedomain.com/index.php</code></p></li>
<li>
For  security you can specify a secret key at the callback URL. If the secret key doesn't match, the callback URL will ignore the transmission.
</li>
<li>
Additionally, you can specify keywords with which to filter incoming SMS. Only matching SMS will be sent to the SMSSync Gateway URL.
</li>
<li>
SMSSync uses the following variables to transmit the incoming SMS via the POST method:
<ul>
<li><strong>from</strong> -- the number that sent the SMS</li>
<li><strong>message</strong> -- the SMS sent</strong></li>
<li><strong>message_id</strong> -- the unique ID of the SMS</li>
<li><strong>sent_to</strong> -- the phone number the SMS was sent to</li>

<li><strong>secret</strong> -- the secret key set on the app</li>
<li><strong>sent_timestamp</strong> -- the timestamp the SMS was sent. In the format, mm-dd-yy-hh:mm  Eg. 11-27-11-07:11</strong></li>
</ul>
</li>

<p></ul>
<p>
In order for SMSSync to account for perfect transmission, the callback URL needs to give back a formatted JSON string such as its shown below to indicate if it received the message or not.
<br /><br />
<strong>Succeeded</strong> 
<pre class="prettyprint linenums">
{
    payload: {
        success: "true"
    }
}</pre>
<br /><br />
<strong>Failed</strong>
<br /><br />
<pre class="prettyprint linenums">{
    payload: {
        success: "false"
    }
}</pre>
</p>

&nbsp;

<p><strong>Response from server</strong>
<p>
SMSSync allows auto response to be configured on the app itself or to be retrieved from the server. When the app makes an HTTP Post request to sync the  incoming SMS to the configured URL, it can send a JSON string that has  messages in it as opposed to sending a success or failed JSON string as stated above. The app then sends the messages as SMS to users phone.
<p>
This makes it possible to have an instant response via SMS when an HTTP Post request is made. To leverage this feature, a JSON formatted string like the one below needs to be returned by the configured URL after the app makes the HTTP Post request. 
</p>
<p>
Also, make sure <strong><em>Get Reply From Server</em></strong> is checked on SMSSync otherwise it will fail to send the SMS.<p>
<strong>Response JSON data from the callback URL</strong>
<pre class="prettyprint linenums">{
    "payload": {
        "success": "true",
        "task": "send",
        "messages": [
            {
                "to": "+000-000-0000",
                "message": "the message goes here" 
            },
            {
                "to": "+000-000-0000",
                "message": "the message goes here" 
            },
            {
                "to": "+000-000-0000",
                "message": "the message goes here" 
            }
        ]
    }
}</pre>
</p>
&nbsp;</p>
<p><strong>Task</strong>
<p>
SMSSync supports execution of task sent from the configured callback URL. At the moment, it supports sending of messages sent from the callback URL as SMS. This feature is targeted towards developers. If you are a developer and you want SMSSync to send an SMS, send a JSON formatted string as shown below to SMSSync with the variable task=send. When SMSSync does an HTTP GET request with a sample URL like this one, <code>http://callback_url/smssync?task=send</code>, it should bring back a JSON string below.</p>
<br /><br />      <br />
<p><strong>Note:</strong> The secret key has to match the secret key configured with SMSSync, otherwise, SMSSync will not execute the task. To play it safe, add the country code to the phone number. Eg. +254700709142</p></p>
<p><strong>Response JSON data from the callback URL</strong></p></p>
<pre class="prettyprint linenums">{
    "payload": {
        "task": "send",
        "secret": "secret_key",
        "messages": [
            {
                "to": "+000-000-0000",
                "message": "the message goes here" 
            },
            {
                "to": "+000-000-0000",
                "message": "the message goes here" 
            },
            {
                "to": "+000-000-0000",
                "message": "the message goes here" 
            }
        ]
    }
}</pre>

<p></div>
<div class="span8 columns">
<h2>A sample web service</h2>
<p>This is a sample PHP script to demonstrate how to write a webservice to successfully communicate with SMSSync.</p>
<pre class="prettyprint linenums">
/*<em>
 *  get the phone number that sent the SMS.
 </em>/
if (isset($_POST['from']))
{
    $from = $_POST['from'];
}</p>
<p>/*<em>
 * get the SMS aka message sent
 </em>/ 
if (isset($_POST['message']))
{
    $message = $_POST['message'];
}</p>
<p>//set success to true
$success = "true";</p>
<p>/*<em>
 * in case a secret has been set at SMSSync side, 
 * get it for match making
 </em>/ 
if (isset($_POST['secret']))
{
    $secret = $_POST['secret'];
}</p>
<p>/*<em>
 * get the timestamp of the SMS
 </em>/
if(isset($_POST['sent_timestamp']))
{
    $sent_timestamp = $_POST['sent_timestamp'];
}</p>
<p>if (isset($_POST['sent_to'])) 
{
    $sent_to = $_POST['sent_to'];
}</p>
<p>if (isset($_POST['message_id']))
{
    $message_id = $_POST['message_id'];
}</p>
<p>/<em><em>
 * now we have retrieved the data sent over by SMSSync 
 * via HTTP. next thing to do is to do something with 
 * the data. Either echo it or write it to a file or even 
 * store it in a database. This is entirely up to you. 
 * After, return a JSON string back to SMSSync to know 
 * if the web service received the message successfully. 
 </em>
 * In this demo, we are just going to echo the data 
 * received.
 </em>
 */
if ((strlen($from) &gt; 0) AND (strlen($message) &gt; 0) AND 
    (strlen($sent_timestamp) &gt; 0 ) AND (strlen($sent_to) &gt; 0) 
    AND (strlen($message_id) &gt; 0))
{
    //in case secret is set on both SMSSync and the web 
    //service. Let's make sure they match.
    if ( ! ( $secret == '123456'))
    {
        $success = "false";
    }
    // now let's write the info sent by SMSSync
    //to a file called test.txt
    $string = "From: ".$from."n";
    $string .= "Message: ".$message."n";
    $string .= "Timestamp: ".$sent_timestamp."n";
    $string .= "Messages Id:" .$message_id."n";
    $string .= "Sent to: ".$sent_to."nnn";
    $myFile = "test.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    @fwrite($fh, $string);
    @fclose($fh);</p>
<p>} 
else 
{
    $success = "false";  <br />
}</p>
<p>/*<em>
 * now send a JSON formatted string to SMSSync to 
 * acknowledge that the web service received the message
 </em>/
echo json_encode(array("payload"=&gt;array(
    "success"=&gt;$success)));</p>
<p>/<em><em>
 * Comment the code below out if you want to send reply an instant 
 * reply as SMS to the user.
 </em>
 * This feature requires the "Get reply from server" check on SMSSync.
 </em>/</p>
<p>/*<em>
 * $msg = "Your message has been received";
 * <br />
 * $reply[0] = array("to" =&gt; $from, "message" =&gt; $msg);
 * <br />
 * echo json_encode(array("payload"=&gt;array("success"=&gt;$success,"task"=&gt;"send","messages"=&gt;array_values($reply))));
 </em>/
</pre>
<p>
For a complete web service application, look at Ushahidi's <a href="https://github.com/ushahidi/Ushahidi_Web/tree/master/plugins/smssync">SMSSync plugin</a>.It utilizes most of SMSSync features.
</p>
<p>
There is also SMSSync webservice for Django that implements most of the features of SMSSync. You can download it from <a href="https://github.com/cwanjau/SMSsync-Python-Django-webservice">github.com</a>. Thanks to <a href="https://github.com/cwanjau">Caine Wanjau</a>
</p>
</div>
</div></p></div>
<div class="container">
<footer class="footer">
    <div class="container">
        <div class="pull-right">
          powered by <a href="http://www.ushahidi.com">Ushahidi</a>
        </div> 
        <p>Generated: 02-02-2012 Copyright &copy; 2010 - 2012 <a href="http://www.ushahidi.com">Ushahidi.com</a></p>

<p></div>
</footer>
</div>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-12063676-22']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
</body>
</html></p>