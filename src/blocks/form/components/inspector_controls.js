// Required Components
import InputSettings from './inspector_controls/input_settings';

const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;

export default ( { props } ) => {
    if ( ! props ) return '';

    return(
        <Fragment>
            <InspectorControls>
                <InputSettings props={ props } />
            </InspectorControls>
        </Fragment>
    );
}