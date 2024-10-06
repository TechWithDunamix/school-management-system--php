import { callApi, select } from "./lib.js";

const loginForm = select("#login-form");

console.log(loginForm);

const onSubmit = (event) => {
	event.preventDefault();

	select("#submit-button").setAttribute("disabled", true);
	select("#submit-button").classList.add("disabled");
	select("#submit-button").insertAdjacentHTML("beforeend", '<span class="button-loader"></span>');

	const formData = Object.fromEntries(new FormData(event.target));

	select("input[name='email']", loginForm).addEventListener("change", (event) => {
		event.target.setCustomValidity("");
		select("input[name='password']", loginForm).setCustomValidity("");
	});

	select("input[name='password']", loginForm).addEventListener("change", (event) => {
		event.target.setCustomValidity("");
		select("input[name='email']", loginForm).setCustomValidity("");
	});

	callApi("backend/login.php", {
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
			data.data?.token && localStorage.setItem("token", data.data.token);

			window.location.href = "index.html";
		},

		onResponseError: ({ errorData }) => {
			if (errorData?.errors?.email) {
				select("input[name='email']", loginForm).setCustomValidity(errorData.errors.email);
				select("input[name='email']", loginForm).reportValidity();
				return;
			}

			if (errorData?.errors?.password) {
				select("input[name='password']", loginForm).setCustomValidity(errorData.errors.password);
				select("input[name='password']", loginForm).reportValidity();
				return;
			}

			select("input[name='password']", loginForm).setCustomValidity(errorData.message);
			select("input[name='password']", loginForm).reportValidity();
		},

		onError: () => {
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();
		},
	});
};

loginForm.addEventListener("submit", onSubmit);
