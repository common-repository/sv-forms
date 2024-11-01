// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } = wp.i18n;
const { InnerBlocks } = wp.blockEditor;
const { registerBlockType } = wp.blocks

registerBlockType( 'straightvisions/sv-forms-form', {
	title: __( 'Form', 'sv_forms' ),
	description: __( 'This block holds the form itself.', 'sv_forms' ),
	icon,
	parent: ['straightvisions/sv-forms'],
	category: 'straightvisions',
	keywords: [
		__( 'SV Forms Form', 'sv_forms' ),
		__( 'Form Block', 'sv_forms' ),
		__( 'Contact Form', 'sv_forms' ),
	],
	supports: {
		align:[ 'wide', 'full' ],
	},
	attributes: {
		formId: {
			type: 'string',
		},
		collapsed: {
			type: 'boolean',
			default: false,
		},
		placeholderColor: {
			type: 'string',
			default: '#808080',
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