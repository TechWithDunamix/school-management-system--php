import { callApi, select } from "./lib.js";

const admitForm = select("#admit-form");

const studentId = new URLSearchParams(location.search).get("id");

const onSubmit = (event) => {
	event.preventDefault();

	const formObject = Object.fromEntries(new FormData(event.target));

	Reflect.set(formObject, "date_of_birth", new Date(formObject["date_of_birth"]));

	select("#submit-button").setAttribute("disabled", true);
	select("#submit-button").classList.add("disabled");
	select("#submit-button").insertAdjacentHTML("beforeend", '<div class="button-loader"></div>');

	callApi("backend/students.php", {
		method: studentId ? "PATCH" : "POST",
		body: formObject,
		query: {
			school_id: localStorage.getItem("school_id"),
			...(Boolean(studentId) && { student_id: studentId }),
		},
		onRequestError: () => {
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();

			select("#general-error").textContent =
				"An error occurred while submitting the form. Please try again later.";

			select("#general-error").scrollIntoView({
				behavior: "smooth",
				block: "end",
			});
		},

		onResponse: ({ data }) => {
			console.log(data);
			window.location.href = "all-students.html";
		},

		onResponseError: () => {
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();
		},
	});
};

const populateLateForm = () => {
	callApi("backend/students.php", {
		query: {
			school_id: localStorage.getItem("school_id"),
			student_id: studentId,
		},

		onResponse: ({ data }) => {
			const studentData = data[0];
			const allElementsArray = Array.from(admitForm.elements);

			// prettier-ignore
			const requiredFormElements = allElementsArray.filter((item) =>Object.keys(studentData).includes(item.name));

			for (const requiredFormElement of requiredFormElements) {
				const inputValue = studentData[requiredFormElement.name];

				requiredFormElement.value = inputValue;
			}
		},
	});
};

studentId && populateLateForm();

admitForm.addEventListener("submit", onSubmit);
