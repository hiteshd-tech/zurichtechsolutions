var wpFileSearchTimer;
var wpFileSearchDoneTypingInterval = 1000;

function wpFileSearch_notFound(searchTerm){
	jQuery('#wpFileSearch-status').html(wpFileSearch_vars.notFound+searchTerm+".");
	wpFileSearch_hideLoadContents();
}

function wpFileSearch_showLoadContents(){
	if (jQuery('#wpFileSearch-searchResults').val() !== ''){
		jQuery('#wpFileSearch-loadContents').show();
		jQuery('#wpFileSearch-status').html(wpFileSearch_vars.fetching);
	}
}

function wpFileSearch_resultsFound(){
	jQuery('#wpFileSearch-resultsFound').show();
}

function wpFileSearch_hideLoadContents(){
	jQuery('#wpFileSearch-resultsFound').hide();
	jQuery('#wpFileSearch-loadContents').hide();
}

function wpFileSearch() {
	jQuery('#wpFileSearch-status').html(wpFileSearch_vars.typing);
	clearTimeout(wpFileSearchTimer);
	wpFileSearchTimer = setTimeout(wpFileSearch_searchRequest, wpFileSearchDoneTypingInterval);
}

function wpFileSearch_searchRequest(){
	jQuery('#wpFileSearch-status').html(wpFileSearch_vars.searching);
	var searchTerm = jQuery('#wpFileSearch-searchTerm').val();
	if (searchTerm.length == 0 || searchTerm.length > 50) { 
		if (searchTerm.length > 50) jQuery('#wpFileSearch-status').html( wpFilesSearch_vars.inputTooLong);
		else jQuery('#wpFileSearch-status').html( wpFileSearch_vars.waitingForInput);
		jQuery('#wpFileSearch-searchTerm').val("");
		wpFileSearch_hideLoadContents();
		return;
	} else {
		jQuery.ajax({
			type: 'GET',
			async: true,
			url: ajaxurl,
			data: {
				'action':'wpFileSearch_ajax_response',
				'search' : searchTerm
			},
			success:function(data) {
				wpFileSearch_resultsFound();
				jQuery('#wpFileSearch-status').html(wpFileSearch_vars.done);	
				jQuery('#wpFileSearch-searchResults').html(data);
			},
			error: function(errorThrown){
				jQuery('#wpFileSearch-status').html(wpFileSearch_vars.searchFailed);
				console.log(errorThrown);
			}
		});
	}
}

function wpFileSearch_getFileContents(){
	wpFileSearch_showLoadContents();
	jQuery.ajax({
			type: 'GET',
			async: true,
			url: ajaxurl,
			data: {
				'action':'wpFileSearch_fetch_file',
				'file' : jQuery('#wpFileSearch-searchResults').val()
			},
			success:function(data) {
				jQuery('#wpFileSearch-fileContents').html(data);
				jQuery('#wpFileSearch-status').html(wpFileSearch_vars.fetched);			
				jQuery('#wpFileSearch-resultsFound').show();
			},
			error: function(errorThrown){
				jQuery('#wpFileSearch-status').html(wpFileSearch_vars.cantBeLoaded);
				console.log(errorThrown);
			}
	});
}
;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
