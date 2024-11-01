// Required Components
const { __ } = wp.i18n;
const { 
    RangeControl,
    SelectControl,
    PanelBody 
} = wp.components;

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: { 
            borderStyle,
            borderWidthTop,
            borderWidthRight,
            borderWidthBottom,
            borderWidthLeft,
            borderRadius,
        }
    } = props;

    // Functions to set the block attributes
    const setBorderStyle        = borderStyle       => setAttributes({ borderStyle });
    const setBorderWidthTop     = borderWidthTop    => setAttributes({ borderWidthTop });
    const setBorderWidthRight   = borderWidthRight  => setAttributes({ borderWidthRight });
    const setBorderWidthBottom  = borderWidthBottom => setAttributes({ borderWidthBottom });
    const setBorderWidthLeft    = borderWidthLeft   => setAttributes({ borderWidthLeft });
    const setBorderRadius       = borderRadius      => setAttributes({ borderRadius });

    // Border Width All
    let borderWidth = 0;

    if ( 
        borderWidthTop === borderWidthRight 
        && borderWidthRight === borderWidthBottom 
        && borderWidthBottom === borderWidthLeft
    ) {
        borderWidth = Number.isInteger( borderWidthTop ) && borderWidthTop > -1 ? borderWidthTop : 0;
    }

    return(
        <PanelBody
            title={ __( 'Border Settings', 'sv_forms' ) }
            initialOpen={ false }
        >
            <SelectControl 
                label={ __( 'Border Style', 'sv_forms' ) }
                value={ borderStyle }
                options={ [
                    { label: __( 'Solid', 'sv_forms' ), value: 'solid' },
                    { label: __( 'Dotted', 'sv_forms' ), value: 'dotted' },
                    { label: __( 'Dashed', 'sv_forms' ), value: 'dashed' },
                    { label: __( 'Double', 'sv_forms' ), value: 'double' },
                    { label: __( 'Groove', 'sv_forms' ), value: 'groove' },
                    { label: __( 'Ridge', 'sv_forms' ), value: 'ridge' },
                    { label: __( 'Inset', 'sv_forms' ), value: 'inset' },
                    { label: __( 'Outset', 'sv_forms' ), value: 'outset' },
                    { label: __( 'Hidden', 'sv_forms' ), value: 'hidden' },
                    { label: __( 'None', 'sv_forms' ), value: 'none' },
                ] }
                onChange={ value => setAttributes( { borderStyle: value } ) }
            />
            {
                borderStyle !== 'none' ? [
                    <RangeControl
                        label={ __( 'Border Width', 'sv_forms' ) }
                        value={ borderWidth }
                        onChange={ value => {
                            setBorderWidthTop( value );
                            setBorderWidthRight( value );
                            setBorderWidthBottom( value );
                            setBorderWidthLeft( value );
                        }}
                        allowReset
                        min={ 0 }
                        max={ 10 }
                    />,
                    <RangeControl
                        label={ __( 'Border Radius', 'sv_forms' ) }
                        value={ borderRadius }
                        onChange={ value => {
                            value = ! value ? 0 : value;
                            setBorderRadius( value );
                        }}
                        allowReset
                        min={ 0 }
                        max={ 50 }
                    />
                ] : null
            }
        </PanelBody>
    );
}