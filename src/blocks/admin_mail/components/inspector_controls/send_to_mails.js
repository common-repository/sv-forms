// Required Components
const { __ } = wp.i18n;
const {
    PanelBody,
    Button,
    TextControl,
} = wp.components;

export default ( { props } ) => {
    if ( ! props ) return '';

    // Wrapper Properties
    const {
        setAttributes,
        attributes: {
            mailToMails,
        }
    } = props;

    // Variables
    const mails = mailToMails ? JSON.parse( mailToMails ) : [];

    // Adds a new text input to the mail list, to add a new mail to the list
    const addMail = () => {
        let newMails = mails;

        if ( newMails.indexOf( 'new' ) < 0 ) {
            newMails.push( 'new' );

            setAttributes({ mailToMails: JSON.stringify( newMails ) });
        }
    }

    // Removes a mail from the mails list
    const removeMail = mail => {
        let newMails = mails;
        const index = newMails.indexOf( mail );

        newMails.splice( index, 1 );

        setAttributes({ mailToMails: JSON.stringify( newMails ) });
    }

    // Updates an existing mail in the mails list
    const updateMail = ( oldMail, newMail ) => {
        let newMails = mails;
        const index = newMails.indexOf( oldMail );

        newMails[ index ] = newMail;

        setAttributes({ mailToMails: JSON.stringify( newMails ) });
    }

    return(
        <PanelBody
            title={ __( 'Send to Mails', 'sv_forms' ) }
            initialOpen={ true }
        >
            <div className='sv-forms-mail-list'>
                <Button 
                    className='sv-forms-mail-add'
                    onClick={ () => addMail() }
                >
                    { __( 'Add E-Mail', 'sv_forms' ) }
                </Button>
                {
                    mails.map( mail => {
                        return(
                            <div className='sv-forms-mail-entry'>
                                <TextControl
                                    className='sv-forms-mail-input'
                                    type='text'
                                    placeholder={ __( 'E-Mail', 'sv_forms' ) }
                                    value={ mail === 'new' ? '' : mail }
                                    onChange={ value => updateMail( mail, value ) }
                                />
                                <Button 
                                    label={ __( 'Delete E-Mail', 'sv_forms' ) }
                                    className='sv-forms-mail-remove'
                                    icon='no-alt'
                                    onClick={ () => removeMail( mail ) }
                                ></Button>
                            </div>
                        );
                    } )
                }
            </div>
        </PanelBody>
    );
}