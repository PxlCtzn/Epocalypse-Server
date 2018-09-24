/**
 * This file is part of the Epocalypse-Server project.
 *
 * Copyright (C) 2018  PxlCtzn
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <https://www.gnu.org/licenses/>.
 */

var endpoint = Routing.generate('web_map_generator_generate_map');
console.log("End point : " + endpoint);


/**
 * When we change the selected algorithm we attach : 
 *  - the updateMap() to the submit button;
 *  - TODO : the function that will deal with the auto update feature. 
 */

document.addEventListener("DOMContentLoaded", function() {
	var formContainer = document.getElementById('form_container'); 		// Select the node that will be observed for mutations
	var config = { attributes: true, childList: true, subtree: true }; 	// Options for the observer (which mutations to observe)

	// Callback function to execute when mutations are observed
	var callback = function(mutationsList, observer) {
		// We attach the updateMap() to the submit action;
		document.getElementById('map_algorithm_form')
				.addEventListener("submit", updateMap, true);
		
		// We trigger the event to force the map update
		/*
        document.getElementById('map_algorithm_form')
				.submit(); 
		*/
		// TODO : the function that will deal with the auto update feature.
	};

	// Create an observer instance linked to the callback function
	var observer = new MutationObserver(callback);

	// Start observing the target node for configured mutations
	observer.observe(formContainer, config);
});


function updateMap(event){
	event.preventDefault();
    event.stopPropagation();

	console.log("updateMap()");
	
	var form = document.getElementById("map_algorithm_form");
	
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {	
			document.getElementById('map_container').innerHTML = this.response;
		}
	};
	
	xhttp.open("POST", endpoint, true);
	xhttp.send(new FormData(form));
	
	return false;
}