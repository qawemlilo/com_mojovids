<?php
defined('_JEXEC') or die('Restricted access');

$session = &JFactory::getSession();
$document = &JFactory::getDocument();


$document->addStyleSheet('components/com_mojovids/css/style.css');
$document->addScript('components/com_mojovids/js/cookies.js');

if($this->msg == "default") 
{
$host = JURI::root();

$document->addStyleSheet('components/com_mojovids/swfupload/default.css');
$document->addStyleSheet('components/com_mojovids/js/tooltips/tipTip.css');
$document->addScript('components/com_mojovids/js/jquery-1.6.2.min.js');
$document->addScript('components/com_mojovids/swfupload/swfupload.js');
$document->addScript('components/com_mojovids/swfupload/swfupload.queue.js');
$document->addScript('components/com_mojovids/swfupload/handlers.js');
$document->addScript('components/com_mojovids/js/tooltips/jquery.tipTip.js');

$userfolder = $session->get('clientfolder');

//Some custom styles
$style = '	
  .swfupload {
     position: absolute;
	 -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
	 filter: alpha(opacity=0);
	 -khtml-opacity: 0.0
	 -moz-opacity:0.0;;
     opacity: 0.0;
	 z-index: 1;
  }';
  
//Add some custom styles
$document->addStyleDeclaration($style); 


//Some custom script
$scrit = 'jQuery.noConflict();' . "\n";
$scrit .= '(function($) {
$(document).ready(function(){
    $(".someClass").tipTip({maxWidth: "250px", delay: 200, defaultPosition: "top", edgeOffset: 10, keepAlive: true}); 

    $("#musictwo").click(function(){
	    ($("#music").attr("disabled")) ? $("#music").removeAttr("disabled") : $("#music").attr("disabled", "disabled");
    });	

    $("#form1").submit(function(){
	    if(!$("#title").val()) {
		    alert("Please enter the title for your Slideshow");
			return false;
		}
	    if(!$("#musictwo").attr("checked") && !$("#music").val()) {
		    alert("Please select music option");
			return false;
		}
    });	
});
})(jQuery);';
//Add some custom script
$document->addScriptDeclaration($scrit);
?>
<script type="text/javascript">
		var swfu, limit, mycookie = getCookie("video_count");
		
		window.onload = function() 
		{
			var settings = {
				flash_url : "<?php echo $host . 'components/com_mojovids/swfupload/swfupload.swf';?>",
				upload_url: "<?php echo $host . 'components/com_mojovids/swfupload/upload.php'; ?>",
				post_params: {"PHPSESSID" : "<?php echo $session->getId(); ?>", "userfolder":"<?php echo $userfolder; ?>", "host": "<?php echo $host; ?>"},
				file_size_limit : "20 MB",
				file_types : "*.mp4;*.avi;*.mov;*.qt;*.3gp;*.m4v;*.mpg;*.mpeg;*.mp4v;*.h264;*.wmv,;*.mpg4;*.movie;*.m4u;*.flv;*.dv;*.mkv;*.mjpeg;*.ogv",
				file_types_description : "Video Clips",
				file_upload_limit : 3,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					mainTarget : "mainTarget",
					statusTarget: "sTarget",
					cancelButtonId : "btnCancel",
					totalTarget: "tTarget",
					loadedTarget: "loaded",
					cookie: "video_count"
				},
				debug: false,

				// Button settings
				button_image_url: "<?php echo $host . 'components/com_mojovids/images/test.png'; ?>",
			    button_width: 110,
				button_left_margin: 0,
				button_height: 36,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">Upload</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 5,
				button_text_top_padding: 3,
				button_cursor : SWFUpload.CURSOR.HAND,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			if (mycookie !== null) {
			    if (mycookie >= settings.file_upload_limit) {
				  alert("You have reached your upload limit.\n Please proceed to payment.");
				  return false;
				}
				else {
			        limit = settings.file_upload_limit - mycookie;
					settings.file_upload_limit = limit;
				}
			}
			
			swfu = new SWFUpload(settings);
		};
</script>
	<h2>Step 3 - Videos Clips</h2>
	<form id="form1" action="index.php?option=com_mojovids&view=stepfour" method="post" enctype="multipart/form-data">
	 <fieldset>
	  <legend>Upload Video Clips</legend>
		   <p style="margin-top: 0px; padding-left: 0px;"><strong>Please Note:</strong> You can add multiple files at once, by holding down the shift button while selecting multiple items to be uploaded.</p>
			<div style="margin-left: -2px; margin-top: 10px;">
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnUpload" type="button" value="Upload" class="button green" style="font-weight:bold;  border-color:green" />
				<input id="btnCancel" type="button" class="button orange" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="border-color:orange; font-weight:bold; margin-left: 2px;" />
			</div>
			
			<div id="divStatus" style="margin-left: 2px; margin-top: 10px; color: #000"><span id="loaded">0</span> of <span id="tTarget">0</span> Files Uploaded</div>
			
			<div class="fieldset flash" id="fsUploadProgress">
			    <div id="mainTarget" style="background: green; width: 0%; height:20px;">
				</div>
			</div>
			
			<div id="sTarget" style="width: 375px; height:20px; margin-bottom: 15px; padding-left: 2px; overflow: hidden; color: #7DD006">
            &nbsp;
			</div>
			
	  <p style="margin: 5px 5px 5px 0px;">
	    <label for="title">Slideshow Title:<span class="req">*</span></label>
		<input type="text" id="title" class="txt" size="22" value="" name="title">
	  </p>				
	  <p style="margin: 5px 5px 5px 0px;">
	    <label for="music">Music category:<span class="req">*</span></label>
		<select name="music" id="music">
		  <option value="">Choose Category</option>
		  <option value="Ambient">Ambient</option>
		  <option value="Classical">Classical</option>
		  <option value="Country">Country</option>
		  <option value="Electronic">Electronic</option>
		  <option value="Funk">Funk</option>
		  <option value="Hip Hop">Hip Hop</option>
		  <option value="Instrumental">Instrumental</option>
		  <option value="Jazz Blues">Jazz/Blues</option>
		  <option value="Pop">Pop</option>
		  <option value="Rock">Rock</option>		  
		</select>
		
		or <input type="checkbox" id="musictwo" value="Decide for me" name="musictwo" />Leave it to us <a href="#/moreinfo" class="someClass" title="We will use our experience to find the right song for your Mojovids slideshow"> more info</a>
	  </p>	
	
       <div style="height:2px; width: 100%; clear: left;"> &nbsp; </div>	
        <input type="hidden" value="1" name="import"> 	   
        <button type="submit" value="submit" class="button green" id="submit" name="submit"><strong>Submit</strong></button>
	    </fieldset>
	</form>
</div>
<?php
}
elseif($this->msg == "success" && $session->get("clientpackage"))
{
$scrit = '
deleteCookie("img_count");
deleteCookie("video_count");
';

$document->addScriptDeclaration($scrit);
?>
<h2>Go to Paypal&reg; for payment</h2>
<p>
This page will redirect you to Paypal<sup>&reg;</sup> for secure payment.
</p>
<div id="content">
      <table id="prices">
		  <thead>
            <tr>
 			  <th class="first" style="width: 35%; background-color: #76AE29; padding: 5px">Package</th>
              <th class="slick" style="width: 40%; background-color: #76AE29; padding: 5px">Description</th>
              <th class="sexy" style="width: 25%; background-color: #76AE29; padding: 5px">Total</th>
		    </tr>
		  </thead>
		  
		  <tbody>
            <tr>
 			  <td class="optitem" style="#fff; padding: 2px; background-color: #fff; text-align:center"><?php echo ucfirst($session->get("clientpackage")); ?></td>
              <td class="slick" style="#fff; padding: 2px"><?php echo ucfirst($session->get("clientpackage")); ?> Package.</td>
              <td class="sexy" style="padding: 2px">$<?php if($session->get("clientpackage") == "economy") echo '1'; if($session->get("clientpackage") == "premium") echo '99';?></td>
		    </tr>
		  </tbody>
	
		  <tfoot>
            <tr>			  
 			  <td> <img src="components/com_mojovids/images/btn_paynow_LG.gif" /> </td>
              <td class="chooseslick"> &nbsp; </td>
              <td class="choosesexy">
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				  <input type="hidden" name="cmd" value="_xclick">
				  <input type="hidden" name="business" value="burnsie1402@gmail.com">
				  <input type="hidden" name="notify_url" value="http://www.scottwebdesigns.co.za/mojo/index.php?option=com_mojovids&view=thankyou">
				  <input type="hidden" name="currency_code" value="USD">
				  <input type="hidden" name="item_name" value="<?php echo ucfirst($session->get("clientpackage")); ?> Package">
				  <input type="hidden" name="amount" value="<?php if($session->get("clientpackage") == "economy") echo '1'; if($session->get("clientpackage") == "premium") echo '99';?>">
				  <input type="image" name="submit"src="components/com_mojovids/images/btn_paynowCC_LG.gif" />
				</form>         			  
			  </td>			  
		    </tr>
		  </tfoot>
      </table>
</div>
<?php	
$session->destroy();
}
elseif($this->msg == "fail")
{
$scrit = '
deleteCookie("img_count");
deleteCookie("video_count");
';

$document->addScriptDeclaration($scrit);
$session->destroy();
?>
    <h2 style="color:red">Error occured!</h2>
    <p style="color:red">An unexpected error occured, <a href="index.php?option=com_mojovids&view=stepone">Click here to try again</a>.</p>    
<?php
}
else {
    header("Location: index.php?option=com_mojovids&view=stepone");
}
?>
