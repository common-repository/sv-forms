// Required Components
const { __ } = wp.i18n;
const { 
    PanelColorSettings, 
    getColorObjectByColorValue, 
    getColorClassName  
} = wp.blockEditor;

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: {
            labelColor,
        }
    } = props;

    // Functions to set the block attributes
    const setLabelColor         = labelColor        => setAttributes({ labelColor });
    const setLabelColorClass    = labelColorClass   => setAttributes({ labelColorClass });
    
    // Returns an color object if this color is defined in the editor
    const getColorObject = color => {
        const settings      = wp.data.select( 'core/editor' ).getEditorSettings();
        const colorObject   = getColorObjectByColorValue( settings.colors, color );

        return colorObject;
    };

    // Returns the classname of the given color, if it's defined in the editor
    const getColorClass = ( color, isBackgroundColor = false ) => {
        if ( ! color ) return '';
        if ( ! getColorObject( color ) ) return '';

        const type = isBackgroundColor ? 'background-color' : 'color';

        return getColorClassName( type, getColorObject( color ).slug );
    };
    
    // Color Settings
    let colorSettings = [
        {
            value: labelColor,
            onChange: value => { 
                setLabelColor( value );
                setLabelColorClass( getColorClass( value ) );
            },
            label: __( 'Label', 'sv_forms' ),
        },
    ];

    return(
        <PanelColorSettings
            title={ __( 'Color Settings', 'sv_forms' ) }
            initialOpen={ false }
            colorSettings={ colorSettings }
        >
        </PanelColorSettings>
    );
}