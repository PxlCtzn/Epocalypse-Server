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

var base_url = Routing.generate('web_map_generator_get_form', { 'name': "" })+"/";

/**
 * When the document is loaded (without waiting for images, css and subframes), 
 * we update the form in order display it if anyone is selected.
 */
document.addEventListener("DOMContentLoaded", function() {
	var selector = document.getElementById('map_algorithm_selector');
	selector.addEventListener('change', function(){ updateForm(); } );
	
    updateForm();
});

function updateForm(){
	console.log("udpateForm()");
	var selectorElement = document.getElementById('map_algorithm_selector');
	var selectedValue = selectorElement.options[selectorElement.selectedIndex].value;
	var endpoint = base_url + selectedValue;
	console.log("End point : " + endpoint);

	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById('form_container').innerHTML = this.response;
		}
	};
	
	xhttp.open("GET", endpoint, true);
	xhttp.send();
	  
}