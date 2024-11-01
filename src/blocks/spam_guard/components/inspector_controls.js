// Required Components
import TimeTrapSettings from './inspector_controls/timetrap_settings';

const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;

export default ( { props, wrapper } ) => {
    if ( ! props || ! wrapper ) return '';

    return(
        <Fragment>
            <InspectorControls>
                <TimeTrapSettings props={ props } wrapper={ wrapper } />
            </InspectorControls>
        </Fragment>
    );
}