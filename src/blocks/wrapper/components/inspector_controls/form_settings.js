// Required Components
const { __ } = wp.i18n;
const { 
    PanelBody,
    TextControl,
    ToggleControl,
    Button,
} = wp.components;
const { select, dispatch } = wp.data;
const { editPost } = dispatch( 'core/editor' );
const { getEditedPostAttribute } = select( 'core/editor' );

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Properties
    const { 
        setAttributes,
        attributes: {
            formLabel,
            saveSubmissions,
        },
    } = props;

    // Functions to set the block attributes
    const setFormLabel          = formLabel         => setAttributes({ formLabel });
    const setSaveSubmissions    = saveSubmissions   => setAttributes({ saveSubmissions });
    const clearMeta             = ()                => {
        const currentMeta       = getEditedPostAttribute( 'meta' );
        const newMeta           = { ...currentMeta, _sv_forms_forms: "{}" };

        editPost( { meta: newMeta } );
        
    };

    return(
        <PanelBody 
            title={ __( 'Form Settings', 'sv_forms' ) }
            initialOpen={ true }
        >
            <TextControl
                label={ __( 'Form Label', 'sv_forms' ) }
                type='text'
                value={ formLabel }
                onChange={ value => setFormLabel( value ) }
            />
            <ToggleControl
                label={ __( 'Save Submissions', 'sv_forms' ) }
                checked={ saveSubmissions }
                onChange={ () => setSaveSubmissions( ! saveSubmissions )  }
            />
            <Button 
                isSecondary
                onClick={ () => clearMeta() }
            >
                {__( 'Clear SV Forms Meta Field', 'sv_forms' )}
            </Button>
        </PanelBody>
    );
}