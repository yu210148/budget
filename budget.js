$(document).ready(function() {
      $('#fixed_expenses_table :checkbox').change(function(){
	dataString = $("#fixed").serialize();
	var data = dataString;
            $.ajax({
	      type: "POST",
	      url: "update_fixed_expense.php",
	      data: { data: dataString },
	    }).done(function( data ) {
	      //alert( dataString );
	    });
	    
      });
});

$(function() {
    $( "#fixed_expenses_table" ).slideDown('slow');
    $( "#grl_table" ).slideDown('slow');
    $( "#run_table" ).slideDown('slow');
    $( "#fixed_expenses_table" ).resizable();
    $( "#fixed_expenses_table" ).draggable();
    $( "#grl_table" ).resizable();
    $( "#grl_table" ).draggable();
    $( "#run_table" ).resizable();
    $( "#run_table" ).draggable();
});

