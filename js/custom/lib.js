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

import { createFetchClient } from "https://esm.run/@zayne-labs/callapi@rc";

export const callApi = createFetchClient({
	onResponseError: [
		({ response }) => {
			if (response.status === 401) {
				window.location.href = "login.html";
			}
		},
	],
});

import "https://cdn.twind.style";
