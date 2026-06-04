jQuery(document).ready(function ($) {

	function aerGetTypeLabel(type) {

	const labels = {
		text: aerRepeater.text,
		textarea: aerRepeater.textarea,
		number: aerRepeater.number,
		select: aerRepeater.select,
		checkbox: aerRepeater.checkbox,
		radio: aerRepeater.radio,
		true_false: aerRepeater.trueFalse,
		image: aerRepeater.image,
		file: aerRepeater.file,
		date_picker: aerRepeater.datePicker,
		date_time_picker: aerRepeater.dateTimePicker,
		wysiwyg: aerRepeater.wysiwyg
	};

	return labels[type] || type;
}
function updateRowNumbers() {

    $('.aer-repeater-rows .aer-repeater-row').each(function(index){

        $(this)
            .find('.aer-row-number')
            .text(
                aerRepeater.row + ' #' + (index + 1)
            );

    });

}
	/*
	|--------------------------------------------------------------------------
	| Add Row
	|--------------------------------------------------------------------------
	*/

	$(document).on('click', '.aer-add-row', function () {

		let wrapper = $(this).closest('.aer-repeater-wrapper');

		let rowsContainer = wrapper.find('.aer-repeater-rows');

		/*
		 * Clone hidden template row.
		 */
		let row = wrapper
			.find('.aer-repeater-template .aer-repeater-row')
			.clone();

		/*
|--------------------------------------------------------------------------
| Unique row index
|--------------------------------------------------------------------------
|
| Use timestamp for guaranteed uniqueness.
|
*/

let rowIndex = Date.now();
	/*
|--------------------------------------------------------------------------
| Replace ALL template placeholders
|--------------------------------------------------------------------------
*/

row.find('*').addBack().each(function () {

	/*
	 * Replace name.
	 */
	if ($(this).attr('name')) {

		$(this).attr(
			'name',
			$(this)
				.attr('name')
				.replace(/__index__/g, rowIndex)
		);
	}

	/*
	 * Replace id.
	 */
	if ($(this).attr('id')) {

		$(this).attr(
			'id',
			$(this)
				.attr('id')
				.replace(/__index__/g, rowIndex)
		);
	}

	/*
	 * Replace for attr.
	 */
	if ($(this).attr('for')) {

		$(this).attr(
			'for',
			$(this)
				.attr('for')
				.replace(/__index__/g, rowIndex)
		);
	}

	/*
 * Replace data-key.
 */
if ($(this).attr('data-key')) {

	let dataKey = $(this).attr('data-key');

	/*
	 * Only modify repeater demo fields.
	 */
	if (dataKey.indexOf('field_aer_') === 0) {

		$(this).attr(
			'data-key',
			dataKey + '_' + rowIndex
		);
	}
}
});

		/*
		 * Clear values.
		 */
		row.find('input[type="text"], textarea').val('');



		/*
		 * Append row.
		 */
		rowsContainer.append(row);
updateRowNumbers();
row.removeClass('aer-collapsed');
	
if (typeof acf !== 'undefined') {

    setTimeout(function () {

        acf.doAction(
            'append',
            row
        );

      row.find('.acf-field').each(function(){

    var field = acf.getField(this);

    if (!field) {
        return;
    }

    if (
        field.get('type') === 'date_picker' ||
        field.get('type') === 'date_time_picker'
    ) {

        field.initialize();
    }

});

    /*
|--------------------------------------------------------------------------
| Initialize WYSIWYG Fields
|--------------------------------------------------------------------------
*/

setTimeout(function(){

   row.find('.acf-field-wysiwyg').each(function(){

    var $wysiwyg = $(this);

    var field = acf.getFields({
        type: 'wysiwyg'
    }).find(function(f){

        return f.$el[0] === $wysiwyg[0];

    });

    if (!field) {
        return;
    }

    field.$el
        .find('.acf-editor-wrap')
        .removeClass('delay');

    field.$el
        .find('.acf-editor-toolbar')
        .remove();

    field.initializeEditor();

});

}, 100);

    }, 100);
}

/*
|--------------------------------------------------------------------------
| Refresh sortable
|--------------------------------------------------------------------------
*/

rowsContainer.sortable('refresh');

	
	});

	/*
	|--------------------------------------------------------------------------
	| Remove Row
	|--------------------------------------------------------------------------
	*/

	$(document).on('click', '.aer-remove-row', function () {

		let rowsContainer = $(this)
			.closest('.aer-repeater-rows');

		$(this)
			.closest('.aer-repeater-row')
			.remove();
 updateRowNumbers();
		
	});

	/*
	|--------------------------------------------------------------------------
	| Sortable
	|--------------------------------------------------------------------------
	*/

if (typeof jQuery.fn.sortable !== 'undefined') {

    $('.aer-repeater-rows').sortable({
        handle: '.aer-repeater-handle'
    });

}

// Helper field type options

function aerFieldTypeOptions(selectedType) {

	return `

		<option value="text"
			${selectedType === 'text' ? 'selected' : ''}
		>
			${aerRepeater.text}
		</option>

		<option value="textarea"
			${selectedType === 'textarea' ? 'selected' : ''}
		>
			${aerRepeater.textarea}
		</option>

		<option value="number"
			${selectedType === 'number' ? 'selected' : ''}
		>
			${aerRepeater.number}
		</option>

		<option value="select"
			${selectedType === 'select' ? 'selected' : ''}
		>
			${aerRepeater.select}
		</option>

		<option value="checkbox"
			${selectedType === 'checkbox' ? 'selected' : ''}
		>
			${aerRepeater.checkbox}
		</option>

		<option value="radio"
			${selectedType === 'radio' ? 'selected' : ''}
		>
			${aerRepeater.radio}
		</option>

		<option value="true_false"
			${selectedType === 'true_false' ? 'selected' : ''}
		>
			${aerRepeater.trueFalse}
		</option>

		<option value="image"
			${selectedType === 'image' ? 'selected' : ''}
		>
			${aerRepeater.image}
		</option>

		<option value="file"
			${selectedType === 'file' ? 'selected' : ''}
		>
			${aerRepeater.file}
		</option>

		<option value="date_picker"
			${selectedType === 'date_picker' ? 'selected' : ''}
		>
			${aerRepeater.datePicker}
		</option>

		<option value="date_time_picker"
			${selectedType === 'date_time_picker' ? 'selected' : ''}
		>
			${aerRepeater.dateTimePicker}
		</option>

		<option value="wysiwyg"
			${selectedType === 'wysiwyg' ? 'selected' : ''}
		>
			${aerRepeater.wysiwyg}
		</option>

	`;

}

/*
|--------------------------------------------------------------------------
| Render Sub Fields
|--------------------------------------------------------------------------
*/

function aerRenderSubFields(builder) {

	let hiddenInput = builder
	.closest('.acf-field-object')
	.find('input[name$="[sub_fields_json]"]')
	.first();

	let list = builder.find('.aer-subfields-list');

	let fields = [];

	try {
	


		fields = JSON.parse(
			hiddenInput.val() || '[]'
		);

	} catch (e) {

		fields = [];
	}

	list.html('');

	fields.forEach(function (field, index) {
	list.append(`

	<div class="aer-subfield-card">

		<div class="aer-subfield-header">

			<div class="aer-subfield-left">

				<span class="aer-subfield-arrow">
					▼
				</span>

				<span class="aer-subfield-title">
					${field.label || aerRepeater.newField}
				</span>

			</div>

			<div class="aer-subfield-right">

				<span class="aer-subfield-type-badge">
					${aerGetTypeLabel(field.type || 'text')}
				</span>

				<button
					type="button"
					class="button aer-remove-subfield"
					data-index="${index}"
				>
					${aerRepeater.remove}
				</button>

			</div>

		</div>

		<div class="aer-subfield-body">

			<div class="aer-subfield-grid">

				<div>

					<label>
						${aerRepeater.label}
					</label>

					<input
						type="text"
						class="aer-subfield-label"
						value="${field.label || ''}"
						data-index="${index}"
					>

				</div>

				<div>

					<label>
						${aerRepeater.name}
					</label>

					<input
						type="text"
						class="aer-subfield-name"
						value="${field.name || ''}"
						data-index="${index}"
					>

				</div>

				<div>

					<label>
						${aerRepeater.type}
					</label>

					<select
						class="aer-subfield-type"
						data-index="${index}"
					>
						${aerFieldTypeOptions(field.type)}
					</select>

				</div>

			</div>

			<textarea
				class="aer-subfield-choices"
				placeholder="${aerRepeater.choicesPlaceholder}&#10;select1 : Select 1&#10;select2 : Select 2"
				data-index="${index}"
				style="
					display:${
						['select','checkbox','radio']
						.includes(field.type)
							? 'block'
							: 'none'
					};
					margin-top:15px;
					min-height:100px;
					width:100%;
				"
			></textarea>

		</div>

	</div>

`);

	/*
	|--------------------------------------------------------------------------
	| Populate Choices Textarea
	|--------------------------------------------------------------------------
	*/

	let choicesValue = '';

if (
	field.choices &&
	typeof field.choices === 'object' &&
	!Array.isArray(field.choices)
) {

	choicesValue = Object.entries(
		field.choices
	)
	.map(function([value, label]) {

		return value + ' : ' + label;

	})
	.join('\n');

} else {

	choicesValue = field.choices || '';
}

list
	.find('.aer-subfield-card:last .aer-subfield-choices')
	.val(choicesValue);
});
}

//Field settings subfields collapsible

$(document).on(
	'click',
	'.aer-subfield-header',
	function(e){

		if (
			$(e.target)
				.closest('.aer-remove-subfield')
				.length
		) {
			return;
		}

		$(this)
			.closest('.aer-subfield-card')
			.toggleClass('collapsed');

	}
);

//Subfeilds in field settings live title update

$(document).on(
	'input',
	'.aer-subfield-label',
	function(){

		$(this)
			.closest('.aer-subfield-card')
			.find('.aer-subfield-title')
			.text(
				$(this).val() || aerRepeater.newField
			);

	}
);

// Subfeilds in field settings Live type badge update:

$(document).on(
	'change',
	'.aer-subfield-type',
	function(){

		$(this)
			.closest('.aer-subfield-card')
			.find('.aer-subfield-type-badge')
			.text(
				$(this)
					.find(':selected')
					.text()
			);

	}
);

/*
|--------------------------------------------------------------------------
| Save Sub Fields JSON
|--------------------------------------------------------------------------
*/

function aerSaveSubFields(builder) {

	let fields = [];

	builder.find('.aer-subfield-card').each(function () {
    let choices = $(this)
        .find('.aer-subfield-choices')
        .val();

    
		fields.push({

			label: $(this)
				.find('.aer-subfield-label')
				.val(),

			name: $(this)
				.find('.aer-subfield-name')
				.val(),

			type: $(this)
				.find('.aer-subfield-type')
				.val(),

			choices: $(this)
				.find('.aer-subfield-choices')
				.val()

		});

	});

	builder
		.closest('.acf-field-object')
		.find('input[name$="[sub_fields_json]"]')
		.first()
		.val(JSON.stringify(fields))
		.trigger('change')
		.trigger('input');
}

/*
|--------------------------------------------------------------------------
| Add Sub Field
|--------------------------------------------------------------------------
*/

$(document).on(
	'click',
	'.aer-add-subfield',
	function () {

		let builder = $(this)
			.closest('.aer-subfields-builder');

		let hiddenInput = builder
	.closest('.acf-field-object')
	.find('input[name$="[sub_fields_json]"]')
	.first();

		let fields = [];

		try {

			fields = JSON.parse(
				hiddenInput.val() || '[]'
			);

		} catch (e) {

			fields = [];
		}

		fields.push({

			label: '',
			name: '',
			type: 'text'
		});

		hiddenInput
    .val(JSON.stringify(fields))
    .trigger('change')
    .trigger('input');

		aerRenderSubFields(builder);
	}
);

/*
|--------------------------------------------------------------------------
| Remove Sub Field
|--------------------------------------------------------------------------
*/

$(document).on(
	'click',
	'.aer-remove-subfield',
	function () {

		let builder = $(this)
			.closest('.aer-subfields-builder');

		let hiddenInput = builder
	.closest('.acf-field-object')
	.find('input[name$="[sub_fields_json]"]')
	.first();

		let fields = [];

		try {

			fields = JSON.parse(
				hiddenInput.val() || '[]'
			);

		} catch (e) {

			fields = [];
		}

		fields.splice(
			$(this).data('index'),
			1
		);

		hiddenInput
    .val(JSON.stringify(fields))
    .trigger('change')
    .trigger('input');

		aerRenderSubFields(builder);
	}
);

/*
|--------------------------------------------------------------------------
| Auto Generate Field Name
|--------------------------------------------------------------------------
*/

$(document).on(
	'input',
	'.aer-subfield-label',
	function () {

		let row = $(this)
			.closest('.aer-subfield-card');

		let nameField = row.find(
			'.aer-subfield-name'
		);

		nameField.val(
			$(this)
				.val()
				.toLowerCase()
				.replace(/[^a-z0-9]+/g, '_')
				.replace(/^_|_$/g, '')
		);

		aerSaveSubFields(
			row.closest(
				'.aer-subfields-builder'
			)
		);

	}
);

/*
|--------------------------------------------------------------------------
| Save Changes
|--------------------------------------------------------------------------
*/

$(document).on(
	'input change',
	'.aer-subfield-label, .aer-subfield-name, .aer-subfield-type, .aer-subfield-choices',
	function () {

		aerSaveSubFields(
			$(this).closest('.aer-subfields-builder')
		);

	}
);

/*
|--------------------------------------------------------------------------
| Toggle Choices Field
|--------------------------------------------------------------------------
*/

$(document).on(
	'change',
	'.aer-subfield-type',
	function () {

		let row = $(this)
			.closest('.aer-subfield-card');

		let choicesField = row.find(
			'.aer-subfield-choices'
		);

		if (
			['select', 'checkbox', 'radio']
			.includes($(this).val())
		) {

			choicesField.show();

		} else {

			choicesField.hide();
		}

		aerSaveSubFields(
			row.closest(
				'.aer-subfields-builder'
			)
		);
	}
);

/*
|--------------------------------------------------------------------------
| Init Builders
|--------------------------------------------------------------------------
*/



	$('.aer-subfields-builder').each(function () {

		aerRenderSubFields($(this));
	});

/*
|--------------------------------------------------------------------------
| Clean Template ACF Fields
|--------------------------------------------------------------------------
*/

$('.aer-repeater-template').find('.acf-date-picker .input').each(function(){

    $(this)
        .removeClass('hasDatepicker')
        .removeAttr('id')
        .val('');

});

$('.aer-repeater-template').find('.acf-date-time-picker .input').each(function(){

    $(this)
        .removeClass('hasDatepicker')
        .removeAttr('id')
        .val('');

});

$(document).on(
    'click',
    '.aer-repeater-handle',
    function(){

        $(this)
            .closest('.aer-repeater-row')
            .toggleClass('aer-collapsed');

    }
);


updateRowNumbers();
});