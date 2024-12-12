<?php
require './classes/account.class.php';
require './classes/database.class.php';
session_start();

global $pdo;
$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Separate events into upcoming and past
$currentDate = date('Y-m-d');
$upcomingEvents = [];
$pastEvents = [];

foreach ($events as $event) {
    if ($event['event_date'] >= $currentDate) {
        $upcomingEvents[] = $event;
    } else {
        $pastEvents[] = $event;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .event-calendar-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin: 30px 0;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light px-4">
        <div class="container-fluid">
            <img src="images/CCS logo.jpg" alt="CCS Logo" class="navbar-logo">
            <a class="navbar-brand" href="index.php">Ocesion Event Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav me-5">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events_index.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="account/login.php">Log In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container mt-5">
<div class="event-calendar-card text-center mb-5">
    <h3 class="display-6">Events Calendar</h3>
</div>

<div class="text-center mb-3">
    <div class="input-group w-50 mx-auto">
        <span class="input-group-text bg-success text-white">
            <img src="assets/search.svg" alt="Search Icon" width="16" height="16" style="filter: invert(1);">
        </span>
        <input 
            type="text" 
            id="searchBar" 
            class="form-control" 
            placeholder="Search for events by title, description, or organizers..."
            onkeyup="filterEvents()"
        >
    </div>
</div>

<br>

<div class="text-center mb-3">
    <button class="btn btn-success me-2" id="show-upcoming">Upcoming Events</button>
    <button class="btn btn-secondary" id="show-past">Past Events</button>
</div>

<div id="upcoming-events" class="row g-4">
    <?php if (!empty($upcomingEvents)): ?>
        <?php foreach ($upcomingEvents as $event): ?>
            <?php
                // Format date and time
                $formattedDate = date('F j, Y', strtotime($event['event_date']));
                $formattedStartTime = date('g:i A', strtotime($event['starttime']));
                $formattedEndTime = date('g:i A', strtotime($event['endtime']));
            ?>
            <div class="col-md-4 event-card" data-search="<?= htmlspecialchars(strtolower($event['title'] . ' ' . $event['description'] . ' ' . $event['organizers'])) ?>">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>
                        <p><strong>Organizers:</strong> <?= htmlspecialchars($event['organizers']) ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($formattedDate) ?></p>
                        <p><strong>Time:</strong> <?= htmlspecialchars($formattedStartTime) ?> - <?= htmlspecialchars($formattedEndTime) ?></p>
                        <p><strong>Venue:</strong> <?= htmlspecialchars($event['venue']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center text-danger">No upcoming events found.</p>
    <?php endif; ?>
</div>
<div id="past-events" class="row g-4 d-none">
    <?php if (!empty($pastEvents)): ?>
        <?php foreach ($pastEvents as $event): ?>
            <?php
                // Format date and time
                $formattedDate = date('F j, Y', strtotime($event['event_date']));
                $formattedStartTime = date('g:i A', strtotime($event['starttime']));
                $formattedEndTime = date('g:i A', strtotime($event['endtime']));
            ?>
            <div class="col-md-4 event-card" data-search="<?= htmlspecialchars(strtolower($event['title'] . ' ' . $event['description'] . ' ' . $event['organizers'])) ?>">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>
                        <p><strong>Organizers:</strong> <?= htmlspecialchars($event['organizers']) ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($formattedDate) ?></p>
                        <p><strong>Time:</strong> <?= htmlspecialchars($formattedStartTime) ?> - <?= htmlspecialchars($formattedEndTime) ?></p>
                        <p><strong>Venue:</strong> <?= htmlspecialchars($event['venue']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center text-danger">No past events found.</p>
    <?php endif; ?>
</div>


</div>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    const showUpcoming = document.getElementById('show-upcoming');
    const showPast = document.getElementById('show-past');
    const upcomingEvents = document.getElementById('upcoming-events');
    const pastEvents = document.getElementById('past-events');

    showUpcoming.addEventListener('click', () => {
        upcomingEvents.classList.remove('d-none');
        pastEvents.classList.add('d-none');
    });

    showPast.addEventListener('click', () => {
        pastEvents.classList.remove('d-none');
        upcomingEvents.classList.add('d-none');
    });
    function filterEvents() {
    const searchInput = document.getElementById('searchBar').value.toLowerCase();
    const eventCards = document.querySelectorAll('.event-card');

    eventCards.forEach(card => {
        const searchText = card.getAttribute('data-search');
        if (searchText.includes(searchInput)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
<?php include './includes/_footer.php'; ?>
</body>
</html>
