// Required Components
const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { ToggleControl } = wp.components;

export default ( { props } ) => {
    if ( ! props ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: {
            autofocus,
            readonly,
            disabled,
        }
    } = props;

    // Functions to set the block attributes
    const setAutofocus  = autofocus => setAttributes({ autofocus });
    const setReadonly   = readonly  => setAttributes({ readonly });
    const setDisabled   = disabled  => setAttributes({ disabled });

    return(
        <Fragment>
            <ToggleControl
                label={ __( 'Autofocus', 'sv_forms' ) }
                checked={ autofocus }
                onChange={ () => setAutofocus( ! autofocus )  }
            />
            <ToggleControl
                label={ __( 'Read Only', 'sv_forms' ) }
                checked={ readonly }
                onChange={ () => setReadonly( ! readonly )  }
            />
            <ToggleControl
                label={ __( 'Disabled', 'sv_forms' ) }
                checked={ disabled }
                onChange={ () => setDisabled( ! disabled )  }
            />
        </Fragment>
    );
}