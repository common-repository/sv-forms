// Required Components
import InspectorControls from './components/inspector_controls';

const { withSelect }    = wp.data;
const { Fragment }      = wp.element;
const { RichText }      = wp.blockEditor;

export default withSelect( ( select, props ) => {
    return props;
} )( ( props ) => {
    // Block Properties
    const {
        className,
        setAttributes,
        attributes: {
            // Content
            content,

            // Color Settings
            textColor,
            textColorClass,
            backgroundColor,
            backgroundColorClass,
            borderColor,

            // Border Settings
            borderStyle,
            borderWidthTop,
            borderWidthRight,
            borderWidthBottom,
            borderWidthLeft,
            borderRadius,
        } 
    } = props;

    const style = {
        color:              textColor,
        backgroundColor:    backgroundColor,
        borderColor:        borderColor,
        borderStyle:        borderStyle,
        borderTopWidth:     borderWidthTop,
        borderRightWidth:   borderWidthRight,
        borderBottomWidth:  borderWidthBottom,
        borderLeftWidth:    borderWidthLeft,
        borderRadius:       borderRadius,
    };

    // Returns a string in a slug compatible format
    const setContent = content => setAttributes({ content });

    return (
        <Fragment>
            <InspectorControls props={ props } />
            <div className={ className }>
                <RichText
                    className={ [ textColorClass, backgroundColorClass ] }
                    style={ style }
                    value={ content }
                    onChange={ value => setContent( value ) } 
                />
            </div>
        </Fragment>
    ); 
});