<?php 
defined('_JEXEC') or die('Restricted access');
$session =& JFactory::getSession();
$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_mojovids/css/style.css');  
$document->addStyleSheet('components/com_mojovids/js/tooltips/tipTip.css');
$document->addScript('components/com_mojovids/js/jquery-1.6.2.min.js');
$document->addScript('components/com_mojovids/js/tooltips/jquery.tipTip.js');

$scrit = 'jQuery.noConflict();' . "\n";
$scrit .= '(function($) {
$(document).ready(function(){
   $(".someClass").tipTip({maxWidth: "250px", delay: 200, defaultPosition: "top", edgeOffset: 10});    
});
})(jQuery);';

$document->addScriptDeclaration($scrit);
?>
<!-- Our form -->

<div id="content">
	<h2>Compare Pricing</h2>
	<form name="package" method="POST" action="index.php?option=com_mojovids&view=stepone">
	  <input type="hidden" name="import" value="1" />
      <table id="prices">
		  <thead>
            <tr>
 			  <th class="first">Pricing options</th>
              <th class="slick">
			   <img src="components/com_mojovids/images/economy-button.jpg" /> <br />  <br />
                $<?php echo $session->get('Economy'); ?>			   
              </th>
              <th class="sexy">
			   <img src="components/com_mojovids/images/premium-button.jpg" /> <br /> <br />  
               $<?php echo $session->get('Premium'); ?>				   
              </th>
		    </tr>
		  </thead>
		  
		  <tbody>
            <tr>
 			  <td class="optitem">HD quality</td>
              <td class="slick"> <img src="components/com_mojovids/images/yes_32.png" class="yes" />   </td>
              <td class="sexy"> <img src="components/com_mojovids/images/yes_32.png" class="yes" />  </td>
		    </tr>
			
            <tr>
 			  <td class="optitem">Video Length </td>
              <td class="slick">  Up to 12 minutes </td>
              <td class="sexy"> Up to 12 minutes </td>
		    </tr>
			
            <tr>
 			  <td class="optitem">Up to 250 photos and 5 video clips <a href="#/moreinfo" class="someClass" title="Maximum photos- 250, maximum video clip length-30secs. Please bear in mind that a video clip of 10secs is the same as 3 photos,  20 secs is the same as 6 photos and 30 secs is the same as 10 photos. Eg:- 290 photos and 1 30sec video clip will give you a total of 250 photos. You may only have up to 5 video clips">more info</a></td>
              <td class="slick"> <img src="components/com_mojovids/images/yes_32.png" class="yes" /> </td>
              <td class="sexy"> <img src="components/com_mojovids/images/yes_32.png" class="yes" /> </td>
		    </tr>
			
            <tr>
 			  <td class="optitem">Text Inserts</td>
              <td class="slick"> <img src="components/com_mojovids/images/yes_32.png" class="yes" /> </td>
              <td class="sexy"> <img src="components/com_mojovids/images/yes_32.png" class="yes" /> </td>
		    </tr>
			
            <tr>
 			  <td class="optitem">Email delivery <a href="#/moreinfo" class="someClass" title="Your slideshow will be delivered in MP4 format via email. You will find a download link in the email to download your slideshow. You can use your slideshow to share online, upload to youtube, watch on your PC, burn to DVD or anything else you can think up!">more info</a></td>
              <td class="slick"> <img src="components/com_mojovids/images/yes_32.png" class="yes" />  </td>
              <td class="sexy"> <img src="components/com_mojovids/images/yes_32.png" class="yes" /> </td>
		    </tr>
			
            <tr>
 			  <td class="optitem">File Format</td>
              <td class="slick"> MP4 </td>
              <td class="sexy"> MP4 </td>
		    </tr>
			
            <tr>
 			  <td class="optitem">ISO File</td>
              <td class="slick"> <img src="components/com_mojovids/images/no_32.png" class="yes" /> </td>
              <td class="sexy"> <img src="components/com_mojovids/images/yes_32.png" class="yes" /> <span class="details"><br />(ISO files are 100% DVD ready and simply need to be burnt to disc)</span> </td>
		    </tr>
		  </tbody>
	
		  <tfoot>
            <tr>			  
 			  <td style="text-align: left"> <span class="req">*</span> <a href="#/moreinfo" class="someClass" style="color: #000; font-size: 12px; font-weight: bold" title="Both packages are delivered in MP4 format and both are of equal quality. Our premium package simply comes with the additional ISO file that is ready to be burnt straight to DVD disc. This takes away the hassle of trying to convert your MP4 file to a DVD ready format">File format clarification</a> </td>
              <td class="chooseslick"> <input type="submit" value="PROCEED" name="economy" class="button green"/> </td>
              <td class="choosesexy"> <input type="submit" value="PROCEED" name="premium" class="button green"/></td>			  
		    </tr>
		  </tfoot>
      </table>
	</form>
</div>

