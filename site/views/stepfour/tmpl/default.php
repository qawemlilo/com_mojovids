<?php
defined('_JEXEC') or die('Restricted access');


if($this->msg == "default") {
$session = &JFactory::getSession();
$document = &JFactory::getDocument();
$host = JURI::root();

$document->addStyleSheet('components/com_mojovids/css/style.css');
$document->addStyleSheet('components/com_mojovids/swfupload/default.css');
$document->addStyleSheet('components/com_mojovids/js/tooltips/tipTip.css');
$document->addScript('components/com_mojovids/swfupload/swfupload.js');
$document->addScript('components/com_mojovids/swfupload/swfupload.queue.js');
$document->addScript('components/com_mojovids/swfupload/fileprogress.js');
$document->addScript('components/com_mojovids/swfupload/handlers.js');
$document->addScript('components/com_mojovids/js/jquery-1.6.2.min.js');
$document->addScript('components/com_mojovids/js/tooltips/jquery.tipTip.js');

$userfolder = $session->get('clientfolder');

$document = &JFactory::getDocument();
$scrit = 'jQuery.noConflict();' . "\n";
$scrit .= '(function($) {
$(document).ready(function(){
    $(".someClass").tipTip({maxWidth: "250px", delay: 200, defaultPosition: "top", edgeOffset: 10}); 

    $("#musictwo").click(function(){
	    ($("#music").attr("disabled")) ? $("#music").removeAttr("disabled") : $("#music").attr("disabled", "disabled");
    });	

    $("#form1").submit(function(){
	    if(!$("#musictwo").attr("checked") && !$("#music").val()) {
		    alert("Please select music option");
			return false;
		}
    });	
});
})(jQuery);';

$document->addScriptDeclaration($scrit);
?>
<script type="text/javascript">
		var swfu;
		
		window.onload = function() 
		{
			var settings = {
				flash_url : "<?php echo $host . 'components/com_mojovids/swfupload/swfupload.swf';?>",
				upload_url: "<?php echo $host . 'components/com_mojovids/swfupload/upload.php'; ?>",
				post_params: {"PHPSESSID" : "<?php echo $session->getId(); ?>", "userfolder":"<?php echo $userfolder; ?>", "host": "<?php echo $host; ?>"},
				file_size_limit : "10 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 5,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "<?php echo $host . 'components/com_mojovids/images/test.png'; ?>",
				button_width: "69",
				button_left_margin: "5",
				button_height: "29",
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

			swfu = new SWFUpload(settings);
		};
</script>
	<h2>Step 3 - Videos Clips</h2>
	<form id="form1" action="index.php?option=com_mojovids&view=stepfour" method="post" enctype="multipart/form-data">
	 <fieldset>
	  <legend>Upload Video Clips</legend>
	       <p style="margin-top: 0px"><span class="req">*Please Note: you can add multiple file at once, by holding down the shift button while selecting multiple items to be uploaded.</span></p>
		   
		   <p>&nbsp;</p>
			<div style="margin-left: 6px;">
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>
			
			<div id="divStatus" style="margin-left: 6px; margin-bottom: 5px">0 Files Uploaded</div>
			
			<div class="fieldset flash" id="fsUploadProgress">

			</div>    
			
	  <p style="margin: 5px; margin-top: 10px">
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
        <button type="submit" value="submit" class="button green" id="submit" name="submit"><strong>Paypal Payment >></strong></button>
	    </fieldset>
	</form>
</div>
<?php
}
elseif($this->msg == "success")
{
    echo '<h2 style="color:green">Success! (Demo: user will hereby be redirected to paypal)</h2>';          
}
elseif($this->msg == "fail")
{
    echo '<h2 style="color:red">Error occured: (Demo failure)</h2>';    
}
else {
    header("Location: index.php");
}
?>
