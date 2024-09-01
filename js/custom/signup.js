import { callApi, select } from "./lib.js";

const signupForm = select("#signup-form");

const onSubmit = (event) => {
	event.preventDefault();

	select("#submit-button").setAttribute("disabled", true);
	select("#submit-button").classList.add("disabled");
	select("#submit-button").insertAdjacentHTML("beforeend", '<span class="button-loader"></span>');

	const formData = Object.fromEntries(new FormData(event.target));

	select("input[name='email']", signupForm).addEventListener("change", (event) => {
		event.target.setCustomValidity("");
		select("input[name='school_name'']", signupForm).setCustomValidity("");
	});

	select("input[name='school_name']", signupForm).addEventListener("change", (event) => {
		event.target.setCustomValidity("");
		select("input[name='email']", signupForm).setCustomValidity("");
	});

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
			data.data?.school_id && localStorage.setItem("school_id", data.data.school_id);

			window.location.href = "index.html";
		},

		onResponseError: ({ errorData }) => {
			if (errorData?.errors?.email) {
				select("input[name='email']", signupForm).setCustomValidity(errorData.errors.email);
				select("input[name='email']", signupForm).reportValidity();
				return;
			}

			if (errorData?.errors?.school_id) {
				select("input[name='school_name']", signupForm).setCustomValidity(errorData.errors.school_id);
				select("input[name='school_name']", signupForm).reportValidity();
				return;
			}

			select("#general-error").textContent = errorData.message;

			select("#general-error").scrollIntoView({
				behavior: "smooth",
				block: "end",
			});
		},

		onError: () => {
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();
		},
	});
};

signupForm.addEventListener("submit", onSubmit);
