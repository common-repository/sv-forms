// Required Components
const { __ } = wp.i18n;
const { PanelColorSettings } = wp.blockEditor;

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: { placeholderColor }
    } = props;

    // Functions to set the block attributes
    const setPlaceholderColor = placeholderColor => setAttributes({ placeholderColor });
    
    // Color Settings
    let colorSettings = [
        {
            value: placeholderColor,
            onChange: value => setPlaceholderColor( value ),
            label: __( 'Input Placeholder Color', 'sv_forms' ),
        },
    ];

    return(
        <PanelColorSettings
            title={ __( 'Color Settings', 'sv_forms' ) }
            initialOpen={ true }
            colorSettings={ colorSettings }
        >
        </PanelColorSettings>
    );
}