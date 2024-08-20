/**
 *
 * @param {string} selector
 * @returns {ReturnType<typeof document.querySelector>}
 */
export const select = (selector, context = document) => context.querySelector(selector);
/**
 *
 * @param {string} selector
 * @returns {ReturnType<typeof document.querySelectorAll>}
 */
export const selectAll = (selector, context = document) => context.querySelectorAll(selector);

export { callApi } from "https://esm.run/@zayne-labs/callapi@0.7.1";
