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
	    <label for="terms">&nbsp;</label>
		<textarea tabindex="4" readonly="readonly" rows="10" cols="40" id="terms">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</textarea>
	  </p>	  
	  <p  style="margin-top:-10px;">
	    <label for="conditions">&nbsp;</label>
		<input type="checkbox" id="conditions" value="1" name="conditions" /> Accept Terms and Conditions <span class="req">*</span>
	  </p>
	  
	  <p>
	    <label for="conditions">&nbsp;</label>
	    <button type="submit" value="submit" class="button green" id="submit" name="submit"><strong>Submit</strong></button>
	  </p>
	</fieldset>
 </form>
</div>
