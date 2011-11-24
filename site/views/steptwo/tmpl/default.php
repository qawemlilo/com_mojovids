<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$session =& JFactory::getSession();

$document->addStyleSheet('components/com_mojovids/css/style.css');
$document->addScript('components/com_mojovids/js/jquery-1.6.2.min.js');

$scrit = 'jQuery.noConflict();' . "\n";
$scrit .= '(function($) {
$(document).ready(function(){
    $("#contactForm").submit(function(){
	    if(!$("#conditions").attr("checked")) {
		    alert("You have to accept the Terms and Conditions to proceed");
			return false;
		}
	});

    $(".txt").focus(function(){
	    $(this).removeClass("error");
    });	
});
})(jQuery);';

$document->addScriptDeclaration($scrit);

if( $session->has('errors'))
{
     $errors = $session->get('errors');
}
else 
{
    $errors = array();
}
?>
<!-- Our form -->

<div id="content">
 <h2>Step 2 - Your Details</h2>
 <form id="contactForm" name="details" method="POST" action="index.php?option=com_mojovids&view=steptwo<?php if(isset($_GET['p'])) echo '&p=' . $_GET['p']; ?>">
    <fieldset>
	  <legend>Your Details</legend>

	  <p>
	    <input type="hidden" value="1" name="import">
	    <label for="name"> Name <span class="req">*</span></label>
		<input type="text" class="txt<?php if(isset($errors['name'])) echo ' error'; ?>" size="22" value="<?php if($session->has('clientname')) echo $session->get('clientname'); ?>" name="name">
	  </p>
	  
	  <p>
	    <label for="surname">Surname <span class="req">*</span></label>
		<input type="text" class="txt<?php if(isset($errors['surname'])) echo ' error'; ?>" size="22" value="<?php if($session->has('clientsurname')) echo $session->get('clientsurname'); ?>" name="surname">
	  </p>
	  
	  <p>
	    <label for="email">Email <span class="req">*</span></label>
		<input type="text" class="txt<?php if(isset($errors['email'])) echo ' error'; ?>" size="22" value="<?php if($session->has('clientemail')) echo $session->get('clientemail'); ?>" name="email" />
	  </p>
	  
	  <p>
	    <label for="conditions">&nbsp;</label>
		<input type="checkbox" id="conditions" value="1" name="conditions" /> Terms and Conditions <span class="req">*</span>
	  </p>
	  
	  <p>
	    <label for="conditions">&nbsp;</label>
	    <button type="submit" value="submit" class="button green" id="submit" name="submit"><strong>Submit</strong></button>
	  </p>
	</fieldset>
 </form>
</div>
