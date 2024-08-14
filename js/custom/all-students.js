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
																	><i class="fa fa-trash"></i
																></button>
															</div>
										</td>
									</tr>`;

const deleteStudent = (studentId) => {
	const shouldDelete = confirm("Are you sure you want to delete this student's record?");

	if (!shouldDelete) return;

	callApi("backend/students.php", {
		method: "DELETE",
		query: { school_id: localStorage.getItem("school_id"), student_id: studentId },

		onResponse: () => {
			select(`tr[data-student-id="${studentId}"]`).remove();
		},
	});
};

const fetchAndDisplayStudentsDetails = async () => {
	const { data } = await callApi("backend/students.php", {
		query: { school_id: localStorage.getItem("school_id") },
	});

	if (!data || data.length === 0) return;

	const tableBody = select("#table-body");

	select(".odd", tableBody)?.remove();

	const htmlContent = data.map((studentData) => createStudentDetailsRow(studentData)).join("");

	tableBody.insertAdjacentHTML("beforeend", htmlContent);

	for (const studentData of data) {
		const deleteBtn = select(
			`tr[data-student-id="${studentData.id}"] [data-id="delete-btn"]`,
			tableBody
		);

		deleteBtn.addEventListener("click", () => deleteStudent(studentData.id));
	}
};

fetchAndDisplayStudentsDetails();
