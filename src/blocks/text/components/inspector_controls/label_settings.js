// Required Components
const { __ } = wp.i18n;
const { 
    PanelBody,
    TextControl, 
    FontSizePicker 
} = wp.components;
const { fontSizes } = wp.data.select('core/block-editor').getSettings();

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: {
            label,
            labelFontSize,
        }
    } = props;

    // Functions to set the block attributes
    const setLabel          = label         => setAttributes({ label });
    const setLabelFontSize  = labelFontSize => setAttributes({ labelFontSize });

    return(
        <PanelBody
            title={ __( 'Label Settings', 'sv_forms' ) }
            initialOpen={ false }
        >
            <TextControl
                label={ __( 'Label', 'sv_forms' ) }
                value={ label }
                onChange={ value => setLabel( value ) }
            />
            <FontSizePicker
                fontSizes={ fontSizes }
                value={ labelFontSize }
                onChange={ newFontSize => setLabelFontSize( newFontSize ) }
            />
        </PanelBody>
    );
}