// Constant available for all blocks
const WrapperContext = wp.element.createContext({});
export const WrapperConsumer = WrapperContext.Consumer;
export const WrapperProvider = WrapperContext.Provider;

const InputsContext = wp.element.createContext([]);
export const InputsConsumer = InputsContext.Consumer;
export const InputsProvider = InputsContext.Provider;

// Wrapper Blocks
import './blocks/wrapper/index.js';
import './blocks/form/index.js';
import './blocks/thank_you/index.js';
import './blocks/user_mail/index.js';
import './blocks/admin_mail/index.js';

// Form Blocks
import './blocks/spam_guard/index.js';
import './blocks/text/index.js';
import './blocks/email/index.js';
import './blocks/url/index.js';
import './blocks/number/index.js';
import './blocks/phone/index.js';
import './blocks/textarea/index.js';
import './blocks/checkbox/index.js';
import './blocks/radio/index.js';
import './blocks/select/index.js';
import './blocks/submit/index.js';
import './blocks/password/index.js';
import './blocks/date/index.js';
import './blocks/range/index.js';
import './blocks/file/index.js';
import './blocks/hidden/index.js';