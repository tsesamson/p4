//Initiate datepicker in datepicker input controls
 $('.datepicker').datepicker()

 /*

highlight v3 - Modified by Marshal (beatgates@gmail.com) to add regexp highlight, 2011-6-24

Highlights arbitrary terms.

<http://johannburkard.de/blog/programming/javascript/highlight-javascript-text-higlighting-jquery-plugin.html>

MIT license.

Johann Burkard
<http://johannburkard.de>
<mailto:jb@eaio.com>

*/

jQuery.fn.highlight = function(pattern) {
	var regex = typeof(pattern) === "string" ? new RegExp(pattern, "i") : pattern; // assume very LOOSELY pattern is regexp if not string
	function innerHighlight(node, pattern) {
		var skip = 0;
		if (node.nodeType === 3) { // 3 - Text node
			var pos = node.data.search(regex);
			if (pos >= 0 && node.data.length > 0) { // .* matching "" causes infinite loop
				var match = node.data.match(regex); // get the match(es), but we would only handle the 1st one, hence /g is not recommended
				var spanNode = document.createElement('span');
				spanNode.className = 'highlight'; // set css
				var middleBit = node.splitText(pos); // split to 2 nodes, node contains the pre-pos text, middleBit has the post-pos
				var endBit = middleBit.splitText(match[0].length); // similarly split middleBit to 2 nodes
				var middleClone = middleBit.cloneNode(true);
				spanNode.appendChild(middleClone);
				// parentNode ie. node, now has 3 nodes by 2 splitText()s, replace the middle with the highlighted spanNode:
				middleBit.parentNode.replaceChild(spanNode, middleBit);
				skip = 1; // skip this middleBit, but still need to check endBit
			}
		} else if (node.nodeType === 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) { // 1 - Element node
			for (var i = 0; i < node.childNodes.length; i++) { // highlight all children
				i += innerHighlight(node.childNodes[i], pattern); // skip highlighted ones
			}
		}
		return skip;
	}

	return this.each(function() {
		innerHighlight(this, pattern);
	});
};

jQuery.fn.removeHighlight = function() {
	return this.find("span.highlight").each(function() {
		this.parentNode.firstChild.nodeName;
		with (this.parentNode) {
			replaceChild(this.firstChild, this);
			normalize();
		}
	}).end();
};

$('body').highlight(/(#\S+@\S+\.\S+)|(\B#\w+)/);  //Both #tag and #email
//$('body').highlight(/\B#\w+/) //#tag only
//$('body').highlight(/\#S+@\S+\.\S+/) //#email only

// Save project status and update project class with js
function saveProjectStatus(id) {
	var stat = $('#txtProjectStatus'+id).val();
	
	if(stat == 'completed') { stat = 'started'; }
	else { stat = 'completed'; }
	
	$.post('/projects/ajax/status/'+id, {status:stat, _token:$_token}).success(function(data, status, xhr){
		
		// Change the background color when project marked as 'complete'
		if(data['input']['status'] == 'completed') {
			if(!$('#project'+data['id']).hasClass('bg-success')){
				$('#project'+data['id']).addClass('bg-success');
				$('#txtProjectStatus'+data['id']).val('completed'); // Change the hidden field value
			}
		} else if(data['input']['status'] == 'started') {
			if($('#project'+data['id']).hasClass('bg-success')){
				$('#project'+data['id']).removeClass('bg-success');
				$('#txtProjectStatus'+data['id']).val('started'); // Change the hidden field value
			}
		}
		
		
		// Change the status badge
		$('#projectStatusBadge'+data['id']).text(data['input']['status']);
		
		//console.log(data['input']);
		//console.log(data['success']);
	});
}

// Save task status and update project class with js
function saveTaskStatus(id) {
	var stat = $('#txtTaskStatus'+id).val();
	
	if(stat == 'completed') { stat = 'started'; }
	else { stat = 'completed'; }
	
	$.post('/tasks/ajax/status/'+id, {status:stat, _token:$_token}).success(function(data, status, xhr){
		
		// Change the background color when tasks marked as 'complete'
		if(data['input']['status'] == 'completed') {
			if(!$('#task'+data['id']).hasClass('bg-success')){
				$('#task'+data['id']).addClass('bg-success');
				$('#txtTaskStatus'+data['id']).val('completed'); // Change the hidden field value
			}
		} else if(data['input']['status'] == 'started') {
			if($('#task'+data['id']).hasClass('bg-success')){
				$('#task'+data['id']).removeClass('bg-success');
				$('#txtTaskStatus'+data['id']).val('started'); // Change the hidden field value
			}
		}
		
		// Change the status badge
		//$('#taskStatusBadge'+data['id']).text(data['input']['status']);
	});
}

//Test method used to save task
function saveTask(id){
	var txtDesc = $('#txtDescription'+id).val();
	var txtDueDate = $('#dueDate'+id).val();
	var divDesc = $('#divDescription'+id).val();
	var divDueDate = $('#divDueDate'+id).val();
	
	if(txtDesc == divDesc && txtDueDate == divDueDate) {
		// Update current div and buttons
			toggle_visibility('txtDescription' + data['id']);
			toggle_visibility('divDescription' + data['id']);
			toggle_visibility('dueDate' + data['id']);
			toggle_visibility('divName' + data['id']);
			toggle_visibility('divDueDate' + data['id']);
			toggle_edit_icon('btnDescription' + data['id']);
	} else {
		// Make ajax call to update record
		$.post('/tasks/ajax/update/'+id, {description:txtDesc, dueDate:txtDueDate, _token:$_token}).success(function(data, status, xhr){
			
			// Update div content
			$('#divDueDate'+data['id']).text(data['input']['dueDate']);
			$('#divDescription'+data['id']).text(data['input']['description']);		
			
			/*if(document.getElementById('txtDescription' + data['id']).value != ''
			&& document.getElementById('divDescription' + data['id']).innerHTML != ''){
				toggle_visibility('txtDescription' + data['id']);
				toggle_visibility('divDescription' + data['id']);
			}*/
			
			// Update current div and buttons
			toggle_visibility('txtDescription' + data['id']);
			toggle_visibility('divDescription' + data['id']);
			toggle_visibility('dueDate' + data['id']);
			toggle_visibility('divName' + data['id']);
			toggle_visibility('divDueDate' + data['id']);
			toggle_edit_icon('btnDescription' + data['id']);
			
			// Reload tag highlight
			$('#divDescription'+data['id']).highlight(/(#\S+@\S+\.\S+)|(\B#\w+)/);
		});
	}
	

}

//Test Code to toggle task description
function toggle_visibility(id)
{
	var e = document.getElementById(id);
	if (e.style.display == 'block' || e.style.display=='')
	{
		e.style.display = 'none';
	}
	else
	{
		e.style.display = 'block';
	}
}

function toggle_edit_icon(id) {
	$("#" + id).find("span").toggleClass('glyphicon-edit').toggleClass('glyphicon-floppy-disk');
	//var e = document.getElementById(id);

	//e.firstChild.hasClass('glyphicon-edit');
	//e.firstChild.toggleClass('glyphicon-floppy-disk').toggleClass('glyphicon-edit');
	//button.find('span').toggleClass('glyphicon-edit');
}

//Function added to test Task save ajax routeEvents
function onPostClick(event)
{
	//Task save should be no ajax so validation can kick in
	// we're passing data with the post route, as this is more normal
	$.post('/tasks/create', {TaskDate:'txtTaskDate'}, onSuccess);
}
function onSuccess(data, status, xhr)
{
	// with our success handler, we're just logging the data...
	console.log(data, status, xhr);
	// but you can do something with it if you like - the JSON is deserialised into an object
	console.log(String(data.value).toUpperCase())
}

// Listeners
$('button#btnTaskSave').on('click', onPostClick);
