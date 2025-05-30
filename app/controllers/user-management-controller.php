<?php
require_once('../models/userModel.php');

header('Content-Type: application/json');

function isValidName($name)
{
    for ($i = 0; $i < strlen($name); $i++) {
        $ch = $name[$i];
        if (!(($ch >= 'a' && $ch <= 'z') || ($ch >= 'A' && $ch <= 'Z') || $ch === '.' || $ch === '-')) {
            return false;
        }
    }
    return true;
}

function isDigitsOnly($str)
{
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] < '0' || $str[$i] > '9') {
            return false;
        }
    }
    return true;
}

$data = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['action'])) {
    if ($data['action'] === 'search') {
        $email = trim($data['searchEmail'] ?? '');

        if ($email === '') {
            $response['message'] = 'Email field is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Invalid email address';
        } else {
            $user = searchByMail($email);
            if ($user) {
                $response = ['success' => true, 'user' => $user];
            } else {
                $response['message'] = 'User not found';
            }
        }

    } elseif ($data['action'] === 'update') {
        $email = trim($data['email'] ?? '');
        $fname = trim($data['fname'] ?? '');
        $lname = trim($data['lname'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $gender = $data['gender'] ?? '';
        $dob = $data['dob'] ?? '';
        $address = trim($data['address'] ?? '');
        $account_status = $data['account_status'] ?? '';
        $role = $data['role'] ?? '';
        $valid = true;
        $error = "";

        if ($fname === '') {
            $error = "First name is required";
            $valid = false;
        } elseif (!isValidName($fname)) {
            $error = "First name must contain only letters";
            $valid = false;
        } elseif ($lname === '') {
            $error = "Last name is required";
            $valid = false;
        } elseif (!isValidName($lname)) {
            $error = "Last name must contain only letters";
            $valid = false;
        } elseif ($phone === '') {
            $error = "Phone number is required";
            $valid = false;
        } elseif (!isDigitsOnly($phone)) {
            $error = "Phone number must be digits only";
            $valid = false;
        } elseif (strlen($phone) < 6) {
            $error = "Phone number must be at least 6 digits";
            $valid = false;
        } elseif ($gender === '' || !in_array($gender, ['0', '1'])) {
            $error = "Invalid gender selected";
            $valid = false;
        } elseif ($address === '') {
            $error = "Address is required";
            $valid = false;
        } elseif ($dob === '') {
            $error = "Date of birth is required";
            $valid = false;
        } elseif (strtotime($dob) > strtotime('-12 years')) {
            $error = "User must be at least 12 years old";
            $valid = false;
        } elseif (!in_array($account_status, ['0', '2'])) {
            $error = "Invalid account status";
            $valid = false;
        } elseif (!in_array($role, ['admin', 'user'])) {
            $error = "Invalid role selected";
            $valid = false;
        }

        if ($valid) {
            $updated = updateUserInfo_byAdmin($email, $fname, $lname, $phone, $gender, $dob, $address, $account_status, $role);
            if ($updated) {
                $response = [
                    'success' => true,
                    'message' => 'User updated successfully!',
                    'user' => $updated
                ];
            } else {
                $response['message'] = 'Error updating user.';
            }
        } else {
            $response['message'] = $error;
        }
    }
}

echo json_encode($response);
