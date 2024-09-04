import { callApi, select } from "./lib.js";

const onSubmit = (event) => {
	event.preventDefault();

	const formData = Object.fromEntries(new FormData(event.target));

	callApi("backend/class.php", {
		method: "POST",
		body: formData,
		auth: localStorage.getItem("token"),

		onResponse: () => {
			window.location.href = "all-classes.html";
		},

		onError: ({ errorData, error }) => {
			if (errorData) {
				select("#general-error").textContent =
					errorData.message ??
					"An error occurred while submitting the form. Please try again later.";
				return;
			}

			if (error) {
				select("#general-error").textContent =
					"An error occurred while submitting the form. Please try again later.";
				return;
			}
		},
	});
};

select("#submit-form").addEventListener("submit", onSubmit);
