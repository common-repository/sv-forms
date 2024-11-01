// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks

registerBlockType( 'straightvisions/sv-forms-radio', {
	title: __( 'Radio Button', 'sv_forms' ),
	description: __( 'Create a radio button.', 'sv_forms' ),
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
		__( 'SV Forms Radio Button', 'sv_forms' ),
		__( 'Radio Button', 'sv_forms' ),
		__( 'Radio', 'sv_forms' ),
	],
	supports: {
		align:[ 'left', 'right', 'center', 'wide', 'full' ],
	},
	attributes: {		
		inputId: {
			type: 'string',
		},
		
		// Input Settings
		defaultValue: {
			type: 'string',
		},
		label: {
			type: 'string',
		},
		name: {
			type: 'string',
		},
		type: {
			type: 'string',
			default: 'radio',
		},
		options: {
			type: 'string',
			default: '[{"label":"' + __( 'Option', 'sv_forms' ) +  '","value":""}]',
		},

		// Color Settings
		labelColor: {
			type: 'string',
		},
		labelColorClass: {
			type: 'string',
		},
		inputBackgroundColor: {
			type: 'string',
			default: '#FFFFFF'
		},
		inputBackgroundColorClass: {
			type: 'string',
		},
		inputBorderColor: {
			type: 'string',
			default: '#000000'
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
			default: 10,
		},

		// Advanced Settings
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