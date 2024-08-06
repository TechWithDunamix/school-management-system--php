/**
 *
 * @param {string} value
 * @returns {ReturnType<typeof document.querySelector>}
 */
export const select = (value) => document.querySelector(value);
/**
 *
 * @param {string} value
 * @returns {ReturnType<typeof document.querySelectorAll>}
 */
export const selectAll = (value) => document.querySelectorAll(value);

export { callApi } from "https://esm.run/@zayne-labs/callapi@0.5.1";
