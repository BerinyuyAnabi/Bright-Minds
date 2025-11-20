<?php

echo "Starting menu page...\n";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu - Bright Minds</title>
<link rel="stylesheet" href="menu.css">
</head>
<body>

<div class="menu">
    <h1 id="welcomeMessage">Welcome, Explorer!</h1>
    <div class="menu_list">
        <button class="btn-game" onclick="window.location.href='backend/processor.php?key=games'">🎮 Play a Game</button>
        <button class="btn-quiz" onclick="window.location.href='backend/processor.php?key=quiz'">📝 Take a Quiz</button>
        <button class="btn-story" onclick="window.location.href='backend/processor.php?key=stories'">📖 Listen to a Story</button>
        <button class="btn-parent" onclick="window.location.href='backend/processor.php?key=parentDashboard'">👨‍👩‍👧 Parent Dashboard</button>
        <button class="btn-logout" onclick="logout()">🚪 Logout</button>
    </div>
</div>

<script>
    // Check if user is logged in
    window.onload = function() {
        const userData = sessionStorage.getItem('brightMindsUser');
        if (userData) {
            const user = JSON.parse(userData);
            document.getElementById('welcomeMessage').textContent = `Welcome, ${user.username}! ${user.avatarName}`;
        } else {
            // Redirect to login if not logged in
            window.location.href = 'index.html';
        }
    };

    function logout() {
        if (confirm('Are you sure you want to logout?')) {
            sessionStorage.removeItem('brightMindsUser');
            window.location.href = 'index.html';
        }
    }
</script>

</body>

</html>
