import { callApi, select } from "./lib.js";

const createStudentDetailsRow = (studentData) => `<tr>
										<td>
											<div class="form-check">
												<input type="checkbox" class="form-check-input">
												<label class="form-check-label">#0021</label>
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
											<div class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<span class="flaticon-more-button-of-three-dots"></span>
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
													<a class="fas fa-cogs text-dark-pastel-green" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
													<a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
												</div>
											</div>
										</td>
									</tr>`;

const fetchAndDisplayStudentsDetails = async () => {
	const { data } = await callApi("backend/students.php", {
		query: { school_id: localStorage.getItem("school_id") },
	});

	if (!data || data.length === 0) return;

	select("#table-body .odd").remove();

	let content = "";

	for (const studentData of data) {
		content += createStudentDetailsRow(studentData);
	}

	select("#table-body").insertAdjacentHTML("beforeend", content);
};

fetchAndDisplayStudentsDetails();
