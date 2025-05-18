<header class="header">
    <div class="container">
        <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
        <nav class="nav">
            <a href="../dashboard/dashboard.php">Dashboard</a>
            <a href="../expense/expense-dashboard.php">Expenses</a>
            <a href="../budget/budget-dashboard.php">Budget</a>
            <a href="../bills/bill-dashboard.php">Bills</a>
            <a href="../debt/debt-dashboard.php">Debt</a>
            <a href="../savings/savings-dashboard.php">Savings</a>
            <a href="../reports/report.php">Reports</a>
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
        color: #1B263B;
        line-height: 1.6;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    .header {
        background-color: #0D1B2A;
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