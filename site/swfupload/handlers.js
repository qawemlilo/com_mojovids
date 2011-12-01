/* 
**********************
   Q's notes
   Event Handlers
********************** 
*/

jQuery.noConflict();
  
var FILEObject = {
    totalImages: 0,
	
	loadedFiles: 0,
	
	queuedFiles: 0,
	
	limit: 0,
	
    printStatus: function (target, status) {
        document.getElementById(target).innerHTML = status;
    },
	
    setStats: function (num) {
        if (this.totalImages)
		    this.totalImages += num;
		else
		    this.totalImages = num;
    }
};



function fileQueued(file) {
	try {
		FILEObject.queuedFiles = FILEObject.queuedFiles += 1;
	} catch (ex) {
		this.debug(ex);
	}

}


function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("You have attempted to queue too many files.\n Upload limit exceeded.");
			return;
		}

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			FILEObject.printStatus(this.customSettings.statusTarget, "File is too big.");
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			FILEObject.printStatus(this.customSettings.statusTarget, "Cannot upload Zero Byte files.");
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			FILEObject.printStatus(this.customSettings.statusTarget, "Invalid File Type.");
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		default:
			if (file !== null) {
				FILEObject.printStatus(this.customSettings.statusTarget, "Unhandled Error");
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
            FILEObject.setStats(numFilesQueued);
			FILEObject.printStatus(this.customSettings.totalTarget, FILEObject.totalImages);
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
		FILEObject.printStatus(this.customSettings.statusTarget, file.name + ' loading...');
	}
	catch (ex) {}
	
	return true;
}


function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
	    var stats = this.getStats(), currentfileprogress, allfilesprogress, totalprogress; 
		
		currentfileprogress = Math.floor(((1 / FILEObject.totalImages) * (bytesLoaded / bytesTotal)) * 100);    
		allfilesprogress = Math.ceil((stats.successful_uploads / FILEObject.totalImages) * 100);
			
		totalprogress = allfilesprogress + currentfileprogress;
		
		FILEObject.printStatus(this.customSettings.statusTarget, totalprogress + "% " + file.name + " loading...");
	} catch (ex) {
		this.debug(ex);
	}
}


function uploadSuccess(file, serverData) {
	try {
	    var stats = this.getStats(), progress;
		
		progress = Math.ceil((stats.successful_uploads / FILEObject.totalImages) * 100);
		
	    FILEObject.loadedFiles = FILEObject.loadedFiles += 1;
		
		FILEObject.printStatus(this.customSettings.loadedTarget, stats.successful_uploads);
		FILEObject.printStatus(this.customSettings.statusTarget, "");
		jQuery("#" + this.customSettings.mainTarget).animate({width: progress + "%"});
	} catch (ex) {
		this.debug(ex);
	}
}


function uploadError(file, errorCode, message) {
	try {
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			FILEObject.printStatus(this.customSettings.statusTarget, "Upload Error: " + message);
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			FILEObject.printStatus(this.customSettings.statusTarget, "Upload Failed.");
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			FILEObject.printStatus(this.customSettings.statusTarget, "Server (IO) Error");
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			FILEObject.printStatus(this.customSettings.statusTarget, "Security Error");
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			FILEObject.printStatus(this.customSettings.statusTarget, "Upload limit exceeded.");
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			FILEObject.printStatus(this.customSettings.statusTarget, "Failed Validation.  Upload skipped.");
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			FILEObject.printStatus(this.customSettings.statusTarget, "Cancelled");
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			FILEObject.printStatus(this.customSettings.statusTarget, "Stopped");
			break;
		default:
			FILEObject.printStatus(this.customSettings.statusTarget, "Unhandled Error: " + errorCode);
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}


function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		document.getElementById(this.customSettings.cancelButtonId).disabled = true;		
	}
}


// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
    var uploads, mycookie;
	
	if (this.customSettings.cookie === "img_count") 
	    imgcookie = getCookie("img_count");
	else 
	    mycookie = getCookie("video_count");
	
	if (mycookie) 
	    uploads = FILEObject.loadedFiles + mycookie;
	
    jQuery("#" + this.customSettings.mainTarget).animate({width: "100%"});
	setCookie(this.customSettings.cookie, uploads);
	document.getElementById(this.customSettings.statusTarget).innerHTML = " File upload complete.";
}
