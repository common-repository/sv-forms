// Required Components
const { __ } = wp.i18n;
const { PanelBody, RangeControl } = wp.components;

export default ( { props, wrapper } ) => {
    if ( ! props || ! wrapper ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: {
            timeTrapWindow,
        }
    } = props;

    // Functions to set the block attributes
    const setTimeTrapWindow = timeTrapWindow => { 
        setAttributes({ timeTrapWindow } );
        wrapper.setAttributes({ sgTimeTrapWindow: timeTrapWindow }); 
    };

    return(
        <PanelBody
            title={ __( 'Time Trap Settings', 'sv_forms' ) }
            initialOpen={ true }
        >
            <RangeControl
                label={ __( 'Time Window', 'sv_forms' ) }
                help={ __( 'The amount of seconds that has to passs after page load, before the form will accept submissions.', 'sv_forms' ) }
                value={ timeTrapWindow }
                onChange={ value => setTimeTrapWindow( value ) }
                min="1"
                max="30"
            />
        </PanelBody>
    );
}