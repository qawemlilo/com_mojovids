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
    $(".someClass").tipTip({maxWidth: "250px", delay: 200, defaultPosition: "top", edgeOffset: 10}); 

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

			swfu = new SWFUpload(settings);
		};
</script>
	<h2>Step 3 - Videos Clips</h2>
	<form id="form1" action="index.php?option=com_mojovids&view=stepfour" method="post" enctype="multipart/form-data">
	 <fieldset>
	  <legend>Upload Video Clips</legend>
	       <p style="margin-top: 0px; padding-left: 6px;"><strong>Please Note:</strong> You can add multiple file at once, by holding down the shift button while selecting multiple items to be uploaded.</p>

			<div style="margin-left: 2px; margin-top: 10px;">
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnUpload" type="button" value="Upload" class="button green" style="font-weight:bold; border-color:green" />
				<input id="btnCancel" type="button" class="button orange" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="border-color:orange; font-weight:bold; margin-left: 2px;" />
			</div>
			
			<div id="divStatus" style="margin-left: 10px; margin-top: 5px; margin-bottom: 5px">0 Files Uploaded</div>
			
			<div class="fieldset flash" id="fsUploadProgress">

			</div> 
			
	  <p style="margin: 5px; margin-top: 10px">
	    <label for="title">Slideshow Title:<span class="req">*</span></label>
		<input type="text" id="title" class="txt" size="22" value="" name="title">
	  </p>				
	  <p style="margin: 5px;">
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
