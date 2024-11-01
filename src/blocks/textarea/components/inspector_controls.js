// Required Components
import TextareaSettings from './inspector_controls/textarea_settings';
import LabelSettings from './inspector_controls/label_settings';
import ColorSettings from './inspector_controls/color_settings';
import BorderSettings from './inspector_controls/border_settings';
import ValidationSettings from './inspector_controls/validation_setting';
import AdvancedSettings from './inspector_controls/advanced_settings';

const { Fragment } = wp.element;
const { InspectorControls, InspectorAdvancedControls } = wp.blockEditor;

export default ( { props, wrapper, inputs } ) => {
    if ( ! props || ! wrapper || ! inputs ) return '';

    return(
        <Fragment>
            <InspectorControls>
                <TextareaSettings props={ props } wrapper={ wrapper } inputs={ inputs } />
                <LabelSettings props={ props } />
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