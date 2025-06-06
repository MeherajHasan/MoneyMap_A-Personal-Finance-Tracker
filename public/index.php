<?php
    require_once('../app/models/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap | Personal Finance Tracker</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="assets/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="loader">
        <div class="loader-icon"></div>
    </div>

    <header>
        <nav>
            <ul>
                <li><a href="#features">Features</a></li>
                <li><a href="../app/views/landing/about.html">About</a></li>
                <li><a href="../app/views/landing/testimonial.html">Testimonials</a></li>
                <li><a href="../app/views/contact/contact.php">Contact</a></li>
                <li><a href="../app/views/auth/login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        
        <div class="logo">
            <img src="../public/assets/fullLogo.png" alt="MoneyMap-icon">
        </div>
        <section class="hero">
            <h2>Take Control of Your Finances</h2>
            <p>Track expenses, set budgets, achieve your goals — all in one place.</p>
            <a href="../app/views/auth/signup.php" class="cta-btn">Get Started</a>
        </section>

        <section id="features" class="features">
            <h2>Features</h2>
            <div class="feature-list">
                <div class="feature-item">
                    <i class="fas fa-wallet fa-2x"></i>
                    <h3>Expense Tracking</h3>
                    <p>Keep a close eye on where your money goes.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-line fa-2x"></i>
                    <h3>Budget Management</h3>
                    <p>Set monthly budgets and track your progress easily.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-bullseye fa-2x"></i>
                    <h3>Goal Setting</h3>
                    <p>Plan for savings, investments, and big purchases.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-pie fa-2x"></i>
                    <h3>Data Visualization</h3>
                    <p>Understand your finances with clear charts and graphs.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include '../app/views/header-footer/footer.php' ?>

    <script src="loader.js"></script>
</body>

</html>