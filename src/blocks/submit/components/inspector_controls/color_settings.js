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
            textColor,
            backgroundColor,
            borderColor,
        }
    } = props;

    // Functions to set the block attributes
    const setTextColor              = textColor             => setAttributes({ textColor });
    const setTextColorClass         = textColorClass        => setAttributes({ textColorClass });
    const setBackgroundColor        = backgroundColor       => setAttributes({ backgroundColor });
    const setBackgroundColorClass   = backgroundColorClass  => setAttributes({ backgroundColorClass });
    const setBorderColor            = borderColor           => setAttributes({ borderColor });
    
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
            value: textColor,
            onChange: value => { 
                setTextColor( value );
                setTextColorClass( getColorClass( value ) );
            },
            label: __( 'Text', 'sv_forms' ),
        },
        {
            value: backgroundColor,
            onChange: value => { 
                setBackgroundColor( value );
                setBackgroundColorClass( getColorClass( value, true ) );
            },
            label: __( 'Background', 'sv_forms' ),
        },
        {
            value: borderColor,
            onChange: value => setBorderColor( value ),
            label: __( 'Border', 'sv_forms' ),
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