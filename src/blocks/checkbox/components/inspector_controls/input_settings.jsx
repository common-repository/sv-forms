// Required Components
const { __ } = wp.i18n;
const { PanelBody, TextControl, Notice } = wp.components;
const { updateBlockAttributes } = wp.data.dispatch('core/block-editor');

export default ( { props, wrapper, inputs } ) => {
    if ( ! props || ! wrapper || ! inputs ) return '';

    // Block Attributes
    const { 
        setAttributes,
        attributes: {
            inputId,
            label,
            name,
            type,
            value,
        }
    } = props;

    // Functions to set the block attributes
    const setLabel  = label => {
    	if(name === '' || typeof name === 'undefined'){
		    setAttributes({ label, name: getFormatedName(label)});
	    }else{
		    setAttributes({ label });
	    }
    	
    };
    const setName   = name  => {
    	if(name === '' || typeof name === 'undefined'){
		    if(label === '' || typeof label === 'undefined'){
			    setAttributes({ name: __('unknown', 'sv_forms') })
		    }else{
			    setAttributes({ name: getFormatedName(label)});
		    }
	    }else{
		    setAttributes({ name })
	    }
    };
    const setValue  = value => setAttributes({ value });

    // Returns the input name in a valid format
    const getFormatedName = name => {
        if ( ! name ) return '';

        return name.replace( /[^A-Z0-9]+/ig, '-' );
    };

    // Returns a notice when the input name is already in use
    const NameCheckTest = (input) =>{
        return input.name === name && input.ID !== inputId;
    };
    
    const NameCheck = () => {
        let output = null;

        inputs.map( input => {
            if ( NameCheckTest(input) ) {
                output = 
                    <Notice 
                        status='warning' 
                        className='sv-forms-name-check'
                        isDismissible={ false }
                    >
                        { __( 'This input name is already in use!', 'sv_forms' ) }
                    </Notice>;
            }
        } );

        return output;
    };

    const updateFormInputs = newName => {
        let newInputs   = inputs;
        const newInput  = { ID: inputId, name: newName, type: type };

        if ( inputId ) {
            const existingInput = newInputs.find( input => {
                return input.ID === inputId;
            } );
    
            if ( existingInput ) {
                const inputIndex = newInputs.indexOf( existingInput );
    
                newInputs[ inputIndex ] = newInput;
            } else {
                newInputs.push( newInput );
            }
    
            updateBlockAttributes( wrapper.clientId, { formInputs: JSON.stringify( newInputs ) } );
        }

        updateChilds();
    };

    const updateChilds = () => {
        const childBlocks = [
            'straightvisions/sv-forms-thank-you',
            'straightvisions/sv-forms-user-mail',
            'straightvisions/sv-forms-admin-mail',
        ];

        const innerBlocks = wp.data.select('core/block-editor').getBlocks( wrapper.clientId );

        innerBlocks.map( block => {
            if ( childBlocks.includes( block.name ) ) {
                wp.data.dispatch('core/block-editor').updateBlock( block.clientId, { attributes: block.attributes } );
            }
        } );
    };

    return(
        <PanelBody
            title={ __( 'Input Settings', 'sv_forms' ) }
            initialOpen={ true }
        >
            <TextControl
                label={ __( 'Label', 'sv_forms' ) }
                value={ label }
                onChange={ value => setLabel( value ) }
            />
            <TextControl
                label={ __( 'Name', 'sv_forms' ) }
                value={ getFormatedName( name ) }
                onChange={ value => { 
                    updateFormInputs( getFormatedName( value ) );
                    setName( getFormatedName( value ) );
                }}
            />
            <NameCheck />
            <TextControl
                label={ __( 'Value', 'sv_forms' ) }
                value={ value }
                onChange={ value => setValue( value ) }
            />
        </PanelBody>
    );
}