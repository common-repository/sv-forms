// Required Components
import InputSettings from './inspector_controls/input_settings';
import ValidationSettings from './inspector_controls/validation_settings';
import DisplaySettings from './inspector_controls/display_settings';
import ColorSettings from './inspector_controls/color_settings';
import AdvancedSettings from './inspector_controls/advanced_settings';

const { Fragment } = wp.element;
const { InspectorControls, InspectorAdvancedControls } = wp.blockEditor;

export default ( { props, wrapper, inputs } ) => {
    if ( ! props || ! wrapper || ! inputs ) return '';

    return(
        <Fragment>
            <InspectorControls>
                <InputSettings props={ props } wrapper={ wrapper } inputs={ inputs } />
                <DisplaySettings props={ props } />
                <ValidationSettings props={ props } />
                <ColorSettings props={ props } />
            </InspectorControls>
            <InspectorAdvancedControls>
                <AdvancedSettings props={ props } />
            </InspectorAdvancedControls>
        </Fragment>
    );
}