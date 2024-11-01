// Required Components
import ColorSettings from './inspector_controls/color_settings';
import BorderSettings from './inspector_controls/border_settings';

const { InspectorControls } = wp.blockEditor;

export default ( { props } ) => {
    if ( ! props ) return '';

    return(
        <InspectorControls>
            <ColorSettings props={ props } />
            <BorderSettings props={ props } />
        </InspectorControls>
    );
}