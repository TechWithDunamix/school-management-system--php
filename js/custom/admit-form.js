import { callApi, select } from "./lib.js";

const admitForm = select("#admit-form");

const student_id = new URLSearchParams(location.search).get("id");

const onSubmit = (event) => {
	event.preventDefault();

	const formObject = Object.fromEntries(new FormData(event.target));

	Reflect.set(formObject, "date_of_birth", new Date(formObject["date_of_birth"]));

	select("#submit-button").setAttribute("disabled", true);
	select("#submit-button").classList.add("disabled");
	select("#submit-button").insertAdjacentHTML("beforeend", '<div class="button-loader"></div>');

	callApi("backend/students.php", {
		method: student_id ? "PATCH" : "POST",
		body: formObject,
		auth: localStorage.getItem("token"),
		query: student_id && { student_id },

		onResponse: () => {
			window.location.href = "all-students.html";
		},

		onError: () => {
			select("#submit-button").classList.remove("disabled");
			select("#submit-button").removeAttribute("disabled");
			select("#submit-button .button-loader").remove();
		},

		onRequestError: () => {
			select("#general-error").textContent =
				"An error occurred while submitting the form. Please try again later.";

			select("#general-error").scrollIntoView({
				behavior: "smooth",
				block: "end",
			});
		},
	});
};

const fetchAndDisplayClassOptions = () => {
	callApi("backend/class.php", {
		auth: localStorage.getItem("token"),

		onError: ({ errorData, error }) => {
			if (errorData) {
				console.error("Failed to fetch classes:", errorData.message);
				return;
			}

			console.error("Failed to fetch classes:", error);
		},

		onResponse: ({ data }) => {
			const selectElement = select("select[name='class']");

			const optionsHtml = data.data
				.map((classItem) => `<option value="${classItem.id}">${classItem.class_name}</option>`)
				.join("");

			selectElement.insertAdjacentHTML("beforeend", optionsHtml);
		},
	});
};

fetchAndDisplayClassOptions();

const populateLateForm = () => {
	callApi("backend/students.php", {
		auth: localStorage.getItem("token"),
		query: { student_id },

		onResponse: ({ data }) => {
			const studentData = data.data;
			const allElementsArray = Array.from(admitForm.elements);

			// prettier-ignore
			const requiredFormElements = allElementsArray.filter((item) => Object.keys(studentData).includes(item.name));

			for (const requiredFormElement of requiredFormElements) {
				const inputValue = studentData[requiredFormElement.name];

				requiredFormElement.value = inputValue;
			}
		},
	});
};

student_id && populateLateForm();

admitForm.addEventListener("submit", onSubmit);
