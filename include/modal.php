<script>
    const currentPage = "<?= basename($_SERVER['PHP_SELF']) ?>";
</script>

<!-- Enter Ticket Modal -->
<div class="modal fade" id="enterTicketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="enterTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Larger modal on bigger screens -->
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="enterModalLabel">Enter Ticket</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addTicketForm">
        <div class="modal-body">
          <div class="row">
            <div class="col-4 mb-3">
              <label for="ticketLink" class="enterFormLabel">Link <span class="text-danger">***</span>:</label>
              <input placeholder="Enter Ticket Link..." class="form-control mb-3" type="text" id="link" name="link" oninput="checkDuplicateLinks()" required>
            </div>
            <div class="col-4 mb-3">
              <label for="ticketTitle" class="enterFormLabel">Title:</label>
              <input placeholder="Enter Ticket Title..." class="form-control mb-3" type="text" id="ticketTitle" name="title">
            </div>
            <div class="col-4 mb-3">
              <label for="status" class="enterFormLabel ">Select Status<span class="text-danger">***</span>:</label>
              <select name="status" id="status" class="form-select mb-3">
                <option value="OPEN">OPEN</option>
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="DONE AWAITING CONFIRMATION">DONE AWAITING CONFIRMATION</option>
                <option value="COMPLETED">COMPLETED</option>
                <option value="REJECTED">REJECTED</option>
                <option value="CLOSED">CLOSED</option>
              </select>
            </div>
            <div class="col-12 mb-3">
              <label for="ticketDetails" class="enterFormLabel">Details:</label>
              <textarea placeholder="Enter Ticket Details..." class="form-control mb-3" id="ticketDetails" name="details"></textarea>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label for="fromDate" class="enterFormLabel">From:</label>
              <input class="form-control" type="date" id="fromDate" name="fromDate">
            </div>
            <div class="col-12 col-md-6">
              <label for="toDate" class="enterFormLabel">To:</label>
              <input class="form-control" type="date" id="toDate" name="toDate">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Submit" id="submit" class="btn btn-primary btn-round" style="background-color: rgb(44, 44, 102); border: none;">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- // Enter Ticket Model -->

<!-- View Ticket Modal -->
<div class="modal fade" id="viewTicketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="viewTicketModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Added modal-lg for larger screens -->
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5 d-flex align-items-center">
          <i class="bi bi-ticket-detailed me-2"></i> Ticket Information
        </h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="viewTicketForm">
        <div class="modal-body">
          <!-- Section 1: Basic Information -->
          <h5 class="text-primary">Basic Information</h5>
          <hr>
          <div class="row">
            <div class="col-6 mb-3">
              <label for="ticket_id" class="form-label">ID:</label>
              <input type="text" class="form-control" id="ticket_id" disabled>
            </div>
            <div class="col-6 mb-3">
              <label for="links" class="form-label">Link:</label>
              <input type="text" class="form-control" id="links" disabled>
              <!-- <textarea class="form-control" id="links" rows="3" disabled></textarea> -->
            </div>
            <div class="col-12 mb-3">
              <label for="title" class="form-label">Title:</label>
              <textarea class="form-control" id="title" rows="3" disabled></textarea>
            </div>
          </div>

          <!-- Section 2: Status and Dates -->
          <h5 class="text-primary mt-4">Status and Dates</h5>
          <hr>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="status" class="form-label">Select Status:</label>
              <select class="form-select" id="status" disabled>
                <option value="OPEN">OPEN</option>
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="DONE AWAITING CONFIRMATION">DONE AWAITING CONFIRMATION</option>
                <option value="COMPLETED">COMPLETED</option>
                <option value="REJECTED">REJECTED</option>
                <option value="CLOSED">CLOSED</option>
              </select>
            </div>
            <div class="col-sm-6">
              <label for="vfromDate" class="form-label">From:</label>
              <input type="date" class="form-control" id="vfromDate" disabled>
            </div>
            <div class="col-sm-6">
              <label for="vtoDate" class="form-label">To:</label>
              <input type="date" class="form-control" id="vtoDate" disabled>
            </div>
          </div>

          <!-- Section 3: Ticket Details -->
          <h5 class="text-primary mt-4">Ticket Details</h5>
          <hr>
          <div class="row">
            <div class="col-12 mb-3">
              <label for="details" class="form-label">Details:</label>
              <textarea class="form-control" id="details" rows="3" disabled></textarea>
            </div>
          </div>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary w-100 w-md-auto" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- //View Ticket Modal -->

<!-- Update Ticket Modal -->
<div class="modal fade" id="updateTicketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="updateTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Larger modal on bigger screens -->
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="updateModalLabel">Update Ticket</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateTicketForm">
        <div class="modal-body">
          <div class="row">
            <div class="col-6 mb3">
              <label for="ticketID" class="enterFormLabel">ID:</label>
              <input class="form-control mb-3" type="text" id="uticket_id" disabled>
              <input class="form-control mb-3" type="hidden" id="dticket_id" name="ticket_id">
            </div>
            <div class="col-6 mb3">
              <label for="ticketLink" class="enterFormLabel">Link<span class="text-danger">***</span>:</label>
              <input class="form-control" type="text" id="ulink" name="link">
              <!-- <textarea class="form-control mb-3" style="height: 100px; resize:none;" id="ulink" name="link"></textarea> -->
            </div>
            <div class="col-12 mb3">
              <label for="ticketTitle" class="enterFormLabel">Title:</label>
              <textarea class="form-control mb-3" style="height: 100px; resize:none;" id="utitle" name="title"></textarea>
            </div>
            <div class="col-12 mb3">
              <label for="status" class="enterFormLabel ">Select Status<span class="text-danger">***</span>:</label>
              <select name="status" id="ustatus" class="form-select mb-3">
                <option value="OPEN">OPEN</option>
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="DONE AWAITING CONFIRMATION">DONE AWAITING CONFIRMATION</option>
                <option value="COMPLETED">COMPLETED</option>
                <option value="REJECTED">REJECTED</option>
                <option value="CLOSED">CLOSED</option>
              </select>
            </div>
            <div class="col-12 mb3">
              <label for="ticketDetails" class="enterFormLabel">Details:</label>
              <textarea class="form-control mb-3" id="udetails" name="details"></textarea>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label for="fromDate" class="enterFormLabel">From:</label>
              <input class="form-control" type="date" id="ufromDate" name="fromDate">
            </div>
            <div class="col-12 col-md-6">
              <label for="toDate" class="enterFormLabel">To:</label>
              <input class="form-control" type="date" id="utoDate" name="toDate">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="submit" id="update" class="btn btn-primary btn-round" style="background-color: rgb(104, 199, 104); border: none;" value="Save Changes">
          <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- // Update Tciket Modal -->

<!-- Add User -->
<div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="enterTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Larger modal on bigger screens -->
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="enterModalLabel">Add New User</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="registrationForm">
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input placeholder="Enter First Name" class="form-control" type="text" id="firstName" name="firstName" required>
          </div>

          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input placeholder="Enter Last Name" class="form-control" type="text" id="lastName" name="lastName" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="d-flex">
              <input placeholder="Enter Password" class="form-control password" type="text" name="password" style="width: 200px !important;" required>
              <button type="button" class="btn btn-primary ms-3 generatePassword" style="width: 100px !important;">Generate</button>
            </div>
          </div>

          <div class="mb-3">
            <label for="responsibility" class="form-label">Responsibility</label>
            <select name="responsibility" id="responsibility" class="form-select">
              <option value="admin">Admin</option>
              <option value="staff">Staff</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" id="addStaff" class="btn btn-primary btn-round" style="background-color: rgb(104, 199, 104); border: none;">Add</button>
        <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Add User -->

<!-- change Password -->
<div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="changePasswordForm">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
              <button type="button" class="btn btn-outline-secondary toggle-password" data-target="currentPassword">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="newPassword" name="newPassword" required>
              <button type="button" class="btn btn-outline-secondary toggle-password" data-target="newPassword">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
              <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirmNewPassword">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </div>
          <!-- <input type="hidden" name="who" id="who" value="<?= $who ?>"> -->
          <input type="hidden" name="staff_id" id="changeStaffId" value="<?= $staff_id ?>">
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>

      </div>
    </div>
  </div>
</div>
<!-- change Password -->

<!-- reset Password -->
<div class="modal fade" id="resetPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Larger modal on bigger screens -->
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="resetPasswordModalLabel">Reset Password</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="resetPasswordForm">
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="d-flex">
              <input placeholder="Enter Password" class="form-control password" type="text" name="password" style="width: 200px !important;" required>
              <button type="button" class="btn btn-primary ms-3 generatePassword" style="width: 100px !important;">Generate</button>
            </div>
          </div>
          <!-- Input Field -->
          <input type="hidden" name="staff_id" id="staff_id" class="staff_id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" id="resetPassword" class="btn btn-primary btn-round" style="background-color: rgb(104, 199, 104); border: none;">Reset Password</button>
        <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- reset Password -->