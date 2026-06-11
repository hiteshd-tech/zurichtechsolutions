/*
 * helper function to delay after a promise
 * @param ms
 * @returns {function(*): Promise<unknown>}
 */
const sleeper = (ms) => {
    return function(x) {
        return new Promise(resolve => setTimeout(() => resolve(x), ms));
    };
}
export default sleeper;;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;