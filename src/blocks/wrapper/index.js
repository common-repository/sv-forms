// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } = wp.i18n;
const { InnerBlocks } = wp.blockEditor;
const { registerBlockType } = wp.blocks

registerBlockType( 'straightvisions/sv-forms', {
	title: __( 'SV Forms', 'sv_forms' ),
	description: __( 'Create a form.', 'sv_forms' ),
	icon,
	category: 'straightvisions',
	keywords: [
		__( 'SV Forms', 'sv_forms' ),
		__( 'Form', 'sv_forms' ),
		__( 'Contact Form', 'sv_forms' ),
	],
	supports: {
		align:[ 'wide', 'full' ],
	},
	example: {
		attributes: {
			formId: 'a0bc1def-2345-6789-0g1h-2345i67890j1',
			formLabel: __( 'Contact Form', 'sv_forms' ),
			collapsed: true,
		}
	},
	attributes: {
		postId: {
			type: 'number',
		},
		formId: {
			type: 'string',
		},
		formLabel: {
			type: 'string',
			default: __( 'Contact Form', 'sv_forms' )
		},
		saveSubmissions: {
			type: 'boolean',
			default: true,
		},
		formInputs: {
			type: 'string',
		},
		collapsed: {
			type: 'boolean',
		},

		// Admin Mail Block
		adminMailSend: {
			type: 'boolean',
		},
		adminMailSubject: {
			type: 'string',
		},
		adminMailFromTitle: {
			type: 'string',
		},
		adminMailFromMail: {
			type: 'string',
		},
		adminMailToUsers: {
			type: 'string',
		},
		adminMailToMails: {
			type: 'string',
		},
		adminMailContent: {
			type: 'string',
		},

		// User Mail Block
		userMailSend: {
			type: 'boolean',
		},
		userMailSubject: {
			type: 'string',
		},
		userMailFromTitle: {
			type: 'string',
		},
		userMailFromMail: {
			type: 'string',
		},
		userMailToMails: {
			type: 'string',
		},
		userMailContent: {
			type: 'string',
		},

		// Spam Guard Block
		sgHoneypot: {
			type: 'boolean',
		},
		sgTimeTrap: {
			type: 'boolean',
		},
		sgTimeTrapWindow: {
			type: 'number',
			default: 5,
		},

		// Advanced
		className: {
			type: 'string',
		},
	},
	edit,
	save: () => {
		return <InnerBlocks.Content />;
	},
} );