<?php 
defined('_JEXEC') or die('Restricted access');
//jimport('joomla.environment.uri' );

$document = &JFactory::getDocument();
$session = &JFactory::getSession();
$host = JURI::root();

$document->addStyleSheet('components/com_mojovids/css/style.css');
$document->addStyleSheet('components/com_mojovids/swfupload/default.css');
$document->addScript('components/com_mojovids/swfupload/swfupload.js');
$document->addScript('components/com_mojovids/swfupload/swfupload.queue.js');
$document->addScript('components/com_mojovids/swfupload/fileprogress.js');
$document->addScript('components/com_mojovids/swfupload/handlers.js');

$userfolder = $session->get('clientfolder');
?>
<script type="text/javascript">
		var swfu;
		
		window.onload = function() {
			var settings = {
				flash_url : "<?php echo $host . 'components/com_mojovids/swfupload/swfupload.swf';?>",
				upload_url: "<?php echo $host . 'components/com_mojovids/swfupload/upload.php'; ?>",
				post_params: {"PHPSESSID" : "<?php echo $session->getId(); ?>", "userfolder": "<?php echo $userfolder; ?>", "host": "<?php echo $host; ?>"},
				file_size_limit : "100 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 300,
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
				button_text_style: ".theFont {font-size: 16;}",
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


<div id="content">
	<h2>Step 3 - Photos</h2>
	
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
	  <fieldset>
	    <legend>Upload Photos</legend>
		   <p style="margin-top: 0px"><span class="req">*Please Note: you can add multiple file at once, by holding down the shift button while selecting multiple items to be uploaded.</span></p>
		   <p>&nbsp;</p>
			<div style="margin-left: 6px;">
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>
			
			<div id="divStatus" style="margin-left: 6px; margin-bottom: 5px">0 Files Uploaded</div>
			
			<div class="fieldset flash" id="fsUploadProgress">
			</div>
		    
          <button type="submit" value="Next" class="button green" id="submit" name="submit" onclick="location.href='index.php?option=com_mojovids&view=stepfour'; return false;"><strong>Next >></strong></button>
		</fieldset>
	</form>
</div>


