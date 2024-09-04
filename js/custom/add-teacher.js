import { callApi, select } from "./lib.js";

const addTeacherForm = select("#add-teacher-form");

const teacher_id = new URLSearchParams(location.search).get("id");

const onSubmit = (event) => {
	event.preventDefault();

	const formObject = Object.fromEntries(new FormData(event.target));

	Reflect.set(formObject, "date_of_birth", new Date(formObject["date_of_birth"]));

	select("#submit-button", addTeacherForm).setAttribute("disabled", true);
	select("#submit-button", addTeacherForm).classList.add("disabled");
	select("#submit-button", addTeacherForm).insertAdjacentHTML(
		"beforeend",
		'<div class="button-loader"></div>'
	);

	callApi("backend/teachers.php", {
		method: teacher_id ? "PATCH" : "POST",
		body: formObject,
		auth: localStorage.getItem("token"),
		query: teacher_id && { teacher_id },

		onResponse: () => {
			window.location.href = "all-teachers.html";
		},

		onError: () => {
			select("#submit-button", addTeacherForm).removeAttribute("disabled");
			select("#submit-button", addTeacherForm).classList.remove("disabled");
			select("#submit-button .button-loader", addTeacherForm).remove();
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
	callApi("backend/teachers.php", {
		query: {
			school_id: localStorage.getItem("school_id"),
			teacher_id,
		},

		onResponse: ({ data }) => {
			const teacherData = data.data;

			const allElementsArray = Array.from(addTeacherForm.elements);

			// prettier-ignore
			const requiredFormElements = allElementsArray.filter((item) => Object.keys(teacherData).includes(item.name));

			for (const requiredFormElement of requiredFormElements) {
				const inputValue = teacherData[requiredFormElement.name];

				requiredFormElement.value = inputValue;
			}
		},
	});
};

teacher_id && populateLateForm();

addTeacherForm.addEventListener("submit", onSubmit);
