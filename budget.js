$(document).ready(function() {
      $('.fixed_expenses_table :checkbox').change(function(){
            .ajax({
	      type: "POST",
	      url: "update_fixed_expense.php",
	      data: { name: "John", location: "Boston" }
	    }).done(function( msg ) {
	      alert( "Data Saved: " + msg );
	    });
	    
      });
});
