// Self executing anonymous function, to make the vars and functions private
(function() {
	// Variables
	const localized = js_sv_forms_sv_forms_scripts_form_js;
	let formsID = false;
	
	// Extends the JS String Object with a function that is similar to str_replace() function from PHP
	String.prototype.replaceArray = function(find, replace) {
		var replaceString = this;
		var regex;
		for (var i = 0; i < find.length; i++) {
			regex = new RegExp(find[i], "g");
			replaceString = replaceString.replace(regex, replace[i]);
		}
		return replaceString;
	};
	
	// Functions
	// Returns the parsed thank you message content
	const getParsedContent = ( content, formData ) => {
		let names   = [];
		let find    = [];
		let replace = [];
		const matches = content.match( /%(.*?)%/g );
		
		if ( matches ) {
			matches.forEach( name => {
				find.push( name );
				names.push( name.split('%').join('') );
			} );
		}
		
		names.forEach( name => {
			const formInput = formData.find( input => { return name === input.name; } );
			
			if ( formInput ) {
				replace.push( formInput.value );
			} else {
				replace.push( '' );
			}
		});
		
		content = content.replaceArray( find, replace );
		
		return content;
	}
	
	const showThankYou = ( form, formData ) => {
		const el = form.parentElement.querySelector( '.wp-block-straightvisions-sv-forms-thank-you' );
		
		if ( el && el.innerHTML.replace(/\s/g, "") ) {
			const parsedContent = getParsedContent( el.innerHTML, formData );
			
			el.innerHTML = parsedContent;
			form.parentElement.insertBefore( el, form.nextSibling );
			
			form.style.display = 'none';
			el.style.display = 'block';
		}
	}
	
	//Collect the form data
	const getFormData = (form) => {
		const formFields = form.querySelectorAll('input, select, textarea');
		const formValues = [];
		
		formFields.forEach((field) => {
			if(field.type !== "file" && field.name.length > 0) {
				if ((field.type === 'radio' || field.type === 'checkbox') && !field.checked) {
					// Skip unchecked radio buttons and checkboxes
					return;
				}
				formValues.push({name:field.name, value:field.value, type:field.type});
			}
			
		});
		
		return formValues;
	}
	
	//Get all Forms and listen to submit event
	document.querySelectorAll( 'form.wp-block-straightvisions-sv-forms-form' ).forEach( form => {
		form.addEventListener( 'submit', function( e ) {
			e.preventDefault();
			
			const formData = getFormData(this);
			const formFiles = form.querySelectorAll('input[type="file"]');
			let newFormData = [];
			
			for (const singleField of formData){
				const el = singleField;
				
				if ( el ) {
					if ( el.value !== "" || el.name === 'sv_forms_sg_hp' ) {
						let newField = {
							name: el.name,
							type: el.type,
							value: el.value,
						};
						
						if ( singleField.name === 'sv_forms_form_id' ) {
							formsID = singleField.value;
						}
						
						// The following code checks for specific input types
						// and stores their label instead of the value
						let labelText = false;
						
						switch ( newField.type ) {
							case 'radio':
								const radio = form.querySelector('input[type="radio"][name="' + newField.name + '"][value="' + newField.value + '"]');
								
								if ( radio && radio.value && radio.value !== '' ) {
									labelText = radio.parentElement.querySelector('label[for="' + newField.name + '"]').textContent;
								}
								
								break;
						}
						
						if ( labelText && labelText !== '' ) {
							newField.value = labelText;
						}
						
						newFormData.push( newField );
					}
				}
			};
			
			const ajaxData = new FormData();
			
			ajaxData.append('action', 'sv_forms_submit');
			
			// HOTFIX WRONG FILTERED ID -------------------------
			const postID = (formsID && localized[formsID]) ? localized[formsID] : false;
			// remove the broken ID
			newFormData = newFormData.filter(obj => obj.name !== 'sv_forms_post_id');
			// add the correct id from localize
			ajaxData.append('sv_forms_post_id', postID);
			// HOTFIX WRONG FILTERED ID -------------------------
			
			formFiles.forEach(function(file) {
				const el = file
				
				if (el && el.name !== "" && el.value !== "") {
					
					console.log("Datei", el.files[0]);
					
					let newField = {
						name: el.name,
						type: "file",
						value: el.value,
					};
					
					newFormData.push(newField);
					ajaxData.append(newField.name, el.files[0]);
				}
			});
			
			console.log(...newFormData);
			
			ajaxData.append('sv_forms_form_data', JSON.stringify(newFormData));
			
			fetch(localized.sv_forms_ajaxurl, {
				method: 'POST',
				body: ajaxData,
			})
				.then(response => response.text())
				.then((response) => {
					document.querySelector('.sv_forms_sv_forms_wrapper_loader').classList.remove('show');
					showThankYou(form, newFormData);
				})
				.catch(error => console.error('Error:', error));
			
			document.querySelector('.sv_forms_sv_forms_wrapper_loader').classList.add('show');
			form.style.display = 'none';
		});
	});
})();
