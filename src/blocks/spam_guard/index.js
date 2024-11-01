// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } 				= wp.i18n;
const { registerBlockType } = wp.blocks

registerBlockType( 'straightvisions/sv-forms-spam-guard', {
	title: __( 'Spam Guard', 'sv_forms' ),
	description: __( 'Provides features to prevent spam in your form.', 'sv_forms' ),
	icon,
	parent: ['straightvisions/sv-forms-form'],
	category: 'straightvisions',
	keywords: [
		__( 'SV Forms Spam Guard', 'sv_forms' ),
		__( 'Spam Guard', 'sv_forms' ),
		__( 'Anti Spam', 'sv_forms' ),
	],
	attributes: {
		// Honeypot Settings
		honeypot: {
			type: 'boolean',
			default: true,
		},

		// Time Trap Settings
		timeTrap: {
			type: 'boolean',
			default: true,
		},
		timeTrapWindow: {
			type: 'number',
			default: 5,
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