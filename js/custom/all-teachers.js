import { callApi, select } from "./lib.js";

const createTeacherDetailsRow = (teacherData) => `<tr data-teacher-id=${teacherData.id}>
										<td>
											<div class="form-check">
												<input type="checkbox" class="form-check-input">
												<label class="form-check-label">#${teacherData.id.slice(0, 4)}</label>
											</div>
										</td>
										<td class="text-center"><img src="img/figure/student8.png" alt="teacher"></td>
										<td>${teacherData.first_name} ${teacherData.last_name}</td>
										<td>${teacherData.gender}</td>
										<td>${teacherData.class}</td>
										<td>${teacherData.email}</td>
										<td>${teacherData.phone}</td>
										<td>${teacherData.religion}</td>
										<td>${teacherData.blood_group}</td>
										<td>${teacherData.date_of_birth}</td>
										<td>
											<div class="flex gap-1">
																<a
																	href="add-teacher.html?id=${teacherData.id}"
																	class="btn btn-primary shadow btn-xs sharp me-1"
																	><i class="fas fa-pencil-alt"></i
																></a>
																<button data-id="delete-btn" class="btn btn-danger shadow btn-xs sharp"
																	><i class="fa fa-trash"></i
																></button>
															</div>
										</td>
									</tr>`;

const deleteTeacher = (teacherId) => {
	if (!teacherId) {
		console.error("No teacher id provided");
		return;
	}

	const shouldDelete = confirm("Are you sure you want to delete this teacher's record?");

	if (!shouldDelete) return;

	callApi("backend/teachers.php", {
		method: "DELETE",
		auth: localStorage.getItem("token"),
		query: { teacher_id: teacherId },

		onResponse: () => {
			select(`tr[data-teacher-id="${teacherId}"]`).remove();
		},
	});
};

const fetchAndDisplayTeacherDetails = () => {
	callApi("backend/teachers.php", {
		auth: localStorage.getItem("token"),

		onResponse: ({ data }) => {
			if (data.data.length === 0) return;

			const tableBody = select("#table-body");

			select(".odd", tableBody)?.remove();

			const htmlContent = data.data
				.map((teacherData) => createTeacherDetailsRow(teacherData))
				.join("");

			tableBody.replaceChildren();

			tableBody.insertAdjacentHTML("beforeend", htmlContent);

			tableBody.addEventListener("click", (event) => {
				if (event.target.matches("[data-id='delete-btn'], [data-id='delete-btn'] *")) {
					const teacherId = event.target.closest("[data-teacher-id]").dataset.teacherId;

					deleteTeacher(teacherId);
				}
			});
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

fetchAndDisplayTeacherDetails();
