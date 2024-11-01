// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks

registerBlockType( 'straightvisions/sv-forms-hidden', {
	title: __( 'Hidden', 'sv_forms' ),
	description: __( 'A field that is hidden.', 'sv_forms' ),
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
		__( 'SV Forms Hidden', 'sv_forms' ),
		__( 'Hidden Input', 'sv_forms' ),
		__( 'Hidden', 'sv_forms' ),
	],
	attributes: {
		inputId: {
			type: 'string',
		},

		// Input Settings
		defaultValue: {
			type: 'string',
		},
		name: {
			type: 'string',
		},
		type: {
			type: 'string',
			default: 'hidden',
		},

		// Advanced Settings
		className: {
			type: 'string',
		},
	},
	edit,
	save: () => {
		return null;
	}
} );