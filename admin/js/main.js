document.addEventListener('DOMContentLoaded', function() {
		var editor = ace.edit("nc_bb_sm_definition_editor");
		editor.setTheme("ace/theme/github");
		editor.session.setMode("ace/mode/json");
		
		// Retrieves the JSON from the hidden field
		var jsonData = document.getElementById('nc_bb_sm_definition_field').value;
		
		// Formats the JSON for better visualization
		try {
				var formattedJson = JSON.stringify(JSON.parse(jsonData), null, 2);
		} catch (e) {
				var formattedJson = jsonData; // Si el JSON no es válido, muestra como está
		}
		
		// Sets the editor's value
		editor.setValue(formattedJson, -1);
		editor.setReadOnly(false); // Solo lectura
		
		// Updates the hidden field whenever the editor changes
		editor.session.on('change', function() {
				document.getElementById('nc_bb_sm_definition_field').value = editor.getValue();
		});
});

document.addEventListener('DOMContentLoaded', function() {
		var editor = ace.edit("nc_bb_sm_front_editor");
		editor.setTheme("ace/theme/github");
		editor.session.setMode("ace/mode/html");
		
		// Retrieves the HTML from the hidden field
		var htmlData = document.getElementById('nc_bb_sm_front_field').value;

		// Decodes the HTML
		htmlData = decodeURIComponent(htmlData.replace(/\+/g, ' '));

		// Waits for js-beautify to be ready
		var checkBeautify = setInterval(function() {
				if (typeof window.html_beautify === 'function') {
						clearInterval(checkBeautify);

						var formattedHtml = window.html_beautify(htmlData, {
								indent_size: 2,
								indent_char: ' ',
								preserve_newlines: true,
								max_preserve_newlines: 1,
								end_with_newline: true,
								wrap_line_length: 0
						});

						// Sets the editor's value
						editor.setValue(formattedHtml, -1);
				}
		}, 100);

		editor.setReadOnly(false); 

		// Updates the hidden field value
		editor.session.on('change', function() {
				var editorContent = editor.getValue();
				document.getElementById('nc_bb_sm_front_field').value = encodeURIComponent(editorContent);
		});
});