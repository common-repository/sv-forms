// Required Components
const { __ } = wp.i18n;
const {
    PanelBody,
    Button,
    SelectControl,
} = wp.components;
const { getBlocks } = wp.data.select('core/block-editor');

export default ( { props, wrapper, inputs } ) => {
    if ( ! props || ! wrapper || ! inputs ) return '';

    // Wrapper Properties
    const {
        setAttributes,
        attributes: { mailToMails }
    } = props;

    // Variables
    const mails = mailToMails ? JSON.parse( mailToMails ) : [];

    // Returns the E-Mail Block Label if available
    const getMailLabel = ID => {
        const wrapperBlocks = getBlocks( wrapper.clientId );
        const formBlock = wrapperBlocks.find( block => { return block.name === 'straightvisions/sv-forms-form'; } );
        const formBlocks = getBlocks( formBlock.clientId );
        let label = 'Default Mail Label';

        formBlocks.map( block => {
            if ( block.attributes.inputId && block.attributes.inputId === ID ) {
                label = block.attributes.label ? block.attributes.label : block.attributes.name;
            }
        } );

        return label;
    }

    // Returns an array with email block options for the SelectControl
    const getMailOptions = () => {
        let options = [];

        inputs.map( input => {
            if ( input.type === 'email' ) {
                const label = getMailLabel( input.ID );

                options.push( { label: label, value: input.name } );
            }
        } );

        return options;
    };

    // Updates the mailToMails list
    const updateMails = mail => {
        let newMails = mails;
        const index = newMails.indexOf( mail[0] );

        if ( index >= 0 ) {
            newMails.splice( index, 1 );
        } else {
            newMails.push( mail[0] );
        }

        setAttributes({ mailToMails: JSON.stringify( newMails ) });
    }

     // Resets the mailToMails list
     const resetSelection = () => {
        setAttributes({ mailToMails: JSON.stringify( [] ) });
    }

    return(
        <PanelBody
            title={ __( 'Send to Mails', 'sv_forms' ) }
            initialOpen={ true }
        >
            <div className='sv-forms-mails-list'>
                <SelectControl
                    className='sv-forms-mails-select'
                    multiple
                    label={ __( 'Select E-Mail Blocks:',  'sv_forms' ) }
                    value={ mails }
                    onChange={ mails => updateMails( mails ) }
                    options={ getMailOptions() }
                />
                <Button 
                    className='sv-forms-mails-reset'
                    onClick={ () => resetSelection() }
                >
                    { __( 'Reset Selection', 'sv_forms' ) }
                </Button>
            </div>
        </PanelBody>
    );
}