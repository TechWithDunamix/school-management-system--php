import { select } from "./lib.js";

const headerHtml = `
				<div class="nav-bar-header-one">
					<div class="header-logo">
						<a href="index.html">
							<img src="img/logo.png" alt="logo" />
						</a>
					</div>
					<div class="toggle-button sidebar-toggle">
						<button type="button" class="item-link">
							<span class="btn-icon-wrap">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>
					</div>
				</div>
				<div class="d-md-none mobile-nav-bar">
					<button
						class="navbar-toggler pulse-animation"
						type="button"
						data-toggle="collapse"
						data-target="javascript:void(0)mobile-navbar"
						aria-expanded="false"
					>
						<i class="far fa-arrow-alt-circle-down"></i>
					</button>
					<button type="button" class="navbar-toggler sidebar-toggle-mobile">
						<i class="fas fa-bars"></i>
					</button>
				</div>
				<div class="header-main-menu bs-collapse navbar-collapse" id="mobile-navbar">
					<ul class="navbar-nav">
						<li class="navbar-item header-search-bar">
							<div class="input-group stylish-input-group">
								<span class="input-group-addon">
									<button type="submit">
										<span class="flaticon-search" aria-hidden="true"></span>
									</button>
								</span>
								<input type="text" class="form-control" placeholder="Find Something . . ." />
							</div>
						</li>
					</ul>
					<ul class="navbar-nav">
						<li class="navbar-item dropdown header-admin">
							<a
								class="navbar-nav-link dropdown-toggle"
								href="javascript:void(0)"
								role="button"
								data-toggle="dropdown"
								aria-expanded="false"
							>
								<div class="admin-title">
									<h5 class="item-title">Stevne Zone</h5>
									<span>Admin</span>
								</div>
								<div class="admin-img">
									<img src="img/figure/admin.jpg" alt="Admin" />
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="item-header">
									<h6 class="item-title">Steven Zone</h6>
								</div>
								<div class="item-content">
									<ul class="settings-list">
										<li>
											<a href="javascript:void(0)"><i class="flaticon-user"></i>My Profile</a>
										</li>
										<li>
											<a href="javascript:void(0)"><i class="flaticon-list"></i>Task</a>
										</li>
										<li>
											<a href="javascript:void(0)"
												><i
													class="flaticon-chat-comment-oval-speech-bubble-with-text-lines"
												></i
												>Message</a
											>
										</li>
										<li>
											<a href="javascript:void(0)"><i class="flaticon-gear-loading"></i>Account Settings</a>
										</li>
										<li>
											<a href="login.html"><i class="flaticon-turn-off"></i>Log Out</a>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li class="navbar-item dropdown header-message">
							<a
								class="navbar-nav-link dropdown-toggle"
								href="javascript:void(0)"
								role="button"
								data-toggle="dropdown"
								aria-expanded="false"
							>
								<i class="far fa-envelope"></i>
								<div class="item-title d-md-none text-16 mg-l-10">Message</div>
								<span>5</span>
							</a>

							<div class="dropdown-menu dropdown-menu-right">
								<div class="item-header">
									<h6 class="item-title">05 Message</h6>
								</div>
								<div class="item-content">
									<div class="media">
										<div class="item-img bg-skyblue author-online">
											<img src="img/figure/student11.png" alt="img" />
										</div>
										<div class="media-body space-sm">
											<div class="item-title">
												<a href="javascript:void(0)">
													<span class="item-name">Maria Zaman</span>
													<span class="item-time">18:30</span>
												</a>
											</div>
											<p>What is the reason of buy this item. Is it usefull for me.....</p>
										</div>
									</div>
									<div class="media">
										<div class="item-img bg-yellow author-online">
											<img src="img/figure/student12.png" alt="img" />
										</div>
										<div class="media-body space-sm">
											<div class="item-title">
												<a href="javascript:void(0)">
													<span class="item-name">Benny Roy</span>
													<span class="item-time">10:35</span>
												</a>
											</div>
											<p>What is the reason of buy this item. Is it usefull for me.....</p>
										</div>
									</div>
									<div class="media">
										<div class="item-img bg-pink">
											<img src="img/figure/student13.png" alt="img" />
										</div>
										<div class="media-body space-sm">
											<div class="item-title">
												<a href="javascript:void(0)">
													<span class="item-name">Steven</span>
													<span class="item-time">02:35</span>
												</a>
											</div>
											<p>What is the reason of buy this item. Is it usefull for me.....</p>
										</div>
									</div>
									<div class="media">
										<div class="item-img bg-violet-blue">
											<img src="img/figure/student11.png" alt="img" />
										</div>
										<div class="media-body space-sm">
											<div class="item-title">
												<a href="javascript:void(0)">
													<span class="item-name">Joshep Joe</span>
													<span class="item-time">12:35</span>
												</a>
											</div>
											<p>What is the reason of buy this item. Is it usefull for me.....</p>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li class="navbar-item dropdown header-notification">
							<a
								class="navbar-nav-link dropdown-toggle"
								href="javascript:void(0)"
								role="button"
								data-toggle="dropdown"
								aria-expanded="false"
							>
								<i class="far fa-bell"></i>
								<div class="item-title d-md-none text-16 mg-l-10">Notification</div>
								<span>8</span>
							</a>

							<div class="dropdown-menu dropdown-menu-right">
								<div class="item-header">
									<h6 class="item-title">03 Notifiacations</h6>
								</div>
								<div class="item-content">
									<div class="media">
										<div class="item-icon bg-skyblue">
											<i class="fas fa-check"></i>
										</div>
										<div class="media-body space-sm">
											<div class="post-title">Complete Today Task</div>
											<span>1 Mins ago</span>
										</div>
									</div>
									<div class="media">
										<div class="item-icon bg-orange">
											<i class="fas fa-calendar-alt"></i>
										</div>
										<div class="media-body space-sm">
											<div class="post-title">Director Metting</div>
											<span>20 Mins ago</span>
										</div>
									</div>
									<div class="media">
										<div class="item-icon bg-violet-blue">
											<i class="fas fa-cogs"></i>
										</div>
										<div class="media-body space-sm">
											<div class="post-title">Update Password</div>
											<span>45 Mins ago</span>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li class="navbar-item dropdown header-language">
							<a
								class="navbar-nav-link dropdown-toggle"
								href="javascript:void(0)"
								role="button"
								data-toggle="dropdown"
								aria-expanded="false"
								><i class="fas fa-globe-americas"></i>EN</a
							>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="javascript:void(0)">English</a>
								<a class="dropdown-item" href="javascript:void(0)">Spanish</a>
								<a class="dropdown-item" href="javascript:void(0)">Franchis</a>
								<a class="dropdown-item" href="javascript:void(0)">Chiness</a>
							</div>
						</li>
					</ul>
				</div>
`;

const sidebarHtml = `<div class="mobile-sidebar-header d-md-none">
						<div class="header-logo">
							<a href="index.html"><img src="img/logo1.png" alt="logo" /></a>
						</div>
					</div>
					<div class="sidebar-menu-content">
						<ul id="nav-list" class="nav nav-sidebar-menu sidebar-toggle-view">
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-dashboard"></i><span>Dashboard</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="index.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Admin</a
										>
									</li>
									<li class="nav-item">
										<a href="index3.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Students</a
										>
									</li>
									<li class="nav-item">
										<a href="index4.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Parents</a
										>
									</li>
									<li class="nav-item">
										<a href="index5.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Teachers</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-classmates"></i><span>Students</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="all-students.html" class="nav-link"
											><i class="fas fa-angle-right"></i>All Students</a
										>
									</li>
									<li class="nav-item">
										<a href="student-details.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Student Details</a
										>
									</li>
									<li class="nav-item">
										<a href="admit-form.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Admission Form</a
										>
									</li>
									<li class="nav-item">
										<a href="student-promotion.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Student Promotion</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-multiple-users-silhouette"></i><span>Teachers</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="all-teachers.html" class="nav-link"
											><i class="fas fa-angle-right"></i>All Teachers</a
										>
									</li>
									<li class="nav-item">
										<a href="teacher-details.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Teacher Details</a
										>
									</li>
									<li class="nav-item">
										<a href="add-teacher.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Add Teacher</a
										>
									</li>
									<li class="nav-item">
										<a href="teacher-payment.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Payment</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-couple"></i><span>Parents</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="all-parents.html" class="nav-link"
											><i class="fas fa-angle-right"></i>All Parents</a
										>
									</li>
									<li class="nav-item">
										<a href="parents-details.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Parents Details</a
										>
									</li>
									<li class="nav-item">
										<a href="add-parents.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Add Parent</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-books"></i><span>Library</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="all-book.html" class="nav-link"
											><i class="fas fa-angle-right"></i>All Book</a
										>
									</li>
									<li class="nav-item">
										<a href="add-book.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Add New Book</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-technological"></i><span>Acconunt</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="all-fees.html" class="nav-link"
											><i class="fas fa-angle-right"></i>All Fees Collection</a
										>
									</li>
									<li class="nav-item">
										<a href="all-expense.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Expenses</a
										>
									</li>
									<li class="nav-item">
										<a href="add-expense.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Add Expenses</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler"></i
									><span>Class</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="all-classes.html" class="nav-link"
											><i class="fas fa-angle-right"></i>All Classes</a
										>
									</li>
									<li class="nav-item">
										<a href="add-class.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Add New Class</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="all-subject.html" class="nav-link"
									><i class="flaticon-open-book"></i><span>Subject</span></a
								>
							</li>
							<li class="nav-item">
								<a href="class-routine.html" class="nav-link"
									><i class="flaticon-calendar"></i><span>Class Routine</span></a
								>
							</li>
							<li class="nav-item">
								<a href="student-attendence.html" class="nav-link"
									><i class="flaticon-checklist"></i><span>Attendence</span></a
								>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-shopping-list"></i><span>Exam</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="exam-schedule.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Exam Schedule</a
										>
									</li>
									<li class="nav-item">
										<a href="exam-grade.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Exam Grades</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="transport.html" class="nav-link"
									><i class="flaticon-bus-side-view"></i><span>Transport</span></a
								>
							</li>
							<li class="nav-item">
								<a href="hostel.html" class="nav-link"
									><i class="flaticon-bed"></i><span>Hostel</span></a
								>
							</li>
							<li class="nav-item">
								<a href="notice-board.html" class="nav-link"
									><i class="flaticon-script"></i><span>Notice</span></a
								>
							</li>
							<li class="nav-item">
								<a href="messaging.html" class="nav-link"
									><i class="flaticon-chat"></i><span>Messeage</span></a
								>
							</li>
							<li class="nav-item sidebar-nav-item">
								<a href="javascript:void(0)" class="nav-link"
									><i class="flaticon-menu-1"></i><span>UI Elements</span></a
								>
								<ul class="nav sub-group-menu">
									<li class="nav-item">
										<a href="notification-alart.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Alart</a
										>
									</li>
									<li class="nav-item">
										<a href="button.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Button</a
										>
									</li>
									<li class="nav-item">
										<a href="grid.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Grid</a
										>
									</li>
									<li class="nav-item">
										<a href="modal.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Modal</a
										>
									</li>
									<li class="nav-item">
										<a href="progress-bar.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Progress Bar</a
										>
									</li>
									<li class="nav-item">
										<a href="ui-tab.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Tab</a
										>
									</li>
									<li class="nav-item">
										<a href="ui-widget.html" class="nav-link"
											><i class="fas fa-angle-right"></i>Widget</a
										>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="map.html" class="nav-link"
									><i class="flaticon-planet-earth"></i><span>Map</span></a
								>
							</li>
							<li class="nav-item">
								<a href="account-settings.html" class="nav-link"
									><i class="flaticon-settings"></i><span>Account</span></a
								>
							</li>
						</ul>
</div>`;

const sideBarContainer = select("#sidebar");

sideBarContainer.insertAdjacentHTML("beforeend", sidebarHtml);

select("#navbar").insertAdjacentHTML("beforeend", headerHtml);

const activePage = window.location.pathname.split("/").at(-1);

const activeLink = select("#nav-list", sideBarContainer).querySelector(
	`[class='nav-item'] > a[href='${activePage}']`
);
activeLink.classList.add("menu-active");
activeLink.parentElement.parentElement.classList.add("sub-group-active");
