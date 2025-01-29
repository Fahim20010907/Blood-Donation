<?php
include 'connect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Start a transaction to ensure all related records are deleted together
    $conn->begin_transaction();

    try {
        // Step 1: Delete from the RECEIVE table first since it references PATIENT
        $stmt_receive = $conn->prepare("DELETE FROM receive WHERE P_ID = ?");
        $stmt_receive->bind_param("i", $user_id);
        $stmt_receive->execute();

        // Step 2: Delete from the DONATE table
        $stmt_donate = $conn->prepare("DELETE FROM donate WHERE D_ID = ?");
        $stmt_donate->bind_param("i", $user_id);
        $stmt_donate->execute();

        // Step 3: Delete from the DONOR table
        $stmt_donor = $conn->prepare("DELETE FROM donor WHERE D_ID = ?");
        $stmt_donor->bind_param("i", $user_id);
        $stmt_donor->execute();

        // Step 4: Delete from the PATIENT table
        $stmt_patient = $conn->prepare("DELETE FROM patient WHERE P_ID = ?");
        $stmt_patient->bind_param("i", $user_id);
        $stmt_patient->execute();

        // Step 5: Delete from the MEMBER table
        $stmt_member = $conn->prepare("DELETE FROM member WHERE member_id = ?");
        $stmt_member->bind_param("i", $user_id);
        $stmt_member->execute();

        // Step 6: Finally, delete from the USER table
        $stmt_user = $conn->prepare("DELETE FROM user WHERE User_id = ?");
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();

        // Commit the transaction if all deletions were successful
        $conn->commit();

        echo "<script>alert('User deleted successfully!'); window.location.href='manage_users.php';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();
        echo "Error deleting user: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
?>
