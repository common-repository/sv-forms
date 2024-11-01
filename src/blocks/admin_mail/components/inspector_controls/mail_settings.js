// Required Components
const { __ } = wp.i18n;
const {
    PanelBody,
    ToggleControl,
    TextControl
} = wp.components;

export default ( { props, wrapper, inputs } ) => {
    if ( ! props || ! wrapper || ! inputs ) return '';

    // Wrapper Properties
    const {
        setAttributes,
        attributes: {
            mailSend,
            mailSubject,
            mailFromTitle,
            mailFromMail,
        }
    } = props;

    // Functions to the block attributes
    const setMailSend      = mailSend         => setAttributes({ mailSend });
    const setMailSubject   = mailSubject      => setAttributes({ mailSubject });
    const setMailFromTitle = mailFromTitle    => setAttributes({ mailFromTitle });
    const setMailFromMail  = mailFromMail     => setAttributes({ mailFromMail });

    return(
        <PanelBody
            title={ __( 'Mail Settings', 'sv_forms' ) }
            initialOpen={ true }
        >
            <ToggleControl
                label={ __( 'Send Mail', 'sv_forms' ) }
                checked={ mailSend }
                onChange={ () => setMailSend( ! mailSend ) }
            />
            <TextControl
                label={ __( 'Mail Subject', 'sv_forms' ) }
                value={ mailSubject }
                onChange={ value => setMailSubject( value ) }
            />
            <TextControl
                label={ __( 'Mail From - Title', 'sv_forms' ) }
                value={ mailFromTitle }
                onChange={ value => setMailFromTitle( value ) }
            />
            <TextControl
                label={ __( 'Mail From - E-Mail', 'sv_forms' ) }
                value={ mailFromMail }
                onChange={ value => setMailFromMail( value ) }
            />
        </PanelBody>
    );
}