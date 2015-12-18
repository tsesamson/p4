// Timer code required to get the timers working
// TODO: Add ajax to feed time recorded to server

// Global Variables

var controlName = 'duration';
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

		//console.log(parseInt(timeArray[2]));

		return result;
	}

	return 0;
}


// Initialize the timer record in the array
function initTimer(id){

	//Grab the value in timer textbox
	var initValue = $("#"+ controlName + id).val();

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
		$('#btn'+controlName+id).removeAttr('onclick')
		$('#btn'+controlName+id).on('click',function(){
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

	// Start the timer on the server	
	$.post('/timers/ajax/start/'+id, {_token:$_token}).success(function(data, status, xhr){
		// Make textbox readonly
		$('#'+ controlName + id).attr('readonly', true);
		$('#'+ controlName + id).addClass('input-disabled');
		
		togglePlayIcon('btn' + controlName + id);
		activeTimers++;

		if(activeTimers==1){ // We have started the first timer!
			setTimeout("updateTimes()", timeInterval);
		}
	});
}

// Stop a timer from counting and toggle the button displays.
function stopTimer(id){
	var dt = new Date();
	var nowSeconds = Math.floor(dt.getTime()/1000);
	var currentAccumulated = (nowSeconds - allTimers[id]["starttime"]);

	allTimers[id]["started"] = false;
	allTimers[id]["accumulated"] = allTimers[id]["accumulated"] + currentAccumulated;
	allTimers[id]["starttime"] = 0;
	allTimers[id]["stopped"] = true;
	
	// Stop the timer on the server	and pass back the most recent logged duration
	$.post('/timers/ajax/stop/'+id, {duration:currentAccumulated ,_token:$_token}).success(function(data, status, xhr){
		allTimers[id]["recordid"] = data['timer']['id'];
		allTimers[id]["lastlogged"] = data['lastlogged'];
		
		// Update statusMessage div
		//$('#statusMessage').html('logged <strong>6 hours</strong> today - last entry <strong>29 minutes ago</strong>')
		var statusString = 'logged <strong>' + getHumanDuration(data['timer']['duration']) + '</strong>';
		
		if(data['lastlogged']){
			statusString = statusString + ' - last entry <strong>' + data['lastlogged'] + ' </strong>';
		}

		$('#statusMessage').hide();
		$('#statusMessage').fadeIn('slow');
		$('#statusMessage').html(statusString);
		
		//Check to see if history button is hidden (if so, it is first timer)
		// Show timer history button if it is hidden
		$('#btnTimerHistory' + id).css("display","inline-block");
		
		//Insert a row above current row
		$( "#collapseBodyHistory" + id).prepend( getTimerRowHtml(data['timer']) );
		
		//console.log(data['timer']);
		
		// Enable textbox 
		$('#'+ controlName + id).attr('readonly', false);
		$('#'+ controlName + id).removeClass('input-disabled');

		togglePlayIcon('btn' + controlName + id);
		activeTimers--;
	});
	
}

// If we have some active running timers, loop though them and update the time message.
// This function is executed once every <timeInterval> miliseconds.
function updateTimes(){

	if(activeTimers>0){
		for(var i in allTimers){
			if(allTimers[i]!=null && allTimers[i]["started"]){
				$('#' + controlName + allTimers[i]["id"]).val(getTimeStr(allTimers[i]["starttime"], allTimers[i]["accumulated"]));
				//console.log(allTimers[i]["id"]);
			}
		}
		setTimeout("updateTimes()", timeInterval);
	}

}

// Save the comment textbox and display effect on textbox indicating record is saved
function saveTimerComment(id) {
	var commentVal = $('#timerComment'+id).val();
	
	$.post('/timers/ajax/comment/'+id, {comment:commentVal,_token:$_token}).success(function(data, status, xhr){
		
		// Fade textbox 3x to show a saved occured
		//for(i=0; i<3; i++) {
			$('#timerComment'+id).fadeTo('slow', 0.5).fadeTo('slow', 1.0);	
		//}
		
	});
}


// Get the row html for a specific timer
function getTimerRowHtml(timer){
	var result = '';
	
	result += '<div class="row" style="padding-top:15px;">';
	result += '<div class="col-md-3">';
	result += '<div name="timerDuration' + timer['id'] + '" id="timerDuration' + timer['id'] + '">';
	result += 'Logged <strong>' + getHumanDuration(timer['duration']) + '</strong>';
	result += '</div></div>';
	result += '<div class="col-md-7">';
	result += '<input type="text" class="form-control" name="timerComment' + timer['id'] + '" id="timerComment' + timer['id'] + '" maxlength="255" placeholder="Comments ..." value="' + timer['comment'] + '">';
	result += '</div>';
	result += '<div class="col-md-2">';
	result += '<div class="col-md-12">';
	result += '<div class="btn-toolbar" role="toolbar">';
	result += "<button class='btn btn-default' type='button' id='btnTimerComment" + timer['id'] + "' onclick='saveTimerComment(\"" + timer['id'] + "\");'><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span></button>";	
	result += '<a href="/timers/delete/' + timer['id'] + '" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
	result += '</div></div></div></div>';
	
	return result;
}

// Return duration in human readable format (i.e. 1 hr 12 mins 13 secs)
function getHumanDuration(duration) {
	var hours = Math.floor(duration / 3600);
	var mins = Math.floor((duration - (hours*3600)) / 60);
	var secs = Math.floor(duration % 60);
	var result = '';
	
	// Assemble the string in readable format
	if(hours > 0)
		result = result + hours + ' hrs ';
	
	if(hours == 0 && mins == 0){}
	else { result = result + mins + ' mins '; }
	
	result = result + secs + ' secs';
	
	return result;
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
