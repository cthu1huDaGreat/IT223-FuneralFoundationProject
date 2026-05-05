<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Treasurer Dashboard - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?php echo e(url('img/logo.png')); ?>">
<link rel="stylesheet" href="<?php echo e(url('css/dashboard-treasurer.css')); ?>">


</head>

<body>

<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand"><img src="<?php echo e(url('img/logo.png')); ?>" alt="logo"><div class="fw-bold">Kapunongan</div></div>
  <nav>
    <a href="<?php echo e(route('page.dashboard-treasurer')); ?>" class="active">Dashboard</a>
    <a href="<?php echo e(route('page.treasurer-contributions')); ?>">Transactions</a>
    <a href="<?php echo e(route('page.treasurer-funeral')); ?>">Funeral Assistance</a>
    <a href="<?php echo e(route('page.treasurer-members')); ?>">Manage Members</a>
    <a href="<?php echo e(route('page.treasurer-settings')); ?>">Settings</a>
    <a href="<?php echo e(route('logout')); ?>" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <button id="hamburger">☰</button>
    <div id="treasurerName" class="fw-bold"></div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>

  <main class="container py-4">
    <h2 class="fw-bold mb-4" style="color:#00E5FF;">Treasurer Dashboard</h2>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-3"><div class="card p-3"><h6 style="color:#00E5FF;">Total Balance</h6><h3 id="totalbal">₱0</h3></div></div>
      <div class="col-md-3"><div class="card p-3"><h6 style="color:#00E5FF;">Total Funeral Fund</h6> <h3 id="totalFuneralFunds">₱0</h3></div></div>
    </div>

    
<!-- Members Table -->
<div class="card mb-4">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">All Members Overview</h5>
      <div class="text-end">
        <small class="text">Total Members</small>
        <h3 class="mb-0" id="totalMembers"></h3>  
      </div>
    </div>
    <div class="mb-3">
      <input type="text" id="memberSearch" class="form-control" placeholder="Search members by name, email, or role">
    </div>
    <div class="table-responsive">
      <table class="table table-dark table-hover" id="membersTable">
        <thead>
          <tr>
            <th data-sort="name">Name ▲▼</th>
            <th data-sort="role">Role ▲▼</th>
            <th data-sort="outstanding">Outstanding ▲▼</th>
            <th data-sort="contribution">Total Contributions ▲▼</th>
            <th data-sort="funeral">Penalties ▲▼</th>
          </tr>
        </thead>
        <tbody><tr><td colspan="6" class="text-center">Loading...</td></tr></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Attendance Section -->
<div class="d-flex justify-content-between mb-2">
  <h5 class="fw-bold" style="color:#00E5FF;">Attendance Record</h5>
  <button class="btn btn-sm btn-present" id="addrecord" data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
    <b>Add Attendance</b>
  </button>
</div>

<div id="attendanceSections">
  <div class="card mb-4">
    <div class="card-header fw-bold d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(90deg,var(--accent1),var(--accent2)); color:#000; cursor: pointer;"
         data-bs-toggle="collapse" data-bs-target="#activeAttendanceBody" aria-expanded="true">
      <span>Active Attendance Records</span>
      <i class="bi bi-chevron-down collapse-icon"></i>
    </div>
    <div class="collapse show" id="activeAttendanceBody">
      <div class="card-body" id="activeAttendanceRecords">
        <p class="text-muted text-center">Loading active records...</p>
      </div>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header fw-bold d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(90deg,#6c757d,#495057); color:#fff; cursor: pointer;"
         data-bs-toggle="collapse" data-bs-target="#archivedAttendanceBody" aria-expanded="false">
      <span>Archived Attendance Records</span>
      <i class="bi bi-chevron-down collapse-icon"></i>
    </div>
    <div class="collapse" id="archivedAttendanceBody">
      <div class="card-body" id="archivedAttendanceRecords">
        <p class="text-muted text-center">Loading archived records...</p>
      </div>
    </div>
  </div>
</div>
</main>

<!-- Confirm Close Attendance Modal -->
<div class="modal fade" id="closeAttendanceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Close Attendance</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Do you want to close the attendance?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-accent" id="confirmCloseAttendance">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Archive Attendance Modal -->
<div class="modal fade" id="archiveAttendanceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Archive Attendance</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to archive this attendance record? This will move it to the archived section.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-accent" id="confirmArchiveAttendance">Archive</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Delete Attendance Modal -->
<div class="modal fade" id="deleteAttendanceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete Attendance</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this attendance record? This action cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteAttendance">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Attendance Modal -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Create New Attendance</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addAttendanceForm">
        <div class="modal-body">
          <div id="formAlerts"></div>
          <div class="mb-2">
            <label>Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="mb-2">
            <label>Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-accent">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-accent" id="confirmLogoutBtn">Logout</button>
      </div>
    </div>
  </div>
</div>


<!-- ADD MEMBER MODAL -->
<div class="modal fade" id="addAttendance" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Create New Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addAttendanceForm">
        <div class="modal-body">
                          <div id="formAlerts"></div>
          <div class="mb-2">
            <label>title</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-accent">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Notifications</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="notificationList">
        <p class="text-muted-2">Loading notifications...</p>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addRecordBtn = document.getElementById('addrecord');
    const addAttendanceForm = document.getElementById('addAttendanceForm');
    const activeAttendanceRecords = document.getElementById('activeAttendanceRecords');
    const archivedAttendanceRecords = document.getElementById('archivedAttendanceRecords');

    let currentAttendanceId = null;

    loadAttendanceRecords();

    addAttendanceForm.addEventListener('submit', function(e) {
        e.preventDefault();
        createNewAttendance();
    });

    document.getElementById('confirmCloseAttendance').addEventListener('click', function() {
        if (currentAttendanceId) {
            closeAttendance(currentAttendanceId);
        }
    });

    document.getElementById('confirmArchiveAttendance').addEventListener('click', function() {
        if (currentAttendanceId) {
            archiveAttendance(currentAttendanceId);
        }
    });

    document.getElementById('confirmDeleteAttendance').addEventListener('click', function() {
        if (currentAttendanceId) {
            deleteAttendance(currentAttendanceId);
        }
    });

    function loadAttendanceRecords() {
        fetch('<?php echo e(route("attendance.get")); ?>', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Full response data:', data);
            if (data.success) {
                console.log('Attendance records loaded successfully:', data.attendanceRecords);
                renderAttendanceRecords(data.attendanceRecords);
            } else {
                console.error('Server returned error:', data.message);
                showErrorMessage('Error loading attendance records: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Network error:', error);
            showErrorMessage('Network error loading attendance records: ' + error.message);
        });
    }

function renderAttendanceRecords(records) {
    activeAttendanceRecords.innerHTML = '';
    archivedAttendanceRecords.innerHTML = '';

    if (records.length === 0) {
        activeAttendanceRecords.innerHTML = '<p class="text-muted text-center">No attendance records found.</p>';
        archivedAttendanceRecords.innerHTML = '<p class="text-muted text-center">No archived records found.</p>';
        return;
    }

    const activeRecords = records.filter(record => record.status == 1 || record.status === undefined);
    const archivedRecords = records.filter(record => record.status == 2);

    if (activeRecords.length === 0) {
        activeAttendanceRecords.innerHTML = '<p class="text-muted text-center">No active attendance records.</p>';
    } else {
        activeRecords.forEach(record => {
            const attendanceCard = createAttendanceCard(record, false);
            activeAttendanceRecords.appendChild(attendanceCard);
        });
    }

    if (archivedRecords.length === 0) {
        archivedAttendanceRecords.innerHTML = '<p class="text-muted text-center">No archived records found.</p>';
    } else {
        archivedRecords.forEach(record => {
            const attendanceCard = createAttendanceCard(record, true);
            archivedAttendanceRecords.appendChild(attendanceCard);
        });
    }
    updateCollapseIcons();
}

function updateCollapseIcons() {
    const collapseElements = document.querySelectorAll('.collapse');
    collapseElements.forEach(collapse => {
        collapse.addEventListener('show.bs.collapse', function() {
            const header = this.previousElementSibling;
            const icon = header.querySelector('.collapse-icon');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        });
        
        collapse.addEventListener('hide.bs.collapse', function() {
            const header = this.previousElementSibling;
            const icon = header.querySelector('.collapse-icon');
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
}

function createAttendanceCard(record, isArchived) {
    const card = document.createElement('div');
    card.className = 'card mb-3';
    
    // Check if archive feature is available (status field exists)
    const hasArchiveFeature = record.status !== undefined;
    
    card.innerHTML = `
        <div class="card-header d-flex justify-content-between align-items-center" 
             style="cursor: pointer;"
             data-bs-toggle="collapse" 
             data-bs-target="#attendanceCard-${record.attendance_id}" 
             aria-expanded="false">
            <div>
                ${hasArchiveFeature ? `<span class="badge ${isArchived ? 'bg-secondary' : 'bg-success'} me-2">${isArchived ? 'Archived' : 'Active'}</span>` : ''}
                <span>Title: <strong>${record.title}</strong></span>
                <span class="ms-3">Date: <strong>${record.date}</strong></span>
                <span class="ms-3">Total Present: <strong>${record.tot_present || 0}/${record.total_members || 0}</strong></span>
            </div>
            <div>
                <i class="bi bi-chevron-down collapse-icon"></i>
            </div>
        </div>
        
        <div class="collapse" id="attendanceCard-${record.attendance_id}">
            <div class="card-body">
                <div class="mb-3 d-flex gap-2 align-items-center">
                    <input type="text" class="form-control member-search" placeholder="Search members by name, email" 
                           data-attendance-id="${record.attendance_id}">
                    ${!isArchived ? `
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-info close-dropdown-btn" href="#" data-attendance-id="${record.attendance_id}">
                                <i class="bi bi-lock me-2"></i>Close Attendance
                            </a></li>
                            ${hasArchiveFeature ? `
                            <li><a class="dropdown-item text-warning archive-btn" href="#" data-attendance-id="${record.attendance_id}">
                                <i class="bi bi-archive me-2"></i>Archive
                            </a></li>
                            ` : ''}
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger delete-btn" href="#" data-attendance-id="${record.attendance_id}">
                                <i class="bi bi-trash me-2"></i>Delete
                            </a></li>
                        </ul>
                    </div>
                    ` : `
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger delete-btn" href="#" data-attendance-id="${record.attendance_id}">
                                <i class="bi bi-trash me-2"></i>Delete
                            </a></li>
                        </ul>
                    </div>
                    `}
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle" style="color:#E6EEF3;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                ${!isArchived ? '<th scope="col">Actions</th>' : ''}
                            </tr>
                        </thead>
                        <tbody id="attendance-body-${record.attendance_id}">
                            <tr><td colspan="${isArchived ? '5' : '6'}" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    
    // Load attendance data for this record
    loadAttendanceData(record.attendance_id, isArchived);
    
    // Add event listeners
    if (!isArchived) {
        // Add event listener for close button in dropdown
        const closeDropdownBtn = card.querySelector('.close-dropdown-btn');
        closeDropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            currentAttendanceId = record.attendance_id;
            const modal = new bootstrap.Modal(document.getElementById('closeAttendanceModal'));
            modal.show();
        });

        if (hasArchiveFeature) {
            const archiveBtn = card.querySelector('.archive-btn');
            archiveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                currentAttendanceId = record.attendance_id;
                const modal = new bootstrap.Modal(document.getElementById('archiveAttendanceModal'));
                modal.show();
            });
        }
    }

    const deleteBtn = card.querySelector('.delete-btn');
    deleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        currentAttendanceId = record.attendance_id;
        const modal = new bootstrap.Modal(document.getElementById('deleteAttendanceModal'));
        modal.show();
    });

    // Add event listener for search
    const searchInput = card.querySelector('.member-search');
    searchInput.addEventListener('input', function() {
        searchMembers(this.value, record.attendance_id);
    });

    return card;
}

    function loadAttendanceData(attendanceId) {
        fetch(`/attendance/${attendanceId}/data`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                renderAttendanceTable(attendanceId, data.attendanceData);
            } else {
                throw new Error(data.message || 'Failed to load attendance data');
            }
        })
        .catch(error => {
            console.error('Error loading attendance data:', error);
            const tbody = document.getElementById(`attendance-body-${attendanceId}`);
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error: ${error.message}</td></tr>`;
        });
    }

    function renderAttendanceTable(attendanceId, attendanceData) {
    const tbody = document.getElementById(`attendance-body-${attendanceId}`);
    if (!tbody) return; // In case the table is collapsed and not in DOM yet
    
    tbody.innerHTML = '';

    if (!attendanceData || attendanceData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No members found for attendance</td></tr>';
        return;
    }

    // Filter out any users that might have role_id < 1 (just in case)
    const filteredData = attendanceData.filter(record => {
        // If role_id is available in the data, use it for filtering
        if (record.role_id !== undefined) {
            return record.role_id >= 1;
        }
        return true; // If role_id not in data, assume it's valid
    });

    if (filteredData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No eligible members found (role requirement)</td></tr>';
        return;
    }

    // Check if this attendance is archived by looking at the card badge
    const card = document.querySelector(`input[data-attendance-id="${attendanceId}"]`)?.closest('.card');
    const isArchived = card?.querySelector('.badge')?.textContent === 'Archived';

    filteredData.forEach((record, index) => {
        const row = document.createElement('tr');
        const statusText = record.status == 1 ? 'Pending' : 
                          record.status == 2 ? 'Present' : 'Absent';
        const statusClass = record.status == 1 ? 'text-warning' : 
                           record.status == 2 ? 'text-success' : 'text-danger';
        
        let timeDisplay = 'N/A';
        if (record.time) {
            try {
                const timeObj = new Date(record.time);
                if (!isNaN(timeObj.getTime())) {
                    timeDisplay = timeObj.toLocaleTimeString('en-PH', {
                        hour12: true,
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            } catch (error) {
                console.error('Error formatting time:', error);
            }
        }

        const actionButtons = !isArchived ? `
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-success mark-present" 
                            data-attendance-id="${attendanceId}" 
                            data-user-id="${record.user_id}">
                        Present
                    </button>
                    <button class="btn btn-outline-danger mark-absent" 
                            data-attendance-id="${attendanceId}" 
                            data-user-id="${record.user_id}">
                        Absent
                    </button>
                </div>
            </td>
        ` : '';

        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${record.first_name || 'N/A'}</td>
            <td>${record.last_name || 'N/A'}</td>
            <td>${timeDisplay}</td>
            <td class="${statusClass}">${statusText}</td>
            ${actionButtons}
        `;
        tbody.appendChild(row);
    });

    // Add event listeners for action buttons
    if (!isArchived) {
        tbody.querySelectorAll('.mark-present').forEach(btn => {
            btn.addEventListener('click', function() {
                updateAttendanceStatus(
                    this.getAttribute('data-attendance-id'),
                    this.getAttribute('data-user-id'),
                    2 // Present
                );
            });
        });

        tbody.querySelectorAll('.mark-absent').forEach(btn => {
            btn.addEventListener('click', function() {
                updateAttendanceStatus(
                    this.getAttribute('data-attendance-id'),
                    this.getAttribute('data-user-id'),
                    3 // Absent
                );
            });
        });
    }
}
    function createNewAttendance() {
        const title = document.getElementById('title').value;
        const date = document.getElementById('date').value;

        if (!title || !date) {
            showAlert('Please fill in both title and date fields.', 'danger');
            return;
        }

        const button = addAttendanceForm.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Creating...';

        fetch('<?php echo e(route("attendance.store")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                title: title,
                date: date
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addAttendanceModal'));
                modal.hide();
                
                // Reset form
                addAttendanceForm.reset();
                document.getElementById('formAlerts').innerHTML = '';
                
                // Reload attendance records
                loadAttendanceRecords();
                
                // Show success message
                showAlert('Attendance created successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to create attendance');
            }
        })
        .catch(error => {
            console.error('Error creating attendance:', error);
            showAlert('Error: ' + error.message, 'danger');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }

    function updateAttendanceStatus(attendanceId, userId, status) {
        fetch('<?php echo e(route("attendance.updateStatus")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                attendance_id: attendanceId,
                user_id: userId,
                status: status
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Reload the attendance data for this record
                loadAttendanceData(attendanceId);
                // Reload main records to update total present count
                loadAttendanceRecords();
            } else {
                throw new Error(data.message || 'Failed to update attendance status');
            }
        })
        .catch(error => {
            console.error('Error updating attendance status:', error);
            alert('Error: ' + error.message);
        });
    }

    function closeAttendance(attendanceId) {
        // Note: We removed the confirm dialog since we're using a modal now
        fetch('<?php echo e(route("attendance.close")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                attendance_id: attendanceId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('closeAttendanceModal'));
                modal.hide();
                
                // Reload attendance records
                loadAttendanceRecords();
                showAlert('Attendance closed successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to close attendance');
            }
        })
        .catch(error => {
            console.error('Error closing attendance:', error);
            showAlert('Error: ' + error.message, 'danger');
        });
    }

    function searchMembers(query, attendanceId) {
        const rows = document.querySelectorAll(`#attendance-body-${attendanceId} tr`);
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query.toLowerCase()) ? '' : 'none';
        });
    }

    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.getElementById('formAlerts').innerHTML = '';
        document.getElementById('formAlerts').appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }

    function archiveAttendance(attendanceId) {
        fetch('<?php echo e(route("attendance.archive")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                attendance_id: attendanceId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('archiveAttendanceModal'));
                modal.hide();
                
                // Reload attendance records
                loadAttendanceRecords();
                showAlert('Attendance archived successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to archive attendance');
            }
        })
        .catch(error => {
            console.error('Error archiving attendance:', error);
            showAlert('Error: ' + error.message, 'danger');
        });
    }

    function deleteAttendance(attendanceId) {
        fetch('<?php echo e(route("attendance.delete")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                attendance_id: attendanceId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAttendanceModal'));
                modal.hide();
                
                // Reload attendance records
                loadAttendanceRecords();
                showAlert('Attendance deleted successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to delete attendance');
            }
        })
        .catch(error => {
            console.error('Error deleting attendance:', error);
            showAlert('Error: ' + error.message, 'danger');
        });
    }

    function showErrorMessage(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.getElementById('attendanceSections').appendChild(alertDiv);
    }
});
</script>

<script>
// Sidebar toggle
const hamburger = document.getElementById('hamburger');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

hamburger.addEventListener('click', () => {
  sidebar.classList.toggle('active');
  overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
});
overlay.addEventListener('click', () => { sidebar.classList.remove('active'); overlay.style.display='none'; });

// Logout modal okay rasad nga naa ni sya kay for logout button ni ug confirmation
const logoutBtn = document.getElementById('logoutBtn');
const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

logoutBtn.addEventListener('click', (e)=>{
  e.preventDefault();
  const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
  logoutModal.show();
});


confirmLogoutBtn.addEventListener('click', ()=>{
  window.location='<?php echo e(route('page.index')); ?>';
});

</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\kapunongan\resources\views/page/dashboard-treasurer.blade.php ENDPATH**/ ?>