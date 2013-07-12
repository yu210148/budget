$(document).ready(function() {
    $( "#fixed_expenses" ).fadeIn('fast');
    $( "#grl" ).fadeIn('medium');
    $( "#run" ).fadeIn('slow');
    $( "#controls" ).fadeIn('slow');
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
    $( "#fixed_expenses_table" ).resizable();
    $( "#fixed_expenses_table" ).draggable();
    $( "#grl_table" ).resizable();
    $( "#grl_table" ).draggable();
    $( "#run_table" ).resizable();
    $( "#run_table" ).draggable();
    $( "#controls" ).resizable();
    $( "#controls" ).draggable();
});

function refresh_grl_tables() {
  $.get("refresh_grl_tables.php")
  location.reload();
  return false;
}

function update_number_of_weeks(num_of_weeks){
 var textInput = document.getElementById(num_of_weeks).value;
 $.ajax({
   type: "POST",
   url: "update_number_of_weeks.php",
   data: "numberOfWeeks="+textInput,
 }).done(function( textInput ) {
   //alert( textInput );
 }); 
};

//TODO: Write a handler to get the grl weekNumber + amount passed to 
 // update_grl_table.php when one of the checkboxes is clicked
 
  
 
 