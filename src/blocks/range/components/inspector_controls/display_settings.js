// Required Components
const { __ } = wp.i18n;
const {
    PanelBody,
    ToggleControl,
} = wp.components;

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: {
            showValue,
            showMin,
            showMax,
        },
    } = props;

    // Functions to set the block attributes
    const setShowValue  = showValue => setAttributes({ showValue });
    const setShowMin    = showMin   => setAttributes({ showMin });
    const setShowMax    = showMax   => setAttributes({ showMax });

    return(
        <PanelBody
            title={ __( 'Display Settings', 'sv_forms' ) }
            initialOpen={ false }
        >
            <ToggleControl
                label={ __( 'Show Value', 'sv_forms' ) }
                checked={ showValue }
                onChange={ () => setShowValue( ! showValue )  }
            />
            <ToggleControl
                label={ __( 'Show Min', 'sv_forms' ) }
                checked={ showMin }
                onChange={ () => setShowMin( ! showMin )  }
            />
            <ToggleControl
                label={ __( 'Show Max', 'sv_forms' ) }
                checked={ showMax }
                onChange={ () => setShowMax( ! showMax )  }
            />
        </PanelBody>
    );
}