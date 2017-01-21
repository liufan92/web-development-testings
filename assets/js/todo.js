$(function() {

	$(document).on("keyup", ".addNewInput", function(){

	    	if($(this).val().length != 0)
	    		$('.addNewBtn').prop('disabled',false);
	    	else
	    		$('.addNewBtn').prop('disabled',true);
	    });

	$(document).on("keyup", ".noteTitle", function(){

	    	if($(this).val().length != 0)
	    		$('.saveNote').prop('disabled',false);
	    	else
	    		$('.saveNote').prop('disabled',true);
	    });
});
