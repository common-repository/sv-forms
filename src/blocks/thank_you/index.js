// Required Components
import './editor.scss';
import icon from './icons/block';
import edit from './edit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks
const { InnerBlocks } = wp.blockEditor;

registerBlockType( 'straightvisions/sv-forms-thank-you', {
	title: __( 'Thank You Message', 'sv_forms' ),
	description: __( 'This message will be shown to users, who submitted this form.', 'sv_forms' ),
	icon,
	parent: ['straightvisions/sv-forms'],
	category: 'straightvisions',
	keywords: [
		__( 'SV Forms Thank You', 'sv_forms' ),
		__( 'Thank You Message', 'sv_forms' ),
		__( 'Thank You Page', 'sv_forms' ),
	],
	supports: {
		align:[ 'wide', 'full' ],
	},
	attributes: {
		collapsed: {
			type: 'boolean',
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