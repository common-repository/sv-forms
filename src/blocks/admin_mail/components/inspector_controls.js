// Required Components
import MailSettings from './inspector_controls/mail_settings';
import SendToAuthors from './inspector_controls/send_to_authors';
import SendToMails from './inspector_controls/send_to_mails';

const { InspectorControls } = wp.blockEditor;

export default ( { props, authors, wrapper, inputs } ) => {
    // if ( ! props || ! authors || ! wrapper || ! inputs ) return '';

    return(
        <InspectorControls>
            <MailSettings props={ props } wrapper={ wrapper } inputs={ inputs } />
            <SendToAuthors props={ props } authors={ authors } />
            <SendToMails props={ props } authors={ authors } />
        </InspectorControls>
    );
}