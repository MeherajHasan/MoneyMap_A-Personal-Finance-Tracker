<?php
    if(isset($_POST['submit'])){
        $src = $_FILES['photo']['tmp_name'];
        $des = "../../../uploads/".$_FILES['photo']['name'];
    }

    if(move_uploaded_file($src, $des)){
        echo "<script>
            if (confirm('Registration successful! Click OK to proceed to login page.')) {
                window.location.href = '../../views/auth/login.php';
            }
        </script>";
    } else {
        echo "<script>
            alert('Error: Image upload failed. Please try again.');
            window.history.back();
        </script>";
    }
?>
