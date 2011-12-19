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
		    alert("You have to accept the Terms Of Service");
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
 <h2>Step 1 - Your Details</h2>
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
		<textarea tabindex="4" readonly="readonly" rows="10" cols="40" id="terms">1.Accepting The Use Of Mojovids.com Terms of Service
1.1 Your  access  to  and  use  of  Mojovids.com is  subject exclusively to these Terms and Conditions. You will not use the Website for any purpose that is unlawful or prohibited by these Terms and Conditions. By using  the  Website  you  are  fully  accepting  the  terms,  conditions  and disclaimers contained in this notice. If you do not accept these Terms and Conditions you must immediately stop using the Website.
1.2 Mojovids.com will never ask for Credit Card details and request that you do not enter it on any of the forms on Mojovids.com.
1.3 The contents of Mojovids.com website do not constitute advice and should not be relied upon in making or refraining from making, any decision.

2. Mojovids.com reserves the right to:
2.1 change or remove (temporarily or permanently) the Website or any part of it without notice and you confirm that Mojovids.com shall not be liable to you for any such change or removal.
2.2 change these Terms and Conditions at any time, and your continued use of the Website following any changes shall be deemed to be your acceptance of such change.

3. Links to Third Party Websites
Mojovids.com Website may include links to third party websites that are controlled and maintained by others. Any link to other websites is not an endorsement of such websites and you acknowledge and agree that we are not responsible for the content or availability of any such sites.

4. Copyright
4.1 All  copyright,  trade  marks  and  all  other  intellectual  property  rights  in  the Website and its content (including without limitation the Website design, text, graphics and all software and source codes connected with the Website) are owned by or   licensed to Mojovids.com or otherwise used by Mojovids.com as permitted by law.
4.2 In accessing the Website you agree that you will access the content solely for your personal, non-commercial use. None of the content may be downloaded, copied, reproduced, transmitted, stored, sold or distributed without the prior written consent of the copyright holder. This excludes the downloading, copying and/or printing of pages of the Website for personal, non-commercial home use only.

5. Disclaimers and Limitation of Liability
5.1 The Website is provided on an AS IS and AS AVAILABLE basis without any representation or endorsement made and without warranty of any kind whether express or implied, including but not limited to the implied warranties of satisfactory quality, fitness for a particular purpose, non-infringement, compatibility, security and accuracy.
5.2 To the extent permitted by law, Mojovids.com will not be liable for any indirect or consequential loss or damage whatever (including without limitation loss of business, opportunity, data, profits) arising out of or in connection with the use of the Website.
5.3 Mojovids.com makes no warranty that the functionality of the Website will be uninterrupted or error free, that defects will be corrected or that the Website or the server that makes it available are free of viruses or anything else which may be harmful or destructive.
5.4 Nothing in these Terms and Conditions shall be construed so as to exclude or limit the liability of Mojovids.com for death or personal injury as a result of the negligence of Mojovids.com or that of its employees or agents.
You agree to indemnify and hold Mojovids.com and its employees and agents harmless from and against all liabilities, legal fees, damages, losses, costs and other expenses in relation to any claims or actions brought against Mojovids.com arising out of any breach by you of these Terms and Conditions or other liabilities arising out of your use of this Website.
If any of these Terms and Conditions should be determined to be invalid, illegal or unenforceable for any reason by any court of competent jurisdiction then such Term or Condition shall be severed and the remaining Terms and Conditions shall survive and remain in full force and effect and continue to be binding and enforceable.
These Terms and Conditions shall be governed by and construed in accordance with the law of USA and you hereby submit to the exclusive jurisdiction of the USA courts.
For any further information please email: support@mojovids.com</textarea>
	  </p>	  
	  <p  style="margin-top:-10px;">
	    <label for="conditions">&nbsp;</label>
		<input type="checkbox" id="conditions" value="1" name="conditions" /> Accept Terms Of Service <span class="req">*</span>
	  </p>
	  
	  <p>
	    <label for="conditions">&nbsp;</label>
	    <button type="submit" value="submit" class="button green" id="submit" name="submit"><strong>Submit</strong></button>
	  </p>
	</fieldset>
 </form>
</div>
