// Required Components
import FormSettings from './inspector_controls/form_settings';

const { InspectorControls } = wp.blockEditor;

export default ( { props } ) => {
    if ( ! props ) return '';

    return(
        <InspectorControls>
            <FormSettings props={ props } />
        </InspectorControls>
    );
}