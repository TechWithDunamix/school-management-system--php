import { callApi, select } from "./lib.js";

const signupForm = select("#signup-form");

const onSubmit = (event) => {
	event.preventDefault();

	select("#submit-button").setAttribute("disabled", true);
	select("#submit-button").classList.add("disabled");
	select("#submit-button").insertAdjacentHTML("beforeend", '<div class="button-loader"></div>');

	const formData = Object.fromEntries(new FormData(event.target));

	callApi("backend/signup.php", {
		method: "POST",
		body: formData,

		onRequestError: () => {
			select("#general-error").textContent =
				"An error occurred while submitting the form. Please try again later.";

			select("#general-error").scrollIntoView({
				behavior: "smooth",
				block: "end",
			});
		},

		onResponse: ({ data }) => {
			data?.school_id && localStorage.setItem("school_id", data.school_id);
			data?.email && localStorage.setItem("email", data.email);

			window.location.href = "index.html";
		},

		onResponseError: ({ errorData }) => {
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();

			signupForm.querySelector("input[name='email']").setCustomValidity(errorData.email ?? "");

			signupForm.querySelector("input[name='email']").reportValidity();

			signupForm
				.querySelector("input[name='school_name']")
				.setCustomValidity(errorData.school_name ?? "");

			signupForm.querySelector("input[name='school_name']").reportValidity();
		},
	});
};

signupForm.addEventListener("submit", onSubmit);
