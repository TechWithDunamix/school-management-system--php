import { callApi, select } from "./lib.js";

const onSubmit = (event) => {
	event.preventDefault();

	const formObject = Object.fromEntries(new FormData(event.target));

	Reflect.set(formObject, "date_of_birth", new Date(formObject["date_of_birth"]));

	select("#submit-button").setAttribute("disabled", true);
	select("#submit-button").classList.add("disabled");
	select("#submit-button").insertAdjacentHTML("beforeend", '<div class="button-loader"></div>');

	callApi("backend/students.php", {
		method: "POST",
		body: formObject,
		query: {
			school_id: localStorage.getItem("school_id"),
		},
		onRequestError: () => {
			select("#general-error").textContent =
				"An error occurred while submitting the form. Please try again later.";

			select("#general-error").scrollIntoView({
				behavior: "smooth",
				block: "end",
			});
		},
		onResponse: () => {
			window.location.href = "index.php";
		},
		onResponseError: () => {
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();
		},
	});
};

select("#admit-form").addEventListener("submit", onSubmit);
