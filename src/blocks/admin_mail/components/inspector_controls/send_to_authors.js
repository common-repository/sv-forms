// Required Components
const { __ } = wp.i18n;
const {
    PanelBody,
    Button,
    SelectControl,
} = wp.components;

export default ( { props, authors } ) => {
    if ( ! props || ! authors ) return '';

    // Wrapper Properties
    const {
        setAttributes,
        attributes: {
            mailToUsers,
        }
    } = props;

    // Variables
    const users = mailToUsers ? JSON.parse( mailToUsers ) : [];

    // Returns an array with authors options for the SelectControl
    const getAuthorOptions = () => {
        let options = [];

        authors.map( author => {
            options.push( { label: author.name, value: author.id } );
        } );

        return options;
    };

    // Updates the users list
    const updateUsers = user => {
        let newUsers = users;
        const index = newUsers.indexOf( user[0] );

        if ( index >= 0 ) {
            newUsers.splice( index, 1 );
        } else {
            newUsers.push( user[0] );
        }

        setAttributes({ mailToUsers: JSON.stringify( newUsers ) });
    };

    // Resets the users list
    const resetSelection = () => {
        setAttributes({ mailToUsers: JSON.stringify( [] ) });
    };

    return(
        <PanelBody
            title={ __( 'Send to Authors', 'sv_forms' ) }
            initialOpen={ true }
        >
            <div className='sv-forms-users-list'>
                <SelectControl
                    className='sv-forms-users-select'
                    multiple
                    label={ __( 'Select User:',  'sv_forms' ) }
                    value={ users }
                    onChange={ users => updateUsers( users ) }
                    options={ getAuthorOptions() }
                />
                <Button 
                    className='sv-forms-users-reset'
                    onClick={ () => resetSelection() }
                >
                    { __( 'Reset Selection', 'sv_forms' ) }
                </Button>
            </div>
        </PanelBody>
    );
}