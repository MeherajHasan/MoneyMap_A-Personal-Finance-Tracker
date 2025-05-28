<?php
require_once('../../controllers/adminAuth.php');
require_once('../../models/contactModel.php');

$newUserMessages = getNewMessagesFromUsers();
$repliedUserMessages = getRepliedMessagesFromUsers();
$newVisitorMessages = getNewMessagesFromVisitors();
$repliedVisitorMessages = getRepliedMessagesFromVisitors();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['messageID'])) {
        require_once('../../models/contactModel.php');
        $messageID = $_POST['messageID'];

        // DELETE ACTION
        if (isset($_POST['action']) && $_POST['action'] === 'delete') {
            $deleteStatus = deleteContactMessage($messageID);
            if ($deleteStatus) {
                header("Location: contact-response.php?success=Message deleted successfully.");
            } else {
                header("Location: contact-response.php?error=Failed to delete message.");
            }
            exit;
        }

        // REPLY ACTION
        if (isset($_POST['action']) && $_POST['action'] === 'reply') {
            $replyStatus = replyMessage($messageID);
            if ($replyStatus) {
                header("Location: contact-response.php?success=Message replied successfully.");
            } else {
                header("Location: contact-response.php?error=Failed to reply message.");
            }
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Responses - Admin Panel</title>
    <link rel="stylesheet" href="../../styles/admin/contact-response.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <div class="container">
        <h2>New Support Messages</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Response Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($newUserMessages) > 0): ?>
                    <?php while ($msg = mysqli_fetch_assoc($newUserMessages)): ?>
                        <tr>
                            <td><?= $msg['user_id']; ?></td>
                            <td><?= $msg['full_name']; ?></td>
                            <td><?= $msg['email']; ?></td>
                            <td><?= $msg['message']; ?></td>
                            <td><?= $msg['created_at']; ?></td>
                            <td>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" style="display:inline;">
                                    <input type="hidden" name="messageID" value="<?= $msg['id']; ?>">
                                    <input type="hidden" name="action" value="reply">
                                    <button
                                        type="button"
                                        class="btn btn-reply"
                                        onclick="handleReply(<?= $msg['id'] ?>, '<?= addslashes($msg['email']) ?>', '<?= addslashes($msg['subject']) ?>')">
                                        Reply
                                    </button>

                                </form>

                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" style="display:inline;">
                                    <input type="hidden" name="messageID" value="<?= $msg['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this message?');">Delete</button>
                                </form>


                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No new user messages.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h2>Replied Support Messages</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Response Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($repliedUserMessages) > 0): ?>
                    <?php while ($msg = mysqli_fetch_assoc($repliedUserMessages)): ?>
                        <tr>
                            <td><?= $msg['user_id']; ?></td>
                            <td><?= $msg['full_name']; ?></td>
                            <td><?= $msg['email']; ?></td>
                            <td><?= $msg['message']; ?></td>
                            <td><?= $msg['created_at']; ?></td>
                            <td>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" style="display:inline;">
                                    <input type="hidden" name="messageID" value="<?= $msg['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this message?');">Delete</button>
                                </form>


                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No replied user messages.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h2>New Contact Messages</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Response Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($newVisitorMessages) > 0): ?>
                    <?php while ($msg = mysqli_fetch_assoc($newVisitorMessages)): ?>
                        <tr>
                            <td><?= $msg['full_name']; ?></td>
                            <td><?= $msg['email']; ?></td>
                            <td><?= $msg['message']; ?></td>
                            <td><?= $msg['created_at']; ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-reply"
                                    onclick="handleReply(<?= $msg['id'] ?>, '<?= addslashes($msg['email']) ?>', '<?= addslashes($msg['subject']) ?>')">
                                    Reply
                                </button>


                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" style="display:inline;">
                                    <input type="hidden" name="messageID" value="<?= $msg['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this message?');">Delete</button>
                                </form>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No new visitor messages.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h2>Replied Contact Messages</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Response Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($repliedVisitorMessages) > 0): ?>
                    <?php while ($msg = mysqli_fetch_assoc($repliedVisitorMessages)): ?>
                        <tr>
                            <td><?= $msg['full_name']; ?></td>
                            <td><?= $msg['email']; ?></td>
                            <td><?= $msg['message']; ?></td>
                            <td><?= $msg['created_at']; ?></td>
                            <td>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" style="display:inline;">
                                    <input type="hidden" name="messageID" value="<?= $msg['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this message?');">Delete</button>
                                </form>


                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No replied visitor messages.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include '../header-footer/admin-footer.php'; ?>

    <script src="../../validation/admin/contact-response.js"></script>
</body>

</html>