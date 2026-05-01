<?php
require_once __DIR__ . '/auth.php';

auth_redirect_if_logged_in('index.php');

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $errorMessage = 'Enter both email and password.';
    } else {
        $conn = get_db_connection();

        if (!$conn) {
            $errorMessage = 'Database connection failed.';
        } elseif (!auth_ensure_users_table($conn)) {
            $errorMessage = 'Login setup is incomplete. Please import wheelzonrent_database.sql again.';
        } else {
            $stmt = mysqli_prepare(
                $conn,
                'SELECT id, name, email, password_hash, role FROM users WHERE email = ? AND is_active = 1 LIMIT 1'
            );

            if (!$stmt) {
                $errorMessage = 'Login is temporarily unavailable.';
            } else {
                mysqli_stmt_bind_param($stmt, 's', $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $userId, $userName, $userEmail, $passwordHash, $userRole);
                $hasUser = mysqli_stmt_fetch($stmt);
                $user = $hasUser ? [
                    'id' => $userId,
                    'name' => $userName,
                    'email' => $userEmail,
                    'password_hash' => $passwordHash,
                    'role' => $userRole,
                ] : null;
                $storedHash = is_string($passwordHash) ? $passwordHash : '';

                if ($user && $storedHash !== '' && password_verify($password, $storedHash)) {
                    auth_login_user($user);
                    header('Location: index.php');
                    exit;
                }

                $errorMessage = 'Invalid email or password.';
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Safar Rentals</title>
    <link rel="icon" type="image/png" href="images/SfExpress.png">
    <link rel="stylesheet" href="poppins.css" type="text/css" media="all">
    <link rel="stylesheet" href="montserrat.css" type="text/css" media="all">
    <style>
        :root {
            --bg-1: #0f172a;
            --bg-2: #111827;
            --panel: rgba(10, 18, 35, 0.84);
            --panel-border: rgba(255, 255, 255, 0.12);
            --text: #f8fafc;
            --muted: #cbd5e1;
            --accent: #00afe5;
            --accent-dark: #006b8b;
            --danger: #ff6b6b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(0, 175, 229, 0.25), transparent 30%),
                radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.16), transparent 32%),
                linear-gradient(160deg, var(--bg-1), var(--bg-2));
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .shell {
            width: min(960px, 100%);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 24px;
            align-items: stretch;
        }

        .hero,
        .panel {
            border: 1px solid var(--panel-border);
            border-radius: 24px;
            overflow: hidden;
            backdrop-filter: blur(16px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.28);
        }

        .hero {
            padding: 40px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 34px;
        }

        .brand img {
            width: 58px;
            height: 58px;
            object-fit: contain;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            padding: 8px;
        }

        .eyebrow {
            display: inline-block;
            color: var(--accent);
            font-size: 0.85rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 16px;
            font-family: 'Montserrat', sans-serif;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(2rem, 4vw, 3.75rem);
            line-height: 1.05;
            margin: 0 0 18px;
        }

        .hero p {
            color: var(--muted);
            line-height: 1.75;
            max-width: 38ch;
            margin: 0;
        }

        .feature {
            margin-top: 28px;
            padding: 18px 20px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.06);
            color: var(--muted);
            line-height: 1.6;
        }

        .panel {
            background: var(--panel);
            padding: 32px;
        }

        .panel h2 {
            margin: 0 0 10px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.9rem;
        }

        .panel .subtext {
            margin: 0 0 26px;
            color: var(--muted);
            line-height: 1.6;
        }

        .alert {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(255, 107, 107, 0.14);
            border: 1px solid rgba(255, 107, 107, 0.28);
            color: #ffd0d0;
        }

        label {
            display: block;
            margin: 16px 0 8px;
            font-size: 0.92rem;
            color: var(--muted);
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
            outline: none;
            font-size: 1rem;
        }

        input:focus {
            border-color: rgba(0, 175, 229, 0.85);
            box-shadow: 0 0 0 4px rgba(0, 175, 229, 0.12);
        }

        .actions {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        button,
        .secondary {
            border: 0;
            border-radius: 14px;
            padding: 14px 18px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        button {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white;
            min-width: 140px;
        }

        .secondary {
            color: var(--text);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        button:hover,
        .secondary:hover {
            transform: translateY(-1px);
        }

        .footer-note {
            margin-top: 22px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .footer-note a {
            color: var(--accent);
            text-decoration: none;
        }

        @media (max-width: 880px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .hero,
            .panel {
                padding: 28px;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="hero">
            <div>
                <div class="brand">
                    <img src="images/SfExpress.png" alt="Safar Rentals logo">
                    <div>
                        <div class="eyebrow">Safar Rentals</div>
                        <div style="color: var(--muted);">Secure access for returning users</div>
                    </div>
                </div>
                <h1>Sign in and continue to the home page.</h1>
                <p>Use your registered account to open the Safar Rentals dashboard, browse services, and return to <strong>index.php</strong> after successful authentication.</p>
            </div>
            <div class="feature">
                Session-based authentication is enabled here. Your login is verified against the database and the session is regenerated before redirecting to the home page.
            </div>
        </section>

        <section class="panel">
            <h2>Login</h2>
            <p class="subtext">Enter your email and password to continue.</p>

            <?php if ($errorMessage !== ''): ?>
                <div class="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form method="post" action="login.php" autocomplete="on">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <div class="actions">
                    <button type="submit">Login</button>
                    <a class="secondary" href="index.php">Back to Home</a>
                </div>
            </form>

            <div class="footer-note">
                After logging in, you will be redirected to the home page automatically.
            </div>
        </section>
    </main>
</body>
</html>