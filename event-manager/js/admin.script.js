/*
 * Event Manager WordPress Plugin Jquery For Shortcode Generator Page
*/  
 
jQuery(document).ready( function ($){
	/* Assigning change event handler for select box */
	/* it will run when selectbox options are changed */

	$('a#build_shortcode').on('click', function(e){
		e.preventDefault();

		let eventLayout = $('#layout_selector').find('option:selected').val();
		let eventCols = $('#cols_selector').find('option:selected').val();
		let incEvents = $('#includeevents').val();
		let excEvents = $('#excludeevents').val();
		let eventLimit = $('#numberevents').val();
		let eventOrder = $('#order_selector').find('option:selected').val();
		let eventOrderBy = $('#orderby_selector').find('option:selected').val();
		let eventAuthor = $('#em_author').val();
		let eventComments = $('#em_comments').val();
		let eventDate = $('#em_date').val();
		let headTag = $('#heading_selector').find('option:selected').val();
		let contentLength = $('#contentlength').val(); 
		
		let eventLayoutLabel = eventColsLabel = excEventsLabel = incEventsLabel = eventLimitLabel = eventOrderLabel = eventOrderByLabel = eventAuthorLabel = eventCommentLabel = eventDateLabel = headTagLabel = contentLengthLabel = '';

		if(eventLayout !== ''){
			eventLayoutLabel = ' layout="'+ eventLayout +'"';
		}
		
		if(eventCols !== '' && (eventLayout == 'em-column-grid' || eventLayout == 'em-grid-overlay') ){
			eventColsLabel = ' columns="'+ eventCols +'"';
		}			

		if(incEvents !== ''){
			// remove everything except number and commas			
			incEventsTrimmed = incEvents.replace(/[^0-9,]/gi, '');
			incEventsLabel = ' include='+ incEventsTrimmed;	
		}

		if(excEvents !== ''){
			// remove everything except number and commas			
			excEventsTrimmed = excEvents.replace(/[^0-9,]/gi, '');
			excEventsLabel = ' exclude='+ excEventsTrimmed;	
		}

		if(eventLimit !== ''){
			eventLimitLabel = ' number="'+ eventLimit +'"';	
		}
		if(eventOrder !== ''){
			eventOrderLabel = ' order="'+ eventOrder +'"';	
		}
		if(eventOrderBy !== ''){
			eventOrderByLabel = ' orderby="'+ eventOrderBy +'"';	
		}					
		if ($('#em_author').is(":checked")){
			eventAuthorLabel = ' is_author="'+ eventAuthor +'"';	
		}
		if ($('#em_comments').is(":checked")){
			eventCommentLabel = ' is_comments="'+ eventComments +'"';	
		}
		if ($('#em_date').is(":checked")){
			eventDateLabel = ' is_date="'+ eventDate +'"';	
		}		
		if(headTag !== ''){
			headTagLabel = ' title="'+ headTag +'"';	
		}	
		if(contentLength !== ''){
			contentLengthLabel = ' length="'+ contentLength +'"';	
		}			

		// Shortcode to be appended
		$('#showoption').val('');
		$('#showoption').val('[em_show'+ eventLayoutLabel + eventColsLabel + incEventsLabel + excEventsLabel + eventLimitLabel + eventOrderLabel + eventOrderByLabel + eventAuthorLabel + eventCommentLabel + eventDateLabel + headTagLabel + contentLengthLabel +']');
	});

	$('#reset_settings').on('click', function(e){
		e.preventDefault();
		
		// Reset all fields values
		$('#dropdown_selector').prop('selectedIndex',0);
		$('#layout_selector').prop('selectedIndex',0);
		$('#cols_selector').prop('selectedIndex',0);
		$('#includeevents').val('');
		$('#excludeevents').val('');
		$('#numberevents').val('');
		$('#order_selector').prop('selectedIndex',0);
		$('#orderby_selector').prop('selectedIndex',0);	
		$('#em_author').prop('checked',false);
		$('#em_comments').prop('checked',false);
		$('#em_date').prop('checked',false);
		$('#heading_selector').prop('selectedIndex',0);
		$('#contentlength').val('');
		
		// Reset shortcode field value
		$('#showoption').prop('readonly', false);
		$('#showoption').val('');
		$('#showoption').prop('readonly', true);	

	});

});
   
   
// Copy shortcode to clipboard 
function copy_clipboard() {
	var copyCB = document.getElementById("showoption");
	copyCB.select();
	copyCB.setSelectionRange(0, 99999); 
	if(navigator.clipboard) {
		navigator.clipboard.writeText(copyCB.value);
	}
}    