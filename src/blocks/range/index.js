// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } 				= wp.i18n;
const { registerBlockType } = wp.blocks

registerBlockType( 'straightvisions/sv-forms-range', {
	title: __( 'Range', 'sv_forms' ),
	description: __( 'A field for range.', 'sv_forms' ),
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
		__( 'SV Forms Range', 'sv_forms' ),
		__( 'Range Input', 'sv_forms' ),
		__( 'Range', 'sv_forms' ),
	],
	supports: {
		align:[ 'left', 'right', 'center', 'wide', 'full' ],
	},
	styles: [
		{ label: __( 'Horizontal', 'sv_forms' ), name: 'horizontal', isDefault: true },
		{ label:__( 'Vertical', 'sv_forms' ), name: 'vertical' },
	],
	attributes: {
		inputId: {
			type: 'string',
		},

		// Input Settings
		defaultValue: {
			type: 'number',
		},
		label: {
			type: 'string',
		},
		name: {
			type: 'string',
		},
		type: {
			type: 'string',
			default: 'range',
		},

		// Validation Settings
		required: {
			type: 'boolean',
		},
		min: {
			type: 'number',
			default: 0,
		},
		max: {
			type: 'number',
			default: 100,
		},
		step: {
			type: 'number',
			default: 1,
		},

		// Display Settings
		showValue: {
			type: 'boolean',
			default: true,
		},
		showMin: {
			type: 'boolean',
		},
		showMax: {
			type: 'boolean',
		},

		// Color Settings
		labelColor: {
			type: 'string',
		},
		labelColorClass: {
			type: 'string',
		},

		// Advanced Settings
		autofocus: {
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