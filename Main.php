<?php
$host = 'localhost';
$db = 'user_registration';
$user = 'root';
$pass = '';

// Establishing database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Retrieve form data and sanitize (assuming sanitized in the actual implementation)
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $additional_info = $_POST['additional_info'];
    $zip_code = $_POST['zip_code'];
    $place = $_POST['place'];
    $country = $_POST['country'];
    $code = $_POST['code'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Prepare SQL statement for insertion
    $sql = "INSERT INTO registration_users (user_title, user_first_name, user_last_name, user_birthday, user_gender, user_description, user_address, user_additional_info, user_zip_code, user_place, user_country, user_code, user_phone, user_email)
            VALUES ('$title', '$first_name', '$last_name', '$birthday', '$gender', '$description', '$address', '$additional_info', '$zip_code', '$place', '$country', '$code', '$phone', '$email')";

    // Execute SQL statement for insertion
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}

// Fetch gender options for dropdown
$sql = "SELECT gender FROM genders";
$result = $conn->query($sql);
$gender_options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gender_options .= "<option value='" . $row['gender'] . "'>" . $row['gender'] . "</option>";
    }
} else {
    $gender_options .= "<option value=''>No options available</option>";
}

// Fetch zip codes for dropdown
$sql = "SELECT zip_code FROM tr_zip";
$result = $conn->query($sql);
$zip_code_options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $zip_code_options .= "<option value='" . $row['zip_code'] . "'>" . $row['zip_code'] . "</option>";
    }
} else {
    $zip_code_options .= "<option value=''>No options available</option>";
}

// Fetch country codes for dropdown
$sql = "SELECT country_code FROM gen_mas_country";
$result = $conn->query($sql);
$country_code_options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $country_code_options .= "<option value='" . $row['country_code'] . "'>" . $row['country_code'] . "</option>";
    }
} else {
    $country_code_options .= "<option value=''>No options available</option>";
}

// Handle deletion of user record
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare SQL statement for deletion
    $delete_sql = "DELETE FROM registration_users WHERE user_id = $user_id";

    // Execute deletion query
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('User deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
    }
}

// Handle form submission for user update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    // Retrieve form data and sanitize (assuming sanitized in the actual implementation)
    $user_id = $_POST['user_id'];
    $title = $_POST['edit_title'];
    $first_name = $_POST['edit_first_name'];
    $last_name = $_POST['edit_last_name'];
    $email = $_POST['edit_email'];
    $phone = $_POST['edit_phone'];
    $company = $_POST['edit_company'];

    // Prepare SQL statement for update
    $update_sql = "UPDATE registration_users SET user_title='$title', user_first_name='$first_name', user_last_name='$last_name', user_email='$email', user_phone='$phone', user_title='$company' WHERE user_id=$user_id";

    // Execute SQL statement for update
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('User updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating user: " . $conn->error . "');</script>";
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        .form-group1, .form-group {
            margin-bottom: 15px;
        }
        img {
            height: 20px;
            width: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <h2>Register User</h2>
            <form id="registrationForm" method="post">
                <table border="1" class="table">
                    <tr>
                        <td>
                            <h3 style="color:Blue;">General Information</h3>
                            <div class="form-group1">
                                <select id="title" name="title" required class="form-control">
                                    <option value="" disabled selected>Title</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Ven">Ven</option>
                                </select>
                            </div>
                            <div class="form-group1">
                                <table border="0">
                                    <tr>
                                        <td>
                                            <input type="text" placeholder="First Name" id="first_name" name="first_name" required class="form-control"><br>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Last Name" id="last_name" name="last_name" required class="form-control"><br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group1">
                                <table border="0">
                                    <tr>
                                        <td>
                                            <label for="birthday">Birthday: </label>
                                            <input type="date" id="birthday" name="birthday" required class="form-control"><br>
                                        </td>
                                        <td>
                                            <label for="gender">Gender: </label>
                                            <select id="gender" name="gender" required class="form-control">
                                                <option value="" disabled selected>Gender</option>
                                                <?php echo $gender_options; ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group1">
                                <textarea id="description" placeholder="Description" name="description" class="form-control"></textarea><br>
                            </div>
                        </td>
                        <td style="background-color: blue">
                            <h3 style="color:white;">Contact Information</h3>
                            <div class="form-group">
                                <input type="text" placeholder="Address" id="address" name="address" required class="form-control"><br>
                            </div>
                            <div class="form-group">
                                <textarea id="additionalInformation" placeholder="Additional info" name="additional_info" class="form-control"></textarea><br>
                            </div>
                            <div class="form-group">
                                <table border="0">
                                    <tr>
                                        <td>
                                            <select id="zip_code" name="zip_code" required class="form-control">
                                                <option value="" disabled selected>Zip Code</option>
                                                <?php echo $zip_code_options; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Place" id="place" name="place" required class="form-control"><br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <select id="code" name="code" required class="form-control">
                                    <option value="" disabled selected>Country Code</option>
                                    <?php echo $country_code_options; ?>
                                </select><br>
                            </div>
                            <div class="form-group">
                                <table border="0">
                                    <tr>
                                        <td>
                                            <input type="text" placeholder="Code" id="country" name="country" required class="form-control"><br>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Phone" id="phone" name="phone" required class="form-control"><br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <input type="email" placeholder="Email" id="email" name="email" required class="form-control"><br>
                            </div>
                            <input type="radio" id="radio" name="radio">I do accept the <u><a href="" target="_blank">Terms and conditions</a></u> of your site<br><br>
                        </td>
                    </tr>
                </table>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#viewUsersModal">View Users</button>
            </form>
        </div>
    </div>
    
    <!-- View Users Modal -->
    <div class="modal" id="viewUsersModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table border="" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Company</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php
                            // Reconnect to database
                            $conn = new mysqli($host, $user, $pass, $db);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch users from database
                            $sql = "SELECT * FROM registration_users";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['user_first_name']} {$row['user_last_name']}</td>
                                            <td>{$row['user_email']}</td>
                                            <td>{$row['user_phone']}</td>
                                            <td>{$row['user_title']}</td>
                                            <td>
                                                <a href='#' class='edit-link' data-toggle='modal' data-target='#editUserModal' data-id='{$row['user_id']}' data-title='{$row['user_title']}' data-first_name='{$row['user_first_name']}' data-last_name='{$row['user_last_name']}' data-email='{$row['user_email']}' data-phone='{$row['user_phone']}' data-company='{$row['user_title']}'><img src='edit-solid.svg' alt='Edit'></a>
                                                <a href='?action=delete&id={$row['user_id']}' onclick='return confirm(\"Are you sure you want to delete this user?\")'><img src='trash-alt-solid.svg' alt='Delete'></a>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No users found</td></tr>";
                            }

                            // Close database connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" id="edit_title" name="edit_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_first_name">First Name</label>
                            <input type="text" id="edit_first_name" name="edit_first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_last_name">Last Name</label>
                            <input type="text" id="edit_last_name" name="edit_last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" id="edit_email" name="edit_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone">Phone</label>
                            <input type="text" id="edit_phone" name="edit_phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_company">Company</label>
                            <input type="text" id="edit_company" name="edit_company" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Reload user table when modal is shown
            $('#viewUsersModal').on('show.bs.modal', function() {
                $.ajax({
                    url: 'fetch_users.php',
                    method: 'GET',
                    success: function(response) {
                        $('#userTableBody').html(response);
                    }
                });
            });

            // Populate edit user modal with data
            $('.edit-link').on('click', function() {
                var userId = $(this).data('id');
                var userTitle = $(this).data('title');
                var firstName = $(this).data('first_name');
                var lastName = $(this).data('last_name');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var company = $(this).data('company');

                $('#user_id').val(userId);
                $('#edit_title').val(userTitle);
                $('#edit_first_name').val(firstName);
                $('#edit_last_name').val(lastName);
                $('#edit_email').val(email);
                $('#edit_phone').val(phone);
                $('#edit_company').val(company);
            });
        });
    </script>
</body>
</html>
