import { callApi, select } from "./lib.js";

const onSubmit = (event) => {
	event.preventDefault();

	select("#submit-button").setAttribute("disabled", true);
	select("#submit-button").classList.add("disabled");
	select("#submit-button").insertAdjacentHTML("beforeend", '<div class="button-loader"></div>');

	const formData = Object.fromEntries(new FormData(event.target));

	callApi("backend/signup.php", {
		method: "POST",
		body: formData,

		onResponse: () => {
			window.location.href = "index.php";
		},

		onResponseError: ({ response }) => {
			select("input").classList.remove("disabled");
			select("input").removeAttribute("disabled");
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();

			select("#email-error").innerHTML = response.errorData.email ?? "";

			select("#school_name-error").innerHTML = response.errorData.school_name ?? "";
		},
	});
};

select("#login-form").addEventListener("submit", onSubmit);
