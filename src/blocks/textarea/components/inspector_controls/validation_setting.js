// Required Components
const { __ } = wp.i18n;
const {
    PanelBody,
    RangeControl,
    ToggleControl,
} = wp.components;

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: {
            required,
            maxlength,
        }
    } = props;

    // Functions to set the block attributes
    const setRequired   = required  => setAttributes({ required });
    const setMaxLength  = maxlength => setAttributes({ maxlength });

    return(
        <PanelBody
            title={ __( 'Validation Settings', 'sv_forms' ) }
            initialOpen={ false }
        >
            <ToggleControl
                label={ __( 'Required', 'sv_forms' ) }
                checked={ required }
                onChange={ () => setRequired( ! required )  }
            />
            <RangeControl
                label={ __( 'Max. Length', 'sv_forms' ) }
                help={ __( 'Defines the max. character length.', 'sv_forms' ) }
                value={ maxlength }
                onChange={ value => { 
                    value = ! value ? 0 : value; 
                    setMaxLength( value );
                }}
                allowReset
                min={ 0 }
                max={ 2000 }
            />
        </PanelBody>
    );
}