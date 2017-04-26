


var d = new Date();
var n = d.getDay();
console.log (n);

function validDay(a) {
	// body...
	console.log("fun cal");
	dayVal= $("#day").val();
	
	difference = dayVal- n;
	if(difference>=0 && difference<3){
		console.log(positive difference)
	} else if (n<2 && Math.abs(difference>4)) {
		console.log
	}
	return false;

}


$(document).ready(function() {
	console.log('in here');
	

	$("#ratingForm").submit(function(){
		// body...
		
		validDay("te");
	})

});