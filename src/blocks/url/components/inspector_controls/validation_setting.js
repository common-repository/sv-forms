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
            minlength,
            maxlength,
        }
    } = props;

    // Returns a notice when the input name is already in use
    const setRequired   = required  => setAttributes({ required });
    const setMinLength  = minlength => setAttributes({ minlength });
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
                label={ __( 'Min. Length', 'sv_forms' ) }
                help={ __( 'Defines the min. character length.', 'sv_forms' ) }
                value={ minlength }
                onChange={ value =>  { 
                    value = ! value ? 0 : value;
                    setMinLength( value ); 
                } }
                allowReset
                min={ 0 }
                max={ 100 }
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
                max={ 100 }
            />
        </PanelBody>
    );
}