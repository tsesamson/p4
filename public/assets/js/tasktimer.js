// Timer code required to get the timers working
// TODO: Add ajax to feed time recorded to server

// Global Variables

var timeInterval = 1000;
var allTimers = [];
var d = new Date();
var activeTimers = 0;
var timeout;
var request = false;

// Get a formatted string of the current accumulated time in hours, minutes, seconds.
function getTimeStr(startSeconds, accumulatedSeconds){

	var dt = new Date();
	var nowSeconds = Math.floor(dt.getTime()/1000);

	var secondsElapsed = (nowSeconds - startSeconds) + accumulatedSeconds;

	var hours = Math.floor(secondsElapsed / (60*60));
	secondsElapsed = secondsElapsed % (60*60);

	var minutes = Math.floor(secondsElapsed / (60));
	var seconds = secondsElapsed % 60;

	//return(hours+"h "+minutes+"m "+seconds+"s");
	return(hours + ":" + zeropad(minutes,2) + ":" + zeropad(seconds,2));
}

// Get the accmulated time from string
function stringToSecond(v){
	var timeArray = v.split(':');
	var result = 0;

	if(timeArray.length == 3){
		result += parseInt(timeArray[0])*60*60; //Convert hrs to second
		result += parseInt(timeArray[1])*60; //Convert min to second
		result += parseInt(timeArray[2]); //Add seconds

		console.log(parseInt(timeArray[2]));

		return result;
	}

	return 0;
}


// Initialize the timer record in the array
function initTimer(id){

	//Grab the value in timer textbox
	var initValue = $("#" + id).val();

	if(allTimers[id] === undefined ){
		//var pos = allTimers.length;
		allTimers[id] = {};
		allTimers[id]["recordid"] = null;
		allTimers[id]["id"] = id;
		allTimers[id]["started"] = false; // Indicates that a timer is currently counting up.
		allTimers[id]["stopped"] = false; // Indicates that a timer has been paused/stopped.
		allTimers[id]["starttime"] = 0;
		allTimers[id]["accumulated"] = 0;
		allTimers[id]["loggedtime"] = 0;  // Total logged time.
		allTimers[id]["lastlogged"] = "Never";

		// Set the proper accmulated amount if prior value exists
		if(initValue.length > 0) {
			allTimers[id]["accumulated"] = stringToSecond(initValue);
		}

		//Set toggle timer function
		$('#btn'+id).removeAttr('onclick')
		$('#btn'+id).on('click',function(){
			if($(this).attr('data-click-state') == 1) {
				$(this).attr('data-click-state', 0)
				startTimer(id);  //Change onclick to startTimer function
			} else {
				$(this).attr('data-click-state', 1)
				stopTimer(id);  //Change onclick to stopTimer function
			}
		});
	}
}

// Start a timer counting up. Toggle button display to pause.
function startTimer(id){
	var dt = new Date();
	var nowSeconds = Math.floor(dt.getTime()/1000);
	initTimer(id);

	allTimers[id]["started"] = true;
	allTimers[id]["starttime"] = nowSeconds;
	allTimers[id]["stopped"] = false;

	//Make textbox readonly
	$('#' + id).attr('readonly', true);
	$('#' + id).addClass('input-disabled');


	togglePlayIcon('btn' + id);
	activeTimers++;

	if(activeTimers==1){ // We have started the first timer!
		setTimeout("updateTimes()", timeInterval);
	}
}

// Stop a timer from counting and toggle the button displays.
function stopTimer(id){
	var dt = new Date();
	var nowSeconds = Math.floor(dt.getTime()/1000);

	allTimers[id]["started"] = false;
	allTimers[id]["accumulated"] = allTimers[id]["accumulated"] + (nowSeconds - allTimers[id]["starttime"]);
	allTimers[id]["starttime"] = 0;
	allTimers[id]["stopped"] = true;

	//Make textbox readonly
	$('#' + id).attr('readonly', false);
	$('#' + id).removeClass('input-disabled');

	togglePlayIcon('btn' + id);
	activeTimers--;
}


// If we have some active running timers, loop though them and update the time message.
// This function is executed once every <timeInterval> miliseconds.
function updateTimes(){

	if(activeTimers>0){
		for(var i in allTimers){
			if(allTimers[i]!=null && allTimers[i]["started"]){
				$('#' + allTimers[i]["id"]).val(getTimeStr(allTimers[i]["starttime"], allTimers[i]["accumulated"]));
				//console.log(allTimers[i]["id"]);
			}
		}
		setTimeout("updateTimes()", timeInterval);
	}

}

// Used to toggle between play and pause icon
function togglePlayIcon(id) {
	$("#" + id).find("span").toggleClass('glyphicon-pause').toggleClass('glyphicon-play');
}

// Function used to zero pad the time
function zeropad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}
