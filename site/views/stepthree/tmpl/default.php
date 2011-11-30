<?php 
defined('_JEXEC') or die('Restricted access');
//jimport('joomla.environment.uri' );

$document = &JFactory::getDocument();
$session = &JFactory::getSession();
$host = JURI::root();

$document->addStyleSheet('components/com_mojovids/css/style.css');
$document->addStyleSheet('components/com_mojovids/swfupload/default.css');
$document->addScript('components/com_mojovids/js/jquery-1.6.2.min.js');
$document->addScript('components/com_mojovids/swfupload/swfupload.js');
$document->addScript('components/com_mojovids/swfupload/swfupload.queue.js');
$document->addScript('components/com_mojovids/swfupload/handlers.js');

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

$document->addStyleDeclaration($style);  
$userfolder = $session->get('clientfolder');
?>
<script type="text/javascript">
		var swfu, limit, mycookie = getCookie("img_count");
		
		window.onload = function() {
			var settings = {
				flash_url : "<?php echo $host . 'components/com_mojovids/swfupload/swfupload.swf';?>",
				upload_url: "<?php echo $host . 'components/com_mojovids/swfupload/upload.php'; ?>",
				post_params: {
				    "PHPSESSID" : "<?php echo $session->getId(); ?>", 
					"userfolder": "<?php echo $userfolder; ?>", 
					"host": "<?php echo $host; ?>"
				},
				file_size_limit : "1 MB",  //size limit per file
				file_types : "*.png;*.jpg;*jpeg;*.gif", // acceptable file extensions
				file_types_description : "Image files only", //discription message
				file_upload_limit : 5, //<?php echo $limit; ?> number of files to be uploaded
				file_queue_limit : 0, //number of files uploaded per time
				custom_settings : {
					progressTarget : "fsUploadProgress",
					mainTarget : "mainTarget",
					statusTarget: "sTarget",
					cancelButtonId : "btnCancel",
					totalTarget: "tTarget",
					loadedTarget: "loaded",
					cookie: "img_count" 
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
			
			if (mycookie !== null) {
			    if (mycookie >= settings.file_upload_limit) {
				  alert("You have reached your photo upload limit.\n Proceed.");
				  location.href = "index.php?option=com_mojovids&view=stepfour";
				}
				else {
			        limit = settings.file_upload_limit - mycookie;
					settings.file_upload_limit = limit;
				}
			}

			swfu = new SWFUpload(settings);
		};
</script>


<div id="content">
	<h2>Step 3 - Photos</h2>
	
	<form id="form1" action="index.php?option=com_mojovids&view=stepthree" method="post" enctype="multipart/form-data">
	  <fieldset>
	    <legend>Upload Photos</legend>
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
			
		  <input type="hidden" value="1" name="import">  
          <button type="submit" value="Next" class="button green" id="submit"><strong>Next >></strong></button>
		</fieldset>
	</form>
</div>


