<header class="header">
    <div class="container">
        <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
        <nav class="nav">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="user-management.php">User Management</a>
            <a href="category-management.php">Category Management</a>
            <a href="data-oversight.php">Data Oversight</a>
            <a href="backup.php">Backup & Export</a>
            <a href="contact-response.php">Contact Response</a>
            <a href="../../controllers/auth/logout.php">Logout</a>
        </nav>
    </div>
</header>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f8;
        color: #4a0d0d;
        line-height: 1.6;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    .header {
        background-color: #4a0d0d;
        padding: 1rem 0;
    }

    .header .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .logo {
        width: 350px;
        height: auto;
        display: block;
        margin-bottom: 1rem;
    }

    .nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.2rem;
    }

    .nav a {
        color: #ffffff;
        font-weight: 500;
        transition: color 0.3s;
    }

    .nav a:hover {
        color: #4FC3F7;
    }
</style>