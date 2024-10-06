import { callApi, select } from "./lib.js";

const createStudentDetailsRow = (studentData) => `<tr data-student-id=${studentData.id}>
										<td>
											<div class="form-check">
												<input type="checkbox" class="form-check-input">
												<label class="form-check-label">#${studentData.id.slice(0, 4)}</label>
											</div>
										</td>
										<td class="text-center"><img src="img/figure/student2.png" alt="student"></td>
										<td>${studentData.first_name} ${studentData.last_name}</td>
										<td>${studentData.gender}</td>
										<td>${studentData.age}</td>
										<td>${studentData.class}</td>
										<td>${studentData.parent_full_name}</td>
										<td>${studentData.parent_phone}</td>
										<td>${studentData.date_of_birth}</td>
										<td>
											<div class="flex gap-1">
																<a
																	href="admit-form.html?id=${studentData.id}"
																	class="btn btn-primary shadow btn-xs sharp me-1"
																	><i class="fas fa-pencil-alt"></i
																></a>
																<button data-id="delete-btn" class="btn btn-danger shadow btn-xs sharp"
																	><i class="fa fa-trash touch-none"></i
																></button>
															</div>
										</td>
									</tr>`;

const deleteStudent = (studentId) => {
	if (!studentId) {
		console.error("No student id provided");
		return;
	}

	const shouldDelete = confirm("Are you sure you want to delete this student's record?");

	if (!shouldDelete) return;

	callApi("backend/students.php", {
		method: "DELETE",
		auth: localStorage.getItem("token"),
		query: { student_id: studentId },

		onResponse: () => {
			select(`tr[data-student-id="${studentId}"]`).remove();
		},
	});
};

const fetchAndDisplayStudentsDetails = () => {
	callApi("backend/students.php", {
		auth: localStorage.getItem("token"),

		onError: ({ errorData, error }) => {
			if (errorData) {
				console.log(errorData.message);
				return;
			}

			if (error) {
				console.log(error.message);
			}
		},
		onResponse: ({ data }) => {
			if (data.data.length === 0) return;

			const tableBody = select("#table-body");

			const htmlContent = data.data
				.map((studentData) => createStudentDetailsRow(studentData))
				.join("");

			tableBody.replaceChildren();
			tableBody.insertAdjacentHTML("beforeend", htmlContent);

			tableBody.addEventListener("click", (event) => {
				if (!event.target.matches("[data-id='delete-btn'], [data-id='delete-btn'] *")) return;

				const studentId = event.target.closest("[data-student-id]").dataset.studentId;

				deleteStudent(studentId);
			});
		},
	});
};

fetchAndDisplayStudentsDetails();
