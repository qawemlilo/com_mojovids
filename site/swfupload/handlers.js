/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Q's notes
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
   
var fUload = {
    num_imgs: 0,
	loaded: 0,
	queued: 0,
	broken: 0,	
	limit: 0,
	
    setStatus: function (target, status) {
        document.getElementById(target).innerHTML = status;
    },
	
    setStats: function (num) {
        if (this.num_imgs)
		    this.num_imgs += num;
		else
		    this.num_imgs = num;
    }
};

function fileQueued(file) {
	try {
		fUload.queued = fUload.queued += 1;
	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
			return;
		}

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			fUload.setStatus(this.customSettings.statusTarget, "File is too big.");
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			fUload.setStatus(this.customSettings.statusTarget, "Cannot upload Zero Byte files.");
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			fUload.setStatus(this.customSettings.statusTarget, "Invalid File Type.");
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		default:
			if (file !== null) {
				fUload.setStatus(this.customSettings.statusTarget, "Unhandled Error");
			}
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesSelected > 0) {
		    document.getElementById(this.customSettings.progressTarget).style.backgroundColor = "orange";
            fUload.setStats(numFilesQueued);
			fUload.setStatus(this.customSettings.totalTarget, fUload.num_imgs);
			document.getElementById(this.customSettings.cancelButtonId).disabled = false;
		}
		
		/* I want auto start the upload and I can do that here */
		this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		return true to indicate that the upload should start.
		It's important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		fUload.setStatus(this.customSettings.statusTarget, file.name + ' loading...');
	}
	catch (ex) {}
	
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
	    jQuery.noConflict();
	    var stats = this.getStats(), percent = Math.floor(((1 / fUload.num_imgs) * (bytesLoaded / bytesTotal)) * 100),
		    oldpercent = Math.ceil((stats.successful_uploads / fUload.num_imgs) * 100), c;
			
		var c = oldpercent + percent ;
		jQuery("#" + this.customSettings.mainTarget).animate({width: c + "%"});
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
	    jQuery.noConflict();
	    var stats = this.getStats(),
		    percent = Math.ceil((stats.successful_uploads / fUload.num_imgs) * 100);
		
	    fUload.loaded = fUload.loaded += 1;
		
		fUload.setStatus(this.customSettings.loadedTarget, stats.successful_uploads);
		fUload.setStatus(this.customSettings.statusTarget, "");
		jQuery("#" + this.customSettings.mainTarget).animate({width: percent + "%"});
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	try {
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			fUload.setStatus(this.customSettings.statusTarget, "Upload Error: " + message);
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			fUload.setStatus(this.customSettings.statusTarget, "Upload Failed.");
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			fUload.setStatus(this.customSettings.statusTarget, "Server (IO) Error");
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			fUload.setStatus(this.customSettings.statusTarget, "Security Error");
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			fUload.setStatus(this.customSettings.statusTarget, "Upload limit exceeded.");
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			fUload.setStatus(this.customSettings.statusTarget, "Failed Validation.  Upload skipped.");
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			fUload.setStatus(this.customSettings.statusTarget, "Cancelled");
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			fUload.setStatus(this.customSettings.statusTarget, "Stopped");
			break;
		default:
			fUload.setStatus(this.customSettings.statusTarget, "Unhandled Error: " + errorCode);
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
	    jQuery.noConflict();
		
		document.getElementById(this.customSettings.cancelButtonId).disabled = true;
		jQuery("#" + this.customSettings.mainTarget).animate({width: "100%"});
	}
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
	document.getElementById(this.customSettings.statusTarget).innerHTML = " File upload complete.";
}
