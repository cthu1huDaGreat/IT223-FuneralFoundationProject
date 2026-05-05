<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Kapunongan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"  rel="stylesheet"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{url('img/logo.png')}}">
<link rel="stylesheet" href="{{url('css/member-settings.css')}}">


</head>

<body>

<div id="overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="brand">
   <img src="{{url('img/logo.png')}}" alt="logo">
    <div class="fw-bold">Kapunongan</div>
  </div>
  <nav>
    <a href="{{route('page.dashboard-member')}}">Dashboard</a>
    <a href="{{route('page.member-contribution')}}">Transactions</a>
    <a href="{{route('page.member-funeral')}}">Funeral Information</a>
    <a href="{{route('page.member-settings')}}" class="active">Settings</a>
    <a href="{{route('logout')}}" id="logoutBtn">Logout</a>
  </nav>
</aside>

<div class="page-content">
  <div class="topbar">
    <button id="hamburger">☰</button>
    <div id="welcomeTextMember" class="fw-bold"></div>
    <div id="notificationIcon" data-bs-toggle="modal" data-bs-target="#notificationModal">
      <i class="bi bi-bell"></i>
      <div id="notificationBadge" style="display:none;">0</div>
    </div>
  </div>

  <main class="container py-4">
    <h2 class="fw-bold mb-4">Settings</h2>

<!-- Account Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center" 
         style="cursor: pointer;"
         data-bs-toggle="collapse" 
         data-bs-target="#profileInfoBody" 
         aria-expanded="true">
        <span class="fw-bold">Profile Information</span>
        <i class="bi bi-chevron-down collapse-icon"></i>
    </div>
    
    <div class="collapse hide" id="profileInfoBody">
        <div class="card-body">
            <form id="profileForm">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" id="lname" name="lname" class="form-control" placeholder="Enter Your Last Name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" id="fname" name="fname" class="form-control" placeholder="Enter Your First Name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Middle Initial</label>
                        <input type="text" id="mi" name="mi" class="form-control" placeholder="Enter Your M.I Name" maxlength="10">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" id="age" name="age" class="form-control" min="0" max="120" placeholder="Enter Age" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Birthdate</label>
                        <input type="date" id="bdate" name="bdate" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sex</label>
                        <select id="sex" name="sex" class="form-control" required>
                            <option value="">Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" id="contact_no" name="contact_no" class="form-control" placeholder="Enter Contact No." pattern="[0-9]{11}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="Enter Email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prk./Block No.</label>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Enter Prk/Block No." required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Occupation</label>
                        <input type="text" id="occupation" name="occupation" class="form-control" placeholder="Enter Occupation" required>
                    </div>
                </div>
                <button type="submit" class="btn-save btn-primary">Save Changes</button>
            </form>
            <div id="profileMessageContainer" class="mt-3"></div>
        </div>
    </div>
</div>


<!-- Family List -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(90deg,var(--accent1),var(--accent2)); color:#000; cursor: pointer;"
         data-bs-toggle="collapse" 
         data-bs-target="#familyListBody" 
         aria-expanded="true">
        <span class="fw-bold">Family List</span>
        <div>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
    </div>
    
    <div class="collapse hide" id="familyListBody">
        <div class="card-body">
                      <button class="btn btn-sm btn-accent me-2 mb-3" data-bs-toggle="modal" data-bs-target="#addFamilyModal">
                <i class="bi"></i> Add Family Member
            </button>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle" id="familyMembersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>M.I.</th>
                            <th>Sex</th>
                            <th>Age</th>
                            <th>Birthdate</th>
                            <th>Relation</th>
                            <th>Occupation</th>
                            <th>Contact No.</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="familyMembersBody">
                        <tr>
                            <td colspan="11" class="text-center text-muted">Loading family members...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Family Member Modal -->
<div class="modal fade" id="addFamilyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
            <div class="modal-header">
                <h5 class="modal-title">Add Family Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="familyMemberForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control" id="fName" name="fname" placeholder="First name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control" id="lName" name="lname" placeholder="Last name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Middle Initial</label>
                            <input type="text" class="form-control" id="familyMI" name="mi" placeholder="M.I." maxlength="3">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sex</label>
                            <select id="familySex" name="sex" class="form-select" required>
                                <option value="">Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Age</label>
                            <input type="number" class="form-control" id="familyAge" name="age" placeholder="Age" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Birthdate</label>
                            <input type="date" class="form-control" id="familyBirthdate" name="bdate" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Relation</label>
                            <input type="text" class="form-control" id="familyRelation" name="relation" placeholder="Relation to you" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Occupation</label>
                            <input type="text" class="form-control" id="familyOccupation" name="occupation" placeholder="Occupation">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="tel" class="form-control" id="familyContact" name="contact_no" placeholder="09XXXXXXXXX">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-accent">Save Family Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Family Member Modal -->
<div class="modal fade" id="editFamilyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
            <div class="modal-header">
                <h5 class="modal-title">Edit Family Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFamilyMemberForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editFamilyId" name="family_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control" id="editFName" name="fname" placeholder="First name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control" id="editLName" name="lname" placeholder="Last name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Middle Initial</label>
                            <input type="text" class="form-control" id="editFamilyMI" name="mi" placeholder="M.I." maxlength="3">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sex</label>
                            <select id="editFamilySex" name="sex" class="form-select" required>
                                <option value="">Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Age</label>
                            <input type="number" class="form-control" id="editFamilyAge" name="age" placeholder="Age" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Birthdate</label>
                            <input type="date" class="form-control" id="editFamilyBirthdate" name="bdate" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Relation</label>
                            <input type="text" class="form-control" id="editFamilyRelation" name="relation" placeholder="Relation to you" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Occupation</label>
                            <input type="text" class="form-control" id="editFamilyOccupation" name="occupation" placeholder="Occupation">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="tel" class="form-control" id="editFamilyContact" name="contact_no" placeholder="09XXXXXXXXX">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-accent">Update Family Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Change Password Card -->
   <div class="card mb-4"> 
      <div class="card-body">
        <h5 class="mb-3">Change Password</h5>

          <!-- CURRENT PASSWORD -->
            <form method="POST" action="{{ route('settings.changePassword') }}">
              @csrf
                <div class="mb-3">
                  <label class="form-label fw-bold">Current Password</label>
                    <div class="password-wrapper">
                      <input type="password" name="currentPassword" id="currentPassword" class="form-control" placeholder="Enter current password">
                      <img src="{{url('img/hide.png')}}" class="toggle-password" data-target="currentPassword">
                    </div>
                </div>

                <!-- NEW PASSWORD -->
                <div class="mb-3">
                  <label class="form-label fw-bold">New Password</label>
                  <div class="password-wrapper">
                    <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="Enter new password">
                    <img src="{{url('img/hide.png')}}" class="toggle-password" data-target="newPassword">
                  </div>
                </div>

                <!-- CONFIRM NEW PASSWORD -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Confirm New Password</label>
                  <div class="password-wrapper">
                    <input type="password" name="newPassword_confirmation" id="confirmPassword" class="form-control" placeholder="Confirm new password">
                    <img src="{{url('img/hide.png')}}" class="toggle-password" data-target="confirmPassword">
                  </div>
                </div>
                <button id="saveSettingsBtn" class="btn btn-accent">Save Settings</button>
          </form> 
      </div>
    </div>
  </main>
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

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: var(--cardA); color:#E6EEF3;">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const familyMemberForm = document.getElementById('familyMemberForm');
    const editFamilyMemberForm = document.getElementById('editFamilyMemberForm');
    const familyMembersBody = document.getElementById('familyMembersBody');
    
    let familyMembers = [];
    let currentEditId = null;

    // Load existing family members
    loadFamilyMembers();

    // Handle form submission for new family member
    familyMemberForm.addEventListener('submit', function(e) {
        e.preventDefault();
        addFamilyMember();
    });

    // Handle form submission for editing family member
    editFamilyMemberForm.addEventListener('submit', function(e) {
        e.preventDefault();
        updateFamilyMember();
    });

    function loadFamilyMembers() {
    fetch('{{ route("family.list") }}', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Full API response:', data); // Debug: See entire response
        if (data.success) {
            familyMembers = data.familyMembers;
            console.log('Family members data:', familyMembers); // Debug: See the array
            if (familyMembers.length > 0) {
                console.log('First member structure:', familyMembers[0]); // Debug: See first item
                console.log('Available keys:', Object.keys(familyMembers[0])); // Debug: See all keys
            }
            renderFamilyMembers();
        } else {
            throw new Error(data.message || 'Failed to load family members');
        }
    })
    .catch(error => {
        console.error('Error loading family members:', error);
        familyMembersBody.innerHTML = `
            <tr>
                <td colspan="11" class="text-center text-danger">
                    Error loading family members: ${error.message}
                </td>
            </tr>
        `;
    });
}

    function renderFamilyMembers() {
    familyMembersBody.innerHTML = '';

    if (familyMembers.length === 0) {
        familyMembersBody.innerHTML = `
            <tr>
                <td colspan="11" class="text-center text-muted">
                    No family members added yet. Click "Add Family Member" to get started.
                </td>
            </tr>
        `;
        return;
    }

    familyMembers.forEach((member, index) => {
        const row = document.createElement('tr');
        
        // Try different possible ID field names
        const memberId = member.family_id || member.id || member.familyId || index;
        console.log(`Member ${index} ID:`, memberId, 'Full member:', member); // Debug
        
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${member.fname}</td>
            <td>${member.lname}</td>
            <td>${member.mi || '-'}</td>
            <td>${member.sex}</td>
            <td>${member.age}</td>
            <td>${member.bdate}</td>
            <td>${member.relation}</td>
            <td>${member.occupation || '-'}</td>
            <td>${member.contact_no || '-'}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-warning edit-family" data-id="${memberId}">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn btn-outline-danger delete-family" data-id="${memberId}">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </td>
        `;
        familyMembersBody.appendChild(row);
    });

    // Add event listeners
    document.querySelectorAll('.edit-family').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            console.log('Edit clicked, ID:', id); // Debug
            editFamilyMember(id);
        });
    });

    document.querySelectorAll('.delete-family').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            deleteFamilyMember(id);
        });
    });
}
    function addFamilyMember() {
    const formData = new FormData(familyMemberForm);
    const submitButton = familyMemberForm.querySelector('button[type="submit"]');
    
    // === PASTE THE VALIDATION CODE HERE ===
    // Only validate required fields (remove occupation and contact_no from validation)
    const requiredFields = ['fname', 'lname', 'age', 'sex', 'bdate', 'relation'];
    let isValid = true;
    
    requiredFields.forEach(fieldName => {
        const field = familyMemberForm.querySelector(`[name="${fieldName}"]`);
        if (field && !field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');
        } else if (field) {
            field.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        showAlert('Please fill in all required fields', 'danger');
        return;
    }
    // === END OF VALIDATION CODE ===
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';

    fetch('{{ route("family.store") }}', {
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
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('addFamilyModal'));
            modal.hide();
            familyMemberForm.reset();
            
            // Reload family members
            loadFamilyMembers();
            showAlert('Family member added successfully!', 'success');
        } else {
            throw new Error(data.message || 'Failed to add family member');
        }
    })
    .catch(error => {
        console.error('Error adding family member:', error);
        showAlert('Error: ' + error.message, 'danger');
    })
    .finally(() => {
        // Reset button state
        submitButton.disabled = false;
        submitButton.textContent = 'Save Family Member';
    });
}

    function editFamilyMember(id) {
    console.log('editFamilyMember called with ID:', id, 'Type:', typeof id);
    console.log('Available family members:', familyMembers); // Debug
    
    // Try to find member by different possible ID fields
    let member = familyMembers.find(m => m.family_id == id);
    if (!member) member = familyMembers.find(m => m.id == id);
    if (!member) member = familyMembers.find(m => m.familyId == id);
    
    console.log('Found member:', member); // Debug
    
    if (!member) {
        console.error('Family member not found with any ID field. Available members:', familyMembers);
        showAlert('Error: Could not find family member data', 'danger');
        return;
    }

    currentEditId = id;

    // Get the actual ID from the member (whichever field exists)
    const actualId = member.family_id || member.id || member.familyId;
    console.log('Using actual ID:', actualId); // Debug

    // Populate edit form
    document.getElementById('editFamilyId').value = actualId;
    document.getElementById('editFName').value = member.fname || '';
    document.getElementById('editLName').value = member.lname || '';
    document.getElementById('editFamilyMI').value = member.mi || '';
    document.getElementById('editFamilySex').value = member.sex || '';
    document.getElementById('editFamilyAge').value = member.age || '';
    document.getElementById('editFamilyBirthdate').value = member.bdate || '';
    document.getElementById('editFamilyRelation').value = member.relation || '';
    document.getElementById('editFamilyOccupation').value = member.occupation || '';
    document.getElementById('editFamilyContact').value = member.contact_no || '';

    console.log('Form populated, showing modal...'); // Debug

    // Show edit modal
    try {
        const modalElement = document.getElementById('editFamilyModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        console.log('Modal shown successfully'); // Debug
    } catch (error) {
        console.error('Error showing modal:', error);
        showAlert('Error opening edit form', 'danger');
    }
}

    function deleteFamilyMember(id) {
        if (!confirm('Are you sure you want to delete this family member?')) {
            return;
        }

        fetch('{{ route("family.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                family_id: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload family members
                loadFamilyMembers();
                showAlert('Family member deleted successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to delete family member');
            }
        })
        .catch(error => {
            console.error('Error deleting family member:', error);
            showAlert('Error: ' + error.message, 'danger');
        });
    }

    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.getElementById('familyListBody').prepend(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    const messageContainer = document.getElementById('profileMessageContainer');

    // Load profile data when page loads
    loadProfileData();

    // Handle form submission
    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        updateProfile();
    });

    // Auto-calculate age from birthdate
    document.getElementById('bdate').addEventListener('change', function() {
        calculateAge(this.value);
    });

    function loadProfileData() {
        fetch('{{ route("profile.get") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.user) {
                populateForm(data.user);
                // Removed the success message here
            } else {
                throw new Error(data.message || 'Failed to load profile data');
            }
        })
        .catch(error => {
            console.error('Error loading profile:', error);
            showMessage('Error loading profile data: ' + error.message, 'error');
        });
    }

    function populateForm(user) {
        // Set form values
        document.getElementById('lname').value = user.lname || '';
        document.getElementById('fname').value = user.fname || '';
        document.getElementById('mi').value = user.mi || '';
        document.getElementById('age').value = user.age || '';
        
        // Set sex select
        if (user.sex) {
            document.getElementById('sex').value = user.sex;
        }
        
        // Format and set birthdate
        if (user.bdate) {
            const birthdate = new Date(user.bdate);
            if (!isNaN(birthdate.getTime())) {
                const formattedDate = birthdate.toISOString().split('T')[0];
                document.getElementById('bdate').value = formattedDate;
            }
        }
        
        document.getElementById('contact_no').value = user.contact_no || '';
        document.getElementById('email').value = user.email || '';
        document.getElementById('address').value = user.address || '';
        document.getElementById('occupation').value = user.occupation || '';
    }

    function calculateAge(birthdate) {
        if (!birthdate) return;
        
        const birthDate = new Date(birthdate);
        const today = new Date();
        
        if (isNaN(birthDate.getTime())) return;
        
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        if (age >= 0 && age <= 120) {
            document.getElementById('age').value = age;
        }
    }

    function updateProfile() {
        const formData = new FormData(profileForm);
        const submitButton = profileForm.querySelector('button[type="submit"]');
        
        // Validate required fields
        const requiredFields = ['lname', 'fname', 'email', 'age', 'bdate', 'contact_no', 'address', 'occupation', 'sex'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            showMessage('Please fill in all required fields', 'error');
            return;
        }
        
        // Validate email format
        const email = document.getElementById('email').value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showMessage('Please enter a valid email address', 'error');
            document.getElementById('email').classList.add('is-invalid');
            return;
        }
        
        // Validate phone number (11 digits for PH)
        const contactNo = document.getElementById('contact_no').value;
        if (!/^\d{11}$/.test(contactNo)) {
            showMessage('Please enter a valid 11-digit phone number', 'error');
            document.getElementById('contact_no').classList.add('is-invalid');
            return;
        }
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';
        
        fetch('{{ route("profile.update") }}', {
            method: 'POST',
            body: formData,
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
                showMessage(data.message || 'Profile updated successfully!', 'success');
                // Reload profile data to ensure consistency
                setTimeout(() => loadProfileData(), 1000);
            } else {
                throw new Error(data.message || 'Failed to update profile');
            }
        })
        .catch(error => {
            console.error('Error updating profile:', error);
            showMessage('Error: ' + error.message, 'error');
        })
        .finally(() => {
            // Reset button state
            submitButton.disabled = false;
            submitButton.textContent = 'Save Changes';
        });
    }

    function showMessage(message, type) {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'info': 'alert-info',
            'warning': 'alert-warning'
        }[type] || 'alert-info';
        
        messageContainer.innerHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `;
        
        // Auto-hide success and info messages after 5 seconds
        if (type === 'success' || type === 'info') {
            setTimeout(() => clearMessage(), 5000);
        }
    }

    function clearMessage() {
        messageContainer.innerHTML = '';
    }

    // Real-time validation
    const inputs = profileForm.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});
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

// Logout modal
const logoutBtn = document.getElementById('logoutBtn');
const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

logoutBtn.addEventListener('click',(e)=>{
  e.preventDefault();
  const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
  logoutModal.show();
});
confirmLogoutBtn.addEventListener('click',()=>{
  window.location='{{route('page.index')}}';
});



// Toggle password visibility
document.querySelectorAll(".toggle-password").forEach(icon => {
  icon.addEventListener("click", () => {
    const targetId = icon.getAttribute("data-target");
    const input = document.getElementById(targetId);

    if (input.type === "password") {
      input.type = "text";
      icon.src = "{{url('img/show.png')}}";
    } else {
      input.type = "password";
      icon.src = "{{url('img/hide.png')}}";
    }
  });
});
</script>

</body>
</html>
