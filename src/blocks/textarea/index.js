// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks

registerBlockType( 'straightvisions/sv-forms-textarea', {
	title: __( 'Textarea', 'sv_forms' ),
	description: __( 'A field for long messages.', 'sv_forms' ),
	icon,
	parent: [ 
		'straightvisions/sv-forms-form',
		'core/group',
		'core/column',
		'core/media-text',
		'core/cover' 
	],
	category: 'straightvisions',
	keywords: [
		__( 'SV Forms Textarea', 'sv_forms' ),
		__( 'Textarea Input', 'sv_forms' ),
		__( 'Textarea', 'sv_forms' ),
	],
	supports: {
		align:[ 'left', 'right', 'center', 'wide', 'full' ],
	},
	attributes: {
		inputId: {
			type: 'string',
		},
		defaultValue: {
			type: 'string',
		},

		// Input Settings
		name: {
			type: 'string',
		},
		type: {
			type: 'string',
			default: 'textarea',
		},
		placeholder: {
			type: 'string',
			default: __( 'Textarea', 'sv_forms' ),
		},
		inputFontSize: {
			type: 'number',
		},

		// Label Settings
		label: {
			type: 'string',
		},
		labelFontSize: {
			type: 'number',
		},

		// Color Settings
		inputColor: {
			type: 'string',
			default: '#000000'
		},
		inputColorClass: {
			type: 'string',
		},
		inputBackgroundColor: {
			type: 'string',
			default: '#FFFFFF'
		},
		inputBackgroundColorClass: {
			type: 'string',
		},
		labelColor: {
			type: 'string',
		},
		labelColorClass: {
			type: 'string',
		},
		inputBorderColor: {
			type: 'string',
			default: '#E5E5E5'
		},

		// Border Settings
		borderStyle: {
			type: 'string',
			default: 'solid'
		},
		borderWidthTop: {
			type: 'number',
			default: 1,
		},
		borderWidthRight: {
			type: 'number',
			default: 1,
		},
		borderWidthBottom: {
			type: 'number',
			default: 1,
		},
		borderWidthLeft: {
			type: 'number',
			default: 1,
		},
		borderRadius: {
			type: 'number',	
			default: 5,
		},

		// Validation Settings
		required: {
			type: 'boolean',
		},
		maxlength: {
			type: 'number',
			default: 0,
		},

		// Advanced Settings
		autofocus: {
			type: 'boolean',
		},
		readonly: {
			type: 'boolean',
		},
		disabled: {
			type: 'boolean',
		},
		className: {
			type: 'string',
		},
	},
	edit,
	save: () => {
		return null;
	}
} );