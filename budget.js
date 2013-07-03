$(document).ready(function() {
      $('.fixed_expenses_table :checkbox').change(function(){
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
