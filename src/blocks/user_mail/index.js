// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } 				= wp.i18n;
const { registerBlockType } = wp.blocks
const { InnerBlocks } 		= wp.blockEditor;

registerBlockType( 'straightvisions/sv-forms-user-mail', {
	title: __( 'User Mail', 'sv_forms' ),
	description: __( 'Create a mail that the user will recieve, when submitting the form.', 'sv_forms' ),
	icon,
	parent: ['straightvisions/sv-forms'],
	category: 'straightvisions',
	keywords: [
		__( 'SV Forms User Mail', 'sv_forms' ),
		__( 'User Mail', 'sv_forms' ),
		__( 'User Mail', 'sv_forms' ),
	],
	supports: {
		align:[ 'wide', 'full' ],
	},
	attributes: {
		collapsed: {
			type: 'boolean',
		},

		// Mail Settings
		mailSend: {
			type: 'boolean',
			default: false,
		},
		mailSubject: {
			type: 'string',
			default: '',
		},
		mailFromTitle: {
			type: 'string',
			default: '',
		},
		mailFromMail: {
			type: 'string',
			default: '',
		},

		// Send to Mails
		mailToMails: {
			type: 'string',
			default: '',
		},

		// Advanced Settings
		className: {
			type: 'string',
		},
	},
	edit,
	save: () => {
		return <InnerBlocks.Content />;
	},
} );