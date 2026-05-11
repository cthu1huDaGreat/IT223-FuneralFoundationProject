<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Manage Members - Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"  rel="stylesheet"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{url('img/logo.png')}}">
  
<link rel="stylesheet" href="{{url('css/president-members.css')}}">
</head>

<body>
<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand"><img src="{{url('img/logo.png')}}" alt="logo"><div class="fw-bold">Kapunongan</div></div>
  <nav>
    <a href="{{route('page.dashboard-president')}}">Dashboard</a>
    <a href="{{route('page.president-contribution')}}">Transactions</a>
    <a href="{{route('page.president-funeral')}}">Funeral Assistance</a>
    <a href="{{route('page.president-members')}}" class="active">Manage Members</a>
    <a href="{{route('page.president-settings')}}">Settings</a>
    <a href="{{route('logout')}}" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <button id="hamburger">☰</button>
    <div id="welcomeTextPresident" class="fw-bold"></div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>


<!-- Show all Members -->
<main class="container py-4">
    <h2 class="fw-bold mb-4">Manage Members</h2><br><br>

        <!-- Summary Cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
          <div class="card shadow-sm p-3">
              <h6 style="color: #00E5FF;">Total Members</h6>
              <h3 id="totalMembers">0</h3>
          </div>
      </div>
    </div>

    <div class="card mb-4">
        <div class="card-header collapsed"
             data-bs-toggle="collapse"
             data-bs-target="#membersCollapse"
             style="cursor: pointer;">
            All Members
        </div>
        <div id="membersCollapse" class="collapse">
            <div class="card-body table-responsive">
                <div class="mb-3">
                  <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#addMemberModal">+ New Account</button><br><br>
                    <input type="text" id="memberSearch" class="form-control" placeholder="Search members by name, email, or role"> 
                </div>
                <table class="table table-dark table-hover align-middle" id="membersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- REGISTRATION APPROVAL TABLE -->
<div class="card mb-4">
  <div class="card-header" data-bs-toggle="collapse" data-bs-target="#registrationCollapse" style="cursor:pointer;">
    Registration Approval
  </div>
  <div id="registrationCollapse" class="collapse">
    <div class="card-body table-responsive">
      <table class="table table-dark table-hover align-middle" id="registrationTable">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" class="text-center text-muted">Loading...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
  </main>
</div>


<!-- ADD MEMBER MODAL -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Create New Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addMemberForm">
        <div class="modal-body">
                          <div id="formAlerts"></div>
          <div class="mb-2">
            <label>First Name</label>
            <input type="text" class="form-control" id="memberFirstName" name="fname" required>
          </div>
          <div class="mb-2">
            <label>Last Name</label>
            <input type="text" class="form-control" id="memberLastName" name="lname" required>
          </div>
          <div class="mb-2">
            <label>M.I</label>
            <input type="text" class="form-control" id="memberMI" name="mi" maxlength="3">
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" class="form-control" id="memberEmail" name="email" required>
          </div>
          <div class="mb-2">
            <label>Password</label>
            <div class="password-wrapper">
              <input type="password" id="Password" class="form-control" name="password" required minlength="6">
              <img src="{{ asset('img/hide.png') }}" class="toggle-password" data-target="Password">
            </div>
          </div>
          <div class="mb-2">
            <label>Confirm Password</label>
            <div class="password-wrapper">
              <input type="password" id="confirmPassword" class="form-control" name="password_confirmation" required>
              <img src="{{ asset('img/hide.png') }}" class="toggle-password" data-target="confirmPassword">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-accent">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Edit Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editMemberForm">
        @csrf
        <div class="modal-body">
          <div id="editformAlerts"></div>
          <div class="mb-2">
            <label>First Name</label>
            <input type="text" class="form-control" id="editMemberFirstName" name="fname" required>
          </div>
          <div class="mb-2">
            <label>Last Name</label>
            <input type="text" class="form-control" id="editMemberLastName" name="lname" required>
          </div>
          <div class="mb-2">
            <label>M.I</label>
            <input type="text" class="form-control" id="editMemberMI" name="mi" maxlength="3">
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" class="form-control" id="editMemberEmail" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select id="editRole" name="role_id" class="form-control" required>
              <option value="" style="color: #000;">Select</option>
              <option value="1" style="color: #000;">Member</option>
              <option value="2" style="color: #000;">Treasurer</option>
              <option value="3" style="color: #000;">President</option>
            </select>
          </div>
          <div class="mb-2">
            <label>New Password</label>
            <div class="password-wrapper">
              <input type="password" id="editMemberPassword" class="form-control" name="password" minlength="6">
              <img src="{{ asset('img/hide.png') }}" class="toggle-password" data-target="editMemberPassword">
            </div>
          </div>
          <div class="mb-2">
            <label>Confirm New Password</label>
            <div class="password-wrapper">
              <input type="password" id="editMemberConfirmPassword" class="form-control" name="password_confirmation">
              <img src="{{ asset('img/hide.png') }}" class="toggle-password" data-target="editMemberConfirmPassword">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-accent">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteMemberModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete member: <strong id="deleteMemberName">this member</strong>?</p>
        <p class="text-warning">This will also remove all their data from funeral fund and other related tables.</p>
        <p class="text-danger"><strong>This action cannot be undone!</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- APPROVAL CONFIRMATION MODAL -->
<div class="modal fade" id="approveMemberModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Approval</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to approve this member?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-accent" id="confirmApproveBtn">Approve</button>
      </div>
    </div>
  </div>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Notifications</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="notificationList"><p class="text-muted-2">Loading notifications...</p></div>
    </div>
  </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body"><p>Are you sure you want to logout?</p></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-accent" id="confirmLogoutBtn">Logout</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>//Register Modal js
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addMemberForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm();
    });
});

function submitForm() {
    const form = document.getElementById('addMemberForm');
    const formData = new FormData(form);
    
    formData.append('_token', '{{ csrf_token() }}');
    
    const password = document.getElementById('Password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (password !== confirmPassword) {
        showAlert('Passwords do not match', 'error');
        return;
    }
    
    if (password.length < 6) {
        showAlert('Password must be at least 6 characters', 'error');
        return;
    }

    fetch('{{ route("register.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addMemberModal'));
                modal.hide();
                form.reset();
                clearAlerts();
                
                if (typeof loadMembers === 'function') loadMembers();
                if (typeof loadMembersCount === 'function') loadMembersCount();
            }, 1500);
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred while adding member', 'error');
    });
}

function showAlert(message, type) {
    const alertsContainer = document.getElementById('formAlerts');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    alertsContainer.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    `;
}

function clearAlerts() {
    document.getElementById('formAlerts').innerHTML = '';
}
</script>
<script>
// Global variables
let memberToEdit = null;
let memberToDelete = null;
let allMembers = [];
let roles = [];

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up event listeners...');
    
    // Load data
    loadMembers();
    loadRoles();
    loadMembersCount();
    loadPendingRegistrations();
    
    // Search functionality
    document.getElementById('memberSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        filterMembers(searchTerm);
    });

    // Delete functionality
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    confirmDeleteBtn.addEventListener('click', function() {
        if (memberToDelete) {
            deleteMember(memberToDelete);
        }
    });

    // Edit form submission
    const editForm = document.getElementById('editMemberForm');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        updateMember();
    });

    // Debug button (remove in production)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'd') {
            e.preventDefault();
            debugMembers();
        }
    });
});

// Load members function - FIXED
function loadMembers() {
    console.log('Loading members...');
    const tbody = document.querySelector('#membersTable tbody');
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Loading members...</td></tr>';

    fetch('{{ route("members.get") }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Members data received:', data);
        if (data.success && data.members) {
            allMembers = data.members;
            displayMembers(allMembers);
            loadMembersCount(); // Update count after loading members
        } else {
            console.error('Failed to load members:', data.message);
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Error loading members: ' + (data.message || 'Unknown error') + '</td></tr>';
        }
    })
    .catch(error => {
        console.error('Error loading members:', error);
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error loading members. Please check console.</td></tr>';
    });
}

// Load roles function
function loadRoles() {
    fetch('{{ route("members.roles") }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            roles = data.roles;
            console.log('Roles loaded:', roles);
        }
    })
    .catch(error => {
        console.error('Error loading roles:', error);
    });
}

// Display members in table - FIXED
function displayMembers(members) {
    const tbody = document.querySelector('#membersTable tbody');
    console.log('Displaying members:', members);
    
    if (!members || members.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No members found</td></tr>';
        return;
    }

    let html = '';
    members.forEach((member, index) => {
        const roleType = member.role_name || member.role_id || 'Unknown';
        
        html += `
            <tr>
                <td>${index + 1}</td>
                <td>${member.fname || 'N/A'}</td>
                <td>${member.lname || 'N/A'}</td>
                <td>${member.email || 'N/A'}</td>
                <td><span class="badge bg-info text-dark">${roleType}</span></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="showEditModal(${member.user_id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="showDeleteModal(${member.user_id})">Delete</button>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    console.log('Table updated with', members.length, 'members');
}

// Show edit modal
function showEditModal(userId) {
    memberToEdit = userId;
    const member = allMembers.find(m => m.user_id == userId);
    
    if (member) {
        console.log('Editing member:', member);
        
        document.getElementById('editMemberFirstName').value = member.fname || '';
        document.getElementById('editMemberLastName').value = member.lname || '';
        document.getElementById('editMemberMI').value = member.mi || '';
        document.getElementById('editMemberEmail').value = member.email || '';
        document.getElementById('editRole').value = member.role_id || '';
        document.getElementById('editMemberPassword').value = '';
        document.getElementById('editMemberConfirmPassword').value = '';
        document.getElementById('editformAlerts').innerHTML = '';
        
        const editModal = new bootstrap.Modal(document.getElementById('editMemberModal'));
        editModal.show();
    } else {
        console.error('Member not found with ID:', userId);
        alert('Member not found!');
    }
}

// Update member function
function updateMember() {
    console.log('Updating member:', memberToEdit);
    
    const form = document.getElementById('editMemberForm');
    const formData = new FormData(form);
    const password = document.getElementById('editMemberPassword').value;
    const confirmPassword = document.getElementById('editMemberConfirmPassword').value;

    formData.append('user_id', memberToEdit);
    formData.append('_token', '{{ csrf_token() }}');

    if (password) {
        if (password.length < 6) {
            showEditAlert('Password must be at least 6 characters', 'error');
            return;
        }
        if (password !== confirmPassword) {
            showEditAlert('Passwords do not match', 'error');
            return;
        }
    }

    fetch('{{ route("members.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Update response:', data);
        if (data.success) {
            showEditAlert(data.message, 'success');
            loadMembers(); // Reload the members list
            setTimeout(() => {
                const editModal = bootstrap.Modal.getInstance(document.getElementById('editMemberModal'));
                if (editModal) editModal.hide();
            }, 1500);
        } else {
            showEditAlert(data.message || 'Failed to update member', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showEditAlert('An error occurred while updating member', 'error');
    });
}

// Show alert in edit form
function showEditAlert(message, type) {
    const alertsContainer = document.getElementById('editformAlerts');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    alertsContainer.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    `;
}

// Delete functionality
function showDeleteModal(userId) {
    memberToDelete = userId;
    
    // Find member details for confirmation message
    const member = allMembers.find(m => m.user_id == userId);
    if (member) {
        const memberName = `${member.fname} ${member.lname}`;
        document.getElementById('deleteMemberName').textContent = memberName;
    }
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteMemberModal'));
    deleteModal.show();
}

function deleteMember(userId) {
    const deleteButton = document.getElementById('confirmDeleteBtn');
    const originalText = deleteButton.innerHTML;
    
    // Show loading state
    deleteButton.disabled = true;
    deleteButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Deleting...';

    fetch('{{ route("members.delete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ user_id: userId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteMemberModal'));
        if (deleteModal) deleteModal.hide();
        
        if (data.success) {
            showNotification(data.message, 'success');
            loadMembers(); // Reload the list
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while deleting member', 'error');
    })
    .finally(() => {
        // Reset button state
        deleteButton.disabled = false;
        deleteButton.innerHTML = 'Delete';
    });
}

// Filter members
function filterMembers(searchTerm) {
    if (!searchTerm) {
        displayMembers(allMembers);
        return;
    }
    
    const filteredMembers = allMembers.filter(member => {
        const searchIn = [
            member.fname?.toLowerCase() || '',
            member.lname?.toLowerCase() || '',
            member.email?.toLowerCase() || '',
            (member.role ? member.role.role : '').toLowerCase()
        ].join(' ');
        
        return searchIn.includes(searchTerm);
    });
    
    displayMembers(filteredMembers);
}

// Load members count
function loadMembersCount() {
    document.getElementById('totalMembers').textContent = allMembers.length;
}

// Debug function
function debugMembers() {
    console.log('=== DEBUG INFO ===');
    console.log('allMembers:', allMembers);
    console.log('allMembers length:', allMembers.length);
    console.log('Table body:', document.querySelector('#membersTable tbody'));
    console.log('Routes:');
    console.log('- members.get: {{ route("members.get") }}');
    console.log('- members.update: {{ route("members.update") }}');
    console.log('==================');
}

function filterMembers(searchTerm) {
    if (!searchTerm) {
        displayMembers(allMembers);
        return;
    }
    
    const filteredMembers = allMembers.filter(member => {
        const roleType = member.role ? member.role.role : '';
        const searchIn = [
            member.fname?.toLowerCase() || '',
            member.lname?.toLowerCase() || '',
            member.email?.toLowerCase() || '',
            roleType.toLowerCase() || ''
        ].join(' ');
        
        return searchIn.includes(searchTerm);
    });
    
    displayMembers(filteredMembers);
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadPendingRegistrations();
});

function loadPendingRegistrations() {
    const tbody = document.querySelector('#registrationTable tbody');
    
    fetch('{{ route("users.pending") }}', {
        method: 'GET',
        headers: {
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
            displayUsers(data.users);
        } else {
            showTableMessage('Error: ' + (data.message || 'Failed to load data'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showTableMessage('Error loading registration data');
    });
}

function displayUsers(users) {
    const tbody = document.querySelector('#registrationTable tbody');
    
    if (!users || users.length === 0) {
        showTableMessage('No pending registrations found');
        return;
    }

    let html = '';
    users.forEach((user, index) => {
        html += `
            <tr id="user-row-${user.user_id}">
                <td>${index + 1}</td>
                <td>${user.fname || 'N/A'}</td>
                <td>${user.lname || 'N/A'}</td>
                <td>${user.email}</td>
                <td>
                    <button class="btn btn-success btn-sm approve-btn" data-user-id="${user.user_id}">
                        Approve
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-user-id="${user.user_id}">
                        Delete
                    </button>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    // Add event listeners to buttons
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            approveUser(userId, this);
        });
    });
    
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            deleteUser(userId, this);
        });
    });
}

function approveUser(userId, button) {
    if (!confirm('Are you sure you want to approve this user?')) {
        return;
    }

    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = 'Approving...';

    fetch('{{ route("users.approve") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            user_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Remove the row from the table
            const userRow = document.getElementById(`user-row-${userId}`);
            if (userRow) {
                userRow.remove();
            }
            // Reload table if empty
            const remainingRows = document.querySelectorAll('#registrationTable tbody tr');
            if (remainingRows.length === 0) {
                showTableMessage('No pending registrations found');
            }
        } else {
            showNotification(data.message, 'error');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while approving user', 'error');
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

function deleteUser(userId, button) {
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        return;
    }

    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = 'Deleting...';

    fetch('{{ route("users.delete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            user_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Remove the row from the table
            const userRow = document.getElementById(`user-row-${userId}`);
            if (userRow) {
                userRow.remove();
            }
            // Reload table if empty
            const remainingRows = document.querySelectorAll('#registrationTable tbody tr');
            if (remainingRows.length === 0) {
                showTableMessage('No pending registrations found');
            }
        } else {
            showNotification(data.message, 'error');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while deleting user', 'error');
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

function showTableMessage(message) {
    const tbody = document.querySelector('#registrationTable tbody');
    tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">${message}</td></tr>`;
}

function showNotification(message, type) {
    // Create a simple notification
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    `;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>

<script>
// Sidebar toggle
const hamburger = document.getElementById('hamburger');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

hamburger.addEventListener('click', () => {
  if(sidebar.classList.contains('active')) {
    sidebar.classList.remove('active');
    overlay.style.display='none';
  } else {
    sidebar.classList.add('active');
    overlay.style.display='block';
  }
});
overlay.addEventListener('click', ()=>{ sidebar.classList.remove('active'); overlay.style.display='none'; });

// Toggle password visibility
document.querySelectorAll(".toggle-password").forEach(icon => {
  icon.addEventListener("click", () => {
    const targetId = icon.getAttribute("data-target");
    const input = document.getElementById(targetId);

    if (input.type === "password") {
      input.type = "text";
      icon.src = "{{ asset('img/show.png') }}"; 
    } else {
      input.type = "password";
      icon.src = "{{ asset('img/hide.png') }}";
    }
  });
});

// Logout modal okay rasad nga naa ni sya kay for logout button ni ug confirmation
const logoutBtn = document.getElementById('logoutBtn');
const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

logoutBtn.addEventListener('click', (e)=>{
  e.preventDefault();
  const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
  logoutModal.show();
});

confirmLogoutBtn.addEventListener('click', ()=>{
  window.location='{{route('page.index')}}';
});
</script>
</body>
</html>