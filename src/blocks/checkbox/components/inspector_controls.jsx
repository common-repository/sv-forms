// Required Components
import InputSettings from './inspector_controls/input_settings.jsx';
import ValidationSettings from './inspector_controls/validation_setting.jsx';
import AdvancedSettings from './inspector_controls/advanced_settings.jsx';
import ColorSettings from './inspector_controls/color_settings.jsx';
import BorderSettings from './inspector_controls/border_settings.jsx';

const { Fragment } = wp.element;
const { InspectorControls, InspectorAdvancedControls } = wp.blockEditor;

export default ( { props, wrapper, inputs } ) => {
    if ( ! props || ! wrapper || ! inputs ) return '';

    return(
        <Fragment>
            <InspectorControls>
                <InputSettings props={ props } wrapper={ wrapper } inputs={ inputs } />
                <ColorSettings props={ props } />
                <BorderSettings props={ props } />
                <ValidationSettings props={ props } />
            </InspectorControls>
            <InspectorAdvancedControls>
                <AdvancedSettings props={ props } />
            </InspectorAdvancedControls>
        </Fragment>
    );
}