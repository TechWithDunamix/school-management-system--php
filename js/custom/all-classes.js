import { callApi, select } from "./lib.js";

const createClassDetailsRow = (classData) => `<tr data-class-id=${classData.id}>
											<td class="text-center">
												<img src="img/figure/student2.png" alt="student" />
											</td>
											<td>${classData.class_name}</td>
											<td>${classData.teacher}</td>
											<td>
												<div class="flex gap-1">
																	<a
																		href="add-class.html?id=${classData.id}"
																		class="btn btn-primary shadow btn-xs sharp me-1"
																		><i class="fas fa-pencil-alt"></i
																	></a>
																	<button data-id="delete-btn" class="btn btn-danger shadow btn-xs sharp"
																		><i class="fa fa-trash"></i
																	></button>
												</div>
											</td>
										</tr>
										`;

const deleteClass = (classId) => {
	const shouldDelete = confirm("Are you sure you want to delete this class record?");

	if (!shouldDelete) return;

	callApi("backend/class.php", {
		method: "DELETE",
		auth: localStorage.getItem("token"),
		query: { class_id: classId },

		onResponse: () => {
			select(`tr[data-class-id="${classId}"]`).remove();
		},
	});
};

const fetchAndDisplayClassDetails = () => {
	callApi("backend/class.php", {
		auth: localStorage.getItem("token"),

		onResponse: ({ data }) => {
			if (data.data.length === 0) return;

			const tableBody = select("#table-body");

			select(".odd", tableBody)?.remove();

			const htmlContent = data.data.map((classData) => createClassDetailsRow(classData)).join("");

			tableBody.insertAdjacentHTML("beforeend", htmlContent);

			for (const classData of data.data) {
				const deleteBtn = select(
					`tr[data-class-id="${classData.id}"] [data-id="delete-btn"]`,
					tableBody
				);

				deleteBtn.addEventListener("click", () => deleteClass(classData.id));
			}
		},

		onError: ({ errorData, error }) => {
			if (errorData) {
				console.log(errorData?.message);
				return;
			}

			if (error) {
				console.log(error.message);
			}
		},
	});
};

fetchAndDisplayClassDetails();
