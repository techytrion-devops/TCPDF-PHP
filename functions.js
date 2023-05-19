/**
 * Functionality specific to TCPDF-PHP.
 *
 * Techy-Trion
 */
"use strict";

/*------------------------------------------------------------------------------*/
/* A print button for print PDF through TCPDF
/*------------------------------------------------------------------------------*/

 jQuery(document).ready(function() {
	jQuery('#print_TCPDF').click(function(){
		var post_ID = jQuery('#post_id').val();
		var logo = jQuery('#logo').attr('src');
		var iframe = document.createElement('iframe');
		iframe.style.display = 'none';
		iframe.src = 'path/to/file/generate_pdf.php?post_ID='+post_ID+'&logo='+logo;
		document.body.appendChild(iframe);
		iframe.onload = function() {
			iframe.contentWindow.print();
		};
	});
});

 


